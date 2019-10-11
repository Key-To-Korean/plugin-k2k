const sents = document.querySelectorAll( '.sentences .expand' );

for( var i = 0; i < sents.length; i++ ) {
  sents[i].onclick = function(e) {
    showEnglish(this);
  }
}

function showEnglish(el) {
  let eng = el.parentElement.lastElementChild;
  
  if ( eng.className === 'en' ) {
    expandEl(el);
  } else {
    contractEl(el);
  }
}

function expandEl(el) {
  let eng = el.parentElement.lastElementChild;
  
  eng.className += ' active';
  el.setAttribute( 'title', 'Hide English sentence' ); // @TODO: Make translatable.
  el.innerHTML = '<i class="fas fa-caret-up"></i>';
}

function contractEl(el) {
  let eng = el.parentElement.lastElementChild;
  
  eng.className = 'en';
  el.setAttribute( 'title', 'Show English sentence' ); // @TODO: Make translatable.
  el.innerHTML = '<i class="fas fa-caret-down"></i>';
}

document.querySelector( '.expand-all' ).onclick = function() {

  if ( this.className === 'expand-all expanded' ) {

    this.className = 'expand-all';
    this.innerHTML = '<i class="fas fa-caret-down"></i>';
    this.setAttribute( 'title', 'Show all English sentences.' ); // @TODO: Make translatable.

    for( var i = 0; i < sents.length; i++ ) {
      contractEl(sents[i]);
    }
  } else {

    this.className = 'expand-all expanded';
    this.innerHTML = '<i class="fas fa-caret-up"></i>';
    this.setAttribute( 'title', 'Hide all English sentences.' ); // @TODO: Make translatable.

    for( var i = 0; i < sents.length; i++ ) {
      expandEl(sents[i]);
    }
  }
}
