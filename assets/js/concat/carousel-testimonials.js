/**
 * File carousel-testimonials.js
 *
 * Functionality for testimonials: https://flickity.metafizzy.co
 */
var elem = document.querySelector('.testimonials');
var flkty = new Flickity( elem, {
	// Options.
	cellAlign: 'center',
	contain: true,
	pageDots: false,
	imagesLoaded: true,
});

// Selector for specific/individual section.
// var flkty = new Flickity( '.testimonials', {
// 	// Options.
// });
