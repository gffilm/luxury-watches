/*
* The global app object
*/
var app = {};

/*
 * Logging functionality 
 * @param {string} name
 * @param {*} value
 * @param {boolean} filter
 */
app.log = function(name, value, filter) {
	if (window.console && filter) {
		if (value) {
			console.log(name, value);
		} else {
			console.log(name);
		}
	}
};

/*
 * Initiialize the dom listeners
 */
app.initializeDomListeners = function() {
	activateSearchBox();
};

/*
 * Listen for the ready event
 */
$(document).ready(function() {
	app.initializeDomListeners();
});


/*
 * Gets an element by ID or class
 * @param {string} el the element identifier.
 */
app.getEl = function(el) {
	return document.getElementById(el) || document.getElementsByClassName(el)[0];
};

/*
 * Listener
 * @param {Element} el the element.
 * @param {string} eventType the event type
 * @param {Function} callback the callback event
 * @param {boolean=} opt_once should it only listen once?
 */
app.listen = function(el, eventType, callback, opt_once) {
	var evt = {};

	evt.name = eventType;
	evt.source = this;
	evt.target = el;
	$(el)[eventType](function(event) {
		callback(evt);
		if (opt_once) {
			$(this).off(event);
		}
	});
};


/*
 * The search box activator
*/
activateSearchBox = function() {
	var searchbox = app.getEl('searchbox');
	if (searchbox) {
		searchbox.value = 'Search for a watch';
		searchbox.style.color = '#7e7e7e';
		app.listen(searchbox, 'click', handleSearchClick, true);
	}
};


/*
 * The handler for when the search button is clicked
 * @param {Event} evt the event fired
*/
handleSearchClick = function(evt) {
	var el = evt.target;
	el.value = '';
	el.style.color = '#fff';
};
