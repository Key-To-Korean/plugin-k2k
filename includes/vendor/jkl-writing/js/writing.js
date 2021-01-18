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