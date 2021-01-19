/**
 * Deal with active writing tabs.
 */
let writingTabs = document.getElementsByClassName( 'writing-tab' );
let writingTabsBtns = document.getElementsByClassName( 'writing-tab-tag' );

for ( let i = 0; i < writingTabsBtns.length; i++ ) {
	writingTabsBtns[i].addEventListener( 'click', switchActiveTab );
}

function switchActiveTab() {
	console.log(this.className);
	console.log(this);
	// Remove 'active' class from EVERYTHING.
	for ( let i = 0; i < writingTabsBtns.length; i++ ) {
		writingTabsBtns[i].className = writingTabsBtns[i].className.replace( /\bactive\b/, '' );
	}
	for ( let i = 0; i < writingTabs.length; i++ ) {
		writingTabs[i].className = writingTabs[i].className.replace( /\bactive\b/, '' );
	}

	// Find out which tab we clicked on.
	if ( this.classList.contains( 'short-tab-tag' ) ) {
		document.getElementsByClassName( 'short-tab' )[0].className = document.getElementsByClassName( 'short-tab' )[0].className + ' active';
		this.className = this.className + ' active';
	}
	if ( this.classList.contains( 'medium-tab-tag' ) ) {
		document.getElementsByClassName( 'medium-tab' )[0].className = document.getElementsByClassName( 'medium-tab' )[0].className + ' active';
		this.className = this.className + ' active';
	}
	if ( this.classList.contains( 'long-tab-tag' ) ) {
		document.getElementsByClassName( 'long-tab' )[0].className = document.getElementsByClassName( 'long-tab' )[0].className + ' active';
		this.className = this.className + ' active';
	}
}

/**
 * Deal with sample writing and writing hints.
 */
let sampleWritingBtns = document.getElementsByClassName( 'show-sample-writing' );
let sampleWriting = document.getElementsByClassName( 'sample-writing' );
let solveWritingBtns = document.getElementsByClassName( 'show-writing-hints' );
let solveWriting = document.getElementsByClassName( 'writing-hints' );

for ( let i = 0; i < sampleWritingBtns.length; i++ ) {
	sampleWritingBtns[i].addEventListener( 'click', showWriting );
}
for ( let i = 0; i < solveWritingBtns.length; i++ ) {
	solveWritingBtns[i].addEventListener( 'click', showWriting );
}

function showWriting() {
	if ( this.nextSibling.nextSibling.classList.contains( 'hide-writing' ) ) {
		this.nextSibling.nextSibling.className = this.nextSibling.nextSibling.className.replace( 'hide', 'show' );
		this.innerHTML = this.innerHTML.replace( 'Show', 'Hide' );
	} else {
		this.nextSibling.nextSibling.className = this.nextSibling.nextSibling.className.replace( 'show', 'hide' );
		this.innerHTML = this.innerHTML.replace( 'Hide', 'Show' );
	}
}
