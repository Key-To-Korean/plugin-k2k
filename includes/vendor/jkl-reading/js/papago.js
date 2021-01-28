/**
 * Functions to lookup a vocab word from Papago.
 *
 * @link Dev Guide: https://developers.naver.com/docs/nmt/reference/
 * @link Sample Code: https://developers.naver.com/docs/nmt/examples/#php
 */

/**
 * Function to split the Korean reading text into an array of Korean words
 * surrounded by clickable <span> tags.
 */
let koreanText = document.getElementsByClassName( 'korean-text' )[0];
const koRegex = /(([\uAC00-\uD7AF]+)\s?)/g; // This regex tests for ONLY Korean characters.

// Split the whole text by spaces and HTML tags.
let allTextArr = koreanText.innerHTML.split( /\s+|(<[^>]*>)/g );
// Remove undefined array items.
let koreanTextArr = allTextArr.filter(function(x) {
	return x !== undefined;
})

// Create a new String to hold our output.
let newStuff = '';

// Go through every item in the array and surround ONLY the Korean words with <span> tags.
for ( let i = 0; i < koreanTextArr.length; i++ ) {
	// Make sure the text is in Korean (not numbers, symbols, emoji, English, etc).
	if ( koreanTextArr[i].match( koRegex ) ) {
		newStuff = newStuff + '<span class="dict-word">' + koreanTextArr[i] + '</span>';
	} else { // In non-Korean words are found, we don't surround them with span tags.
		newStuff = newStuff + koreanTextArr[i];
	}
	newStuff += ' ';
}

// Reset the reading text with our new version
// where every Korean word has a <span> tag that can be clicked.
koreanText.innerHTML = newStuff;

/**
 * Get ready to open the dictionary lookup window on word click.
 */
let words = document.getElementsByClassName( 'dict-word' );
let overlay = document.getElementsByClassName( 'site-modal' )[0];
let drawer = document.getElementsByClassName( 'drawer' )[0];
let drawerBox = document.getElementsByClassName( 'drawer-box' )[0];

// Let EVERY word open the dictionary and be checked.
for ( let i = 0; i < words.length; i++ ) {
	words[i].addEventListener( 'click', openDict );
}

function openDict(e) {
	// Highlight our word
	this.style.background = 'rgba(207, 128, 49, 0.5)';
	// Set site-overlay active
	// overlay.className = 'site-modal site-overlay active';
	// overlay.style.zIndex = '9999999';
	// overlay.style.opacity = '0.2';
	// Prevent drawer from opening
	// drawerBox.className = 'drawer-box';
	// drawer.className = 'drawer';
	// Open dictionary from the bottom
	document.getElementById('dict-lookup').style.bottom = '0';
	// Make sure that EVERY time we open it, we make the overlay listen for a click.
	// overlay.addEventListener( 'click', closeDict );
}

/**
 * Get ready to close the dictionary lookup window on 'x' click.
 */
document.getElementById( 'dict-close' ).addEventListener( 'click', closeDict );

function closeDict() {
	// Close dictionary
	document.getElementById('dict-lookup').style.bottom  = '-40rem';
	removeHighlight();
	// Prevent drawer from opening
	// drawerBox.className = 'drawer-box';
	// drawer.className = 'drawer';
	// Turn off site-overlay
	// overlay.className = 'site-modal site-overlay';
	// overlay.style.zIndex = '99999';

	// To prevent the overlay going darker, then lighter, set a short delay to reset its opacity value.
	setTimeout( function() {
		overlay.style.opacity = '1';
	}, 300 );
	
}

/**
 * Remove all highlights from any highlighted words.
 */
function removeHighlight() {
	// Remove any possible highlights.
	for ( let i = 0; i < words.length; i++ ) {
		words[i].style.background = 'transparent';
	}
}

/**
 * JQuery AJAX function to actually perform the Papago lookup.
 */
( function($) {
	$( '.dict-clear-all' ).on( 'click', function() {
		$( '#dict-translation' ).html( '' );
		removeHighlight();
	});

	/**
	 * The function that listens for an Event click on each Korean word.
	 * It handles the AJAX call to Papago and PHP to display the translation,
	 * and also handles the dynamic links to the various dictionary sites.
	 */
	$( '.dict-word' ).on( 'click', function() {

		// Turn ON the "loading" spinner.
		$( '.dict-spinner' ).css({ 'display': 'block' });

		let allKorean = '';
		let lookup = this.innerText;
		allKorean += lookup;

		$.ajax({
			type: "POST", //전송방식
			url: translate.ajaxurl, //호출 URL
			data: {
				action: 'jkl_papago_dictionary_lookup', // PHP function to run.
				nonce: translate.nonce,
				word: lookup,
			},
			success: function(e){
				console.info( "Success!" );
				// console.info(e); //통신에 성공했을시 실행되는 함수  
			},
			error: function(e){
				console.error( "Error!" );
				// console.error(e); //통신에 실패했을시 실행되는 함수
			}
		})
		.done( function(res) {
			console.log(res);
			let translated = res.endsWith( '0' ) ? res.substr( 0, res.length - 1 ) : res;
			$( '#dict-translation' ).html( $( '#dict-translation' ).html() + lookup + ' = ' + translated + '<br>'  );
		
			// Set the new word to the lookup string for each dictionary link.
			$( '#open-papago' ).attr( 'href', 'https://papago.naver.com/?sk=ko&tk=en&st=' + allKorean );
			$( '#open-google' ).attr( 'href', 'https://translate.google.com/?sl=ko&tl=en&text=' + allKorean );
			$( '#open-naver' ).attr( 'href', 'https://dict.naver.com/search.nhn?dicQuery=' + allKorean );

			// Turn OFF the "loading" spinner.
			$( '.dict-spinner' ).css({ 'display': 'none' });
		});
	});
}) (jQuery);
