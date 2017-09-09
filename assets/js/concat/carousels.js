/**
 * File carousel-testimonials.js
 *
 * Functionality for testimonials: https://flickity.metafizzy.co
 */
var elem = document.querySelector( '.testimonials-shell' );
var flkty = new Flickity( elem, {
	// Options.
	cellAlign: 'left',
	contain: true,
	pageDots: false,
	imagesLoaded: true,
});

// Selector for specific/individual section.
var portfolio = document.querySelector( '.image-gallery' );
var portfolioSingle = new Flickity( portfolio, {
	// Options.
	cellAlign: 'center',
	contain: true,
	pageDots: false,
	imagesLoaded: true,
});
