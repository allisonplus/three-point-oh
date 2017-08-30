 /**
  * File mobile-nav-menu.js
  *
  * Based on sliding panel from http://refills.bourbon.io/components/
  */
window.Mobile_Nav_Slide = {};
( function( window, $, app ) {

	// Constructor.
	app.init = function() {
		app.cache();

		if ( app.meetsRequirements() ) {
			app.bindEvents();
		}
	};

	// Cache all the things.
	app.cache = function() {
		app.$c = {
			window: $(window),
			body: $( 'body' ),
			button: $( '.sliding-panel-button' ),
			nav: $( '.menu-primary-menu-container' ),
			panelContent: $( '.sliding-panel-content' ),
		};
	};

	// Combine all events.
	app.bindEvents = function() {
		app.$c.button.on( 'click', app.toggleNav );
	};

	// Do we meet the requirements?
	app.meetsRequirements = function() {
		return app.$c.panelContent.length;
	};

	// Toggle the form open and close.
	app.toggleNav = function(e) {
		app.$c.body.toggleClass( 'sidebar-is-open' );
		app.$c.button.toggleClass( 'open' );
		app.$c.panelContent.toggleClass( 'is-visible' );
		app.$c.nav.toggleClass( 'is-visible' );
	};

	// Engage!
	$( app.init );

})( window, jQuery, window.Mobile_Nav_Slide );
