// /**
//  * File super-heroine.js
//  *
//  */

// Get values from ACF fields via wp_localize_script in /inc/acf.php
const desc = acf_vars.list_parent.descriptor_list;
const subj = acf_vars.list_parent.subject_list;

// Reformat data from ACF fields.
const listOne = desc.map( descriptors => descriptors.descriptors );
const listTwo = subj.map( subjects => subjects.subjects );

const listParent = document.querySelector( '.list-parent' );

function makeList( wordList ) {
	const shuffledList = shuffleThings( wordList );

	const listTemplate = `
		<ul class="word-list">
		${shuffledList.map(descriptor => `<li>${descriptor}</li>`).join('')}
		</ul>
	`;

	listParent.insertAdjacentHTML( 'beforeEnd', listTemplate );
}


function shuffleThings( array ) {
	var currentIndex = array.length, temporaryValue, randomIndex;

		// While there remain elements to shuffle.
		while (0 !== currentIndex) {

		// Pick a remaining element.
		randomIndex = Math.floor(Math.random() * currentIndex);
		currentIndex -= 1;

		// And swap it with the current element.
		temporaryValue = array[currentIndex];
		array[currentIndex] = array[randomIndex];
		array[randomIndex] = temporaryValue;
	}

	return array;
}

makeList(listOne);
makeList(listTwo);
