var ScormTracker = Class.create(Tracker, {
  initialize: function($super) {
    this.name= 'ScormTracker';
    this.apiAttempts=0;
    $super();    
  },
  
  maxApiAttempts: 10,
  completedStatus: cpda.course.config.tracker.scorm.completed_string || "passed",
  notAttemptedStatus: cpda.course.config.tracker.scorm.not_attempted_string || 'not attempted',
  incompleteStatus: cpda.course.config.tracker.scorm.incomplete_string || 'incomplete',
  
  keys: {
    'cpda_data': 'cmi.suspend_data',
    'cpda_bookmark' : 'cmi.core.lesson_location',
    'cpda_score': 'cmi.core.score.raw',
    'cpda_lesson_status': 'cmi.core.lesson_status',
    'cpda_student_name': 'cmi.core.student_name',
    'cpda_course_time': 'cmi.core.session_time'
  },

  start: function(){
    this._get_scorm_api();
    this._lms_init();
    this._get_data();
    
    this.onReady();
  },

  set: function($super, key, value){
    if(!this.active){ return; }

    var key_value_array = $super(key, value);
    this.api.LMSSetValue(this.keys[key_value_array[0]], key_value_array[1].toString()); 
    if(this._setCount >= this._maxSetCount){
      this.send();
    }

  },

  /**
    Records the current time and commits data to API
    
    Base Tracker will reset setCount
    
    Note: Cannot call Tracker#set in this function 
    may cause an infinite loop if setCount > maxSetCount
  */
  send: function($super){
    if(!this.active){ return; }
    
    this.recordCurrentTime();
    this.api.LMSCommit("");
    
    $super();
  },
  
  setComplete: function(){
    this.set('cpda_lesson_status', this.completedStatus);
    this.set('cpda_score', 100);
  },
  
  end: function(){
    if(this.active){
      this.api.LMSCommit("");
      this.api.LMSFinish("");
      this.active=false;
    }
  },
  
  alertHandler_: function(msg){
    alert(msg)
  },
  
  setAlertHandler: function(handler){
    this.alertHandler_ = handler;
  },
  
  toString: function(){
    return this.name;
  },

  _get_scorm_api: function(){
    var hasScormApi;

    hasScormApi = ScormTracker.ApiExists(window, this);
    
    if (!hasScormApi)
      hasScormApi = ScormTracker.ApiExists(window.opener, this);
      
    if (!hasScormApi)
      hasScormApi = ScormTracker.ApiExists(window.opener.top, this);
      

    if (!hasScormApi)
      hasScormApi = ScormTracker.ApiExists(window.top.opener, this);
      
    if (!hasScormApi)
      hasScormApi = ScormTracker.ApiExists(window.top.opener.document, this);
    
    // Now try the window opener opener
    if (!hasScormApi)
      hasScormApi = ScormTracker.ApiExists(window.opener.opener, this);

    if (!hasScormApi)
      hasScormApi = ScormTracker.ApiExists(window.opener.opener.top, this);

    if (!hasScormApi)
      hasScormApi = ScormTracker.ApiExists(window.opener.top.opener, this);
      
    if (!hasScormApi)
      hasScormApi = ScormTracker.ApiExists(window.opener.top.opener.document, this);
    
    if(!hasScormApi) {
      this.alertHandler_(ScormTracker.strings.MissingApiError);
      this.active = false;
    }
  },
  
  _find_scorm_api: function(win){
    this.log("this.apiAttempts="+this.apiAttempts);
    if(this.active){
      while((win.API == null) && (win.parent != null) && (win.parent != win) ) {
        this.apiAttempts++;
        if (this.apiAttempts > this.maxApiAttempts) {
          this.alertHandler_(ScormTracker.strings.NestedApiError);
          return null;
        }
        win = win.parent;
      }
      return win.API;
    }
  },
  
  _lms_init: function(){
    if(this.active){
      this.api.LMSInitialize("");
    }
  },
  
  _parseNumber: function(n){
    var num = parseInt(n, 10);
    if(isNaN(num)){
      return null;
    }
    return num;
  },
  
  _get_from_api: function(key){
    return this.api.LMSGetValue(this.keys[key]);
  },
  
  
  /**
    Loads initial data from api.
    
    Note: Since Tracker.Scorm#set always communicates with API so in order to set
    Tracker#data we need to set it manually on Tracker#data.set and not through 
    the tracker api.
  */
  _get_data: function() {
    var loc = this._parseNumber(this._get_from_api("cpda_bookmark"));
    if(loc){
      this.data.set("cpda_bookmark", loc);
    }
    
    var score = this._parseNumber(this._get_from_api("cpda_score"));
    if(score) {
      this.data.set("cpda_score", score);
    }
    
    var lessonStatus = this._get_from_api("cpda_lesson_status");
    if(lessonStatus == this.notAttemptedStatus){
      this.set('cpda_lesson_status', this.incompleteStatus);
    }
    
    this.data.set("cpda_student_name", this._get_from_api("cpda_student_name"));

    try{
      var cpda_data_hash = $H(unescape(this._get_from_api("cpda_data")).evalJSON(true));
      var cpda_data = cpda_data_hash.get('_cpda') ? cpda_data_hash : $H({'_cpda':true});
    }
    catch(e){
      this.log("error: "+e);
      var cpda_data = $H({'_cpda':true});
    }
    this.data.set('cpda_data',cpda_data);
    this.log('data object looks like: '+Object.inspect(this.data));
  },
  
  recordCurrentTime: function(){
    var now = this.course_timer.now_hms;
    this.data.set('cpda_course_time', now);
    this.api.LMSSetValue(this.keys['cpda_course_time'], now);
  }
  
});


/**
 * Checks to see if Scorm API exists
 * 
 * @param {Element} win Any html window.
 * @param {?ScormTracker} opt_scormTracker A scorm tracker to set the api to.
 * @return {Boolean} If API was found.
 */
ScormTracker.ApiExists = function(win, opt_scormTracker){
  var foundApi = false;
  var maxAttempts = 0;
  
  while(!foundApi && maxAttempts < 10) {
    /** 
     * In the case of third party LMS, this routine threw a permission error
     * Wrapped it in a try/catch to avoid halt
     * TODO: Not initialize ScormTracker on AICC-established courseware.
     */
    
    try{
      if(win != null && win.API) {
        foundApi = true;
        if (opt_scormTracker)
          opt_scormTracker.api = win.API;

      } else if (win != null) {
        win = win.parent;
      }

      ++maxAttempts;
    } catch(e) {
      maxAttempts = 10;
    }
  }
  
  return foundApi;
};


// TODO: move these to a global spot...
ScormTracker.strings = {
  MissingApiError: "Unable to find SCORM API adapter. Session will not be tracked",
  NestedApiError: "SCORM API too deeply nested: " + this.MissingApiError
};

/**
  ScormTracker needs to be explicitly set in query string or in html
*/
ScormTracker.resolve = function(query){
  if (ScormTracker.ApiExists(window))
    return true;
  if (ScormTracker.ApiExists(window.opener))
    return true;
  
  return false;
};

Tracker.register('scorm', ScormTracker);
