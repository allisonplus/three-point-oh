/**
 * File carousel-testimonials.js
 *
 * Functionality for testimonials: https://flickity.metafizzy.co
 */
var elem = document.querySelector( '.testimonials-shell' );

// Conditional if element exists.
if (elem != null) {
	var flkty = new Flickity( elem, {
		// Options.
		cellAlign: 'left',
		contain: true,
		pageDots: false,
		imagesLoaded: true,
	});
}

// Selector for specific/individual section.
var portfolio = document.querySelector( '.image-gallery' );

// Conditional if element exists.
	if (portfolio != null) {
	var portfolioSingle = new Flickity( portfolio, {
		// Options.
		cellAlign: 'center',
		imagesLoaded: true,
	});
}
