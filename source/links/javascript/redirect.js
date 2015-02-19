if(typeof(Prototype) === 'undefined'){
	alert('Prototype could not be found.');
	throw('Prototype could not be found.');
}

function hideSplashElements(){
	$('launchMessage').hide();
	$('popupBlocker').hide();
	$('courseLaunchMessage').hide();
	$('closeMessage').hide();
}

redirect = function(target, opennew){

	var popWin = function(url, options) {
		$('splash').show();
		$('popWinLink').onclick = function(){
			popWin(url,options)
		}.bind(redirect);

        options = options || 'width=788,height=477,menubar=0,status=0,scrollbars=0,resizable=1';
 
        var win = window.open(url, null, options);

		if(!win){
			hideSplashElements();
			$('popupBlocker').show();
			return false;
		} else {
			hideSplashElements();
			$('courseLaunchMessage').show();
		}

		if (typeof(win.focus) != 'undefined') {
         	win.focus();
        }

		var onClose = setInterval(function() {
   			if (win.closed) {
     			clearTimeout(onClose);
     			hideSplashElements();
     			$('closeMessage').show();
		    }
	 	}, 200);
  
        return win;
	};

	var getAiccRedirect = function(){
		var qsObj = location.search.toQueryParams(),
		qs = "";

		if(target == "" || typeof(target) == "undefined"){
			alert("target was not defined.")
		} else {
			for(param in qsObj){
					qs += param + "=" + qsObj[param] + "&";
			}

			targetUrl = target.split('?')[0] + "?" + qs + (typeof(target.split('?')[1]) == "undefined" ? "" : target.split('?')[1]);
		
			if(validateQuery(targetUrl)){
				return targetUrl;
			} else {
				alert("Query String is Invalid. Check for dups in the query string.");
			}
		}
		return location.toString();
	}

	var scorm = function(target){
		//search for API and attempt to embed it into the page. 
		var apiSearchContext = {
			0 : window,
			1 : window.opener,
			2 : window.opener.opener
		};

		if(!window.API){
			for(searchNode in apiSearchContext){
				if(apiSearchContext[searchNode] != null){
					for(var i = 0; i < 20; i++){
						if(apiSearchContext[searchNode].API){
							window.API = apiSearchContext[searchNode].API;
						} else if(apiSearchContext[searchNode].parent == apiSearchContext[searchNode] || !apiSearchContext[searchNode].parent){
							break;
						} else {
							apiSearchContext[searchNode] = apiSearchContext[searchNode].parent;
						}
					}
				}
			}
		}

		if($('scormContentFrame')){
			$('scormContentFrame').src = target
		} else {
			var contentFrame = document.createElement("iframe");
				contentFrame.id = "scormContentFrame";
				contentFrame.width = '790px';
				contentFrame.height = '528px';
				contentFrame.frameBorder = 0;
				contentFrame.src = target;
				document.body.appendChild(contentFrame);
		}

		if($('preLaunchContainer')){
			$('preLaunchContainer').hide();
		}

	}

	var validateQuery = function(url){
		var qsObj = url.toQueryParams();

		for(param in qsObj){
			if(typeof(qsObj[param]) != "string"){
				//This does not allow for multiple themes
				//return false;
			}
		}
		return true;
	}

	if(target){
		var target_ = {},
			targetQueryObject = target.replace(/&amp;/g,"&").toQueryParams();

		for(targetToken in targetQueryObject){
			target_[targetToken.toLowerCase()] = targetQueryObject[targetToken];
		}

		if(!opennew){
			if(target_.scorm){
				scorm(target);
			} else {
				window.location = getAiccRedirect();
			}	
		} else {
			popWin(getAiccRedirect(),false);
		}

	}
}