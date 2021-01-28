document.getElementById( 'switch-sentence-language' ).addEventListener( 'click', function() {
	let en = document.getElementsByClassName( 'en' );
	let ko = document.getElementsByClassName( 'ko' );

	for ( let i = 0; i < en.length; i++ ) {
		let temp = en[i].innerHTML;
		en[i].innerHTML = ko[i].innerHTML;
		ko[i].innerHTML = temp;
	}

	if ( this.className === 'korean' ) {
		this.innerText = 'Change to: KO';
		this.className = 'english';
	} else {
		this.innerText = 'Change to: EN';
		this.className = 'korean';
	}
});