/**
 * File super-heroine.js
 *
 */
const listOne = [ 'INFJ', 'Internet', 'Introverted', 'WordPress', 'Creative', 'Coding', 'Inclusive'];
const listTwo = [ 'Poet', 'Writer', 'Curator', 'Detective', 'Technologist', 'Feminist', 'Artist', 'Daydreamer'];

const interval = 3000;
let wordHistory = '';

// **Grab elements.
const containerNumber = document.getElementsByClassName( 'text-shifting' );

identityCycle( containerNumber[0], listOne );

// Stagger switching timing.
setTimeout( function() {
	identityCycle( containerNumber[1], listTwo );

}, interval/2 );

// **Start it off.
function identityCycle( container, whichList ) {

	setInterval( function() {
		replaceContent( container, whichList );
	}, interval );
};

// **Choose random word from chosen array.
function getRandomWords( listChoice ) {
	const word = listChoice[Math.floor( Math.random()*listChoice.length )];
	return word;
}

// **Markup Replacement.
function replaceContent( container, whichList ) {

	const identity = getRandomWords( whichList );
	const noRepeat = compareWords(identity);

	// **Replace.
	if( noRepeat ) {
		container.textContent = identity;
	} else {
		replaceContent( container );
	}

	wordHistory = identity;
}

function compareWords( currentWord ) {
	if( currentWord === wordHistory ) {
		return false;
	} else {
		return true;
	}
}
