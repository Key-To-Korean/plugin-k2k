/**
 * Function to lookup a vocab word from Papago.
 *
 * @link Dev Guide: https://developers.naver.com/docs/nmt/reference/
 * @link Sample Code: https://developers.naver.com/docs/nmt/examples/#php
 */
let koreanText = document.getElementsByClassName( 'korean-text' )[0];
const koRegex = /(([\uAC00-\uD7AF]+)\s?)/g; // This regex tests for ONLY Korean characters.
let koreanTextArr = koreanText.innerHTML.split( /(\s+)/ );
console.log(koreanText.children);

let newStuff = '';

for ( let i = 0; i < koreanTextArr.length; i++ ) {
	// Make sure the text is in Korean (not numbers, symbols, emoji, English, etc).
	if ( koreanTextArr[i].match( koRegex ) ) {
		// Some Korean words are getting looped up with their HTML tags. This if/else prevents that.
		let htmlTagIndex = koreanTextArr[i].indexOf( '>' );
		if ( htmlTagIndex !== 0 ) {
			newStuff = newStuff + koreanTextArr[i].substr( 0, htmlTagIndex + 1 ) + '<span class="dict-word">' + koreanTextArr[i].substr( htmlTagIndex + 1 ) + '</span>';
		} else {
			newStuff = newStuff + '<span class="dict-word">' + koreanTextArr[i] + '</span>';
		}
	} else { // In non-Korean words are found, we don't surround them with span tags.
		newStuff = newStuff + koreanTextArr[i];
	}
}
console.log( newStuff );
koreanText.innerHTML = newStuff;

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

function removeHighlight() {
	// Remove any possible highlights.
	for ( let i = 0; i < words.length; i++ ) {
		words[i].style.background = 'transparent';
	}
}

// var client_id = 'GWOb896dIGIFUwHFiimd';
// var client_secret = 'tLZGH0tcVV';
// var query = "번역할 문장을 입력하세요.";
// app.get('/translate', function (req, res) {
//    var api_url = 'https://openapi.naver.com/v1/papago/n2mt';
//    var request = require('request');
//    var options = {
//        url: api_url,
//        form: {'source':'ko', 'target':'en', 'text':query},
//        headers: {'X-Naver-Client-Id':client_id, 'X-Naver-Client-Secret': client_secret}
//     };
//    request.post(options, function (error, response, body) {
//      if (!error && response.statusCode == 200) {
//        res.writeHead(200, {'Content-Type': 'text/json;charset=utf-8'});
//        res.end(body);
//      } else {
//        res.status(response.statusCode).end();
//        console.log('error = ' + response.statusCode);
//      }
//    });
//  });

( function($) {
	$( '.dict-clear-all' ).on( 'click', function() {
		$( '#dict-translation' ).html( '' );
		removeHighlight();
	});

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
