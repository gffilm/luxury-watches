var ScormTracker = Class.create(Tracker, {
  initialize: function($super, options) {
    this.name= 'scorm';
    this.params=Object.extend({
      find_attempts_before_fail: 10,
      completed_string: "passed"
    },options || {});
    
    this.find_attempts=0;
    $super(options);    
  },
  
  keys: {
    'lesson_location' : 'cmi.core.lesson_location',
    'score': 'cmi.core.score.raw',
    'cpda_course_history': 'cmi.suspend_data',
    'lesson_status': 'cmi.core.lesson_status',
    'student_name': 'cmi.core.student_name',
    'time': 'cmi.core.session_time'
  },

  start: function(){
    this.api=this._get_scorm_api();
    this._lms_init();
    this._get_data();
    this.onReady();
  },

  set: function($super, data){
    if(this.active){
      // set interal store and api
      this.data.update(data);
      for(k in data){
       this.api.LMSSetValue(this.keys[k], data[k].toString()); 
      }
    }
    
    $super();
  },

  get: function(key){
    if(this.active){
      // Use internal memory store vs api
      return this.data.get(key);
    }
  },
  
  send: function($super){
    if(this.active){
      var now = this.course_timer.now_hms;
      this.data.update({time: now});
      this.api.LMSSetValue(this.keys['time'], now);
      this.api.LMSCommit("");
    }
    
    $super();
  },
  
  setComplete: function(){
    this.set({
      lesson_status: 'passed',
      score: 100
    });
  },
  
  end: function(){
    if(this.active){
      this.api.LMSCommit("");
      this.api.LMSFinish("");
      this.active=false;
    }
  },
  
  toString: function(){
    return this.name;
  },

  _get_scorm_api: function(){
    var undef;
    if(this.active){
      var scorm_api = this._find_scorm_api(window);
    
      if ( (scorm_api == undef) && (window.opener != undef) ) {
        scorm_api = this._find_scorm_api(window.opener);
      }
      // Trying the window's opener opener for popout courses
      if ( (scorm_api == undef) && (window.opener.opener != undef) ) {
        scorm_api = this._find_scorm_api(window.opener.opener);
      }
      if (scorm_api == undef) {
        alert("Unable to find an API adapter");
        corp.ui.alert.show(ScormTracker.strings.MissingApiError);
        this.active = false;
      }
      return scorm_api;
    }    
  },
  
  _find_scorm_api: function(win){
    this.l.log("this.find_attempts="+this.find_attempts);
    if(this.active){
      while((win.API == null) && (win.parent != null) && (win.parent != win) ) {
        this.find_attempts++;
        if (this.find_attempts > this.params.find_attempts_before_fail) {
          corp.ui.alert.show(ScormTracker.strings.NestedApiError);
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
    if(isNaN(num))
      return null;
    
    return num;
  },
  
  _getApi: function(key){
    return this.api.LMSGetValue(this.keys[key]);
  },
  
  _get_data: function() {
    var loc = this._parseNumber(this._getApi("lesson_location"));
    if(loc)
      this.data.set("lesson_location", loc);
      
    var score = this._parseNumber(this._getApi("score"));
    if(score)
      this.data.set("score", score);
    
    var cpdaHistory = this._parseNumericList(this._getApi("cpda_course_history"));
    this.data.set("cpda_course_history", cpdaHistory);
    
    this.data.set("lesson_status", this._getApi("lesson_status") || "incomplete");
    this.data.set("student_name", this._getApi("student_name") || "");
  }
  
});


ScormTracker.strings = {
  MissingApiError: "Unable to find SCORM API adapter. Session will not be tracked",
  NestedApiError: "SCORM API too deeply nested: " + this.MissingApiError
};