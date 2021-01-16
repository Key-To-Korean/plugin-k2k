let words = document.getElementsByClassName( 'dict-word' );
let overlay = document.getElementsByClassName( 'site-modal' )[0];
let drawer = document.getElementsByClassName( 'drawer' )[0];
let drawerBox = document.getElementsByClassName( 'drawer-box' )[0];

// Let EVERY word open the dictionary and be checked.
for ( let i = 0; i < words.length; i++ ) {
	words[i].addEventListener( 'click', openDict );
}

function openDict() {
	// Highlight our word
	this.style.background = 'rgba(207, 128, 49, 0.5)';
	// Set site-overlay active
	overlay.className = 'site-modal site-overlay active';
	overlay.style.zIndex = '9999999';
	overlay.style.opacity = '0.2';
	// Prevent drawer from opening
	drawerBox.className = 'drawer-box';
	drawer.className = 'drawer';
	// Open dictionary from the bottom
	document.getElementById('dict-lookup').style.bottom = '0';
	// Make sure that EVERY time we open it, we make the overlay listen for a click.
	overlay.addEventListener( 'click', closeDict );
}

document.getElementById( 'dict-close' ).addEventListener( 'click', closeDict );

function closeDict() {
	// Close dictionary
	document.getElementById('dict-lookup').style.bottom  = '-40rem';
	removeHighlight();
	// Prevent drawer from opening
	drawerBox.className = 'drawer-box';
	drawer.className = 'drawer';
	// Turn off site-overlay
	overlay.className = 'site-modal site-overlay';
	overlay.style.zIndex = '99999';

	// To prevent the overlay going darker, then lighter, set a short delay to reset its opacity value.
	setTimeout( function() {
		overlay.style.opacity = '1';
	}, 300 );
	
}

function removeHighlight() {
	// Remove any possible highlights.
	for ( let i = 0; i < words.length; i++ ) {
		words[i].style.background = 'transparent';
	}
}

// Reveal English Reading
let englishReading = document.getElementsByClassName('english-text-container')[0];
let passages = document.getElementsByClassName('reading-passages')[0];
let englishReadingButton = document.getElementById( 'show-english-reading' );

// Make sure there IS a button here.
if ( englishReadingButton ) {
	document.getElementById( 'show-english-reading' ).addEventListener( 'click', function() {
		if ( 'reading-passages active' === passages.className ) {
			passages.className = 'reading-passages';
			englishReading.style.display = 'none';
		} else {
			passages.className = 'reading-passages active';
			setTimeout( function() {
				englishReading.style.display = 'block';
			}, 100 );
		}
	});
}

/*
 * Highlight correct and incorrect answers.
 */
let questions = document.getElementsByClassName( 'reading-questions' );
let questionItem = document.getElementsByClassName( 'reading-question-item' );
let answers = document.getElementsByClassName( 'reading-question-answer-item ' );

// Let EVERY answer be checked.
for ( let i = 0; i < answers.length; i++ ) {
	answers[i].addEventListener( 'click', checkCorrect );
}

function checkCorrect() {

	// Check if it's correct, then highlight correct and incorrect answers.
	if ( this.classList.contains( 'correct' ) ) {
		this.style.background = 'rgba(0, 137, 123, 0.3)';
	} else {
		this.style.background = 'rgba(233, 30, 99, 0.3)';
	}

	// Decide if we've already checked this answer or not.
	// If not, set the className to 'checked'.
	// If so, remove the 'checked' className and reset the color.
	if ( this.classList.contains( 'checked' ) ) {
		this.className = this.className.replace( /\bchecked\b/, '' );
		this.style.background = '#efefef'; // reset the color.
	} else {
		this.className = this.className + 'checked';
	}
}