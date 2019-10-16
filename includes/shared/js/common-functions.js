const sentsLI = document.querySelectorAll( '.sentences li' );

for( var i = 0; i < sentsLI.length; i++ ) {
  sentsLI[i].onclick = function(e) {
    showEnglish(this.lastElementChild);
  }
}

function showEnglish(el) {
  if ( el.className === 'en active' ) {
    contractEl(el);
  } else {
    expandEl(el);
  }
}

function expandEl(el) {
  let button = el.parentElement.firstElementChild;

  el.className += ' active';
  button.setAttribute( 'title', 'Hide English sentence' ); // @TODO: Make translatable.
  button.innerHTML = '<i class="fas fa-caret-up"></i>';
}

function contractEl(el) {
  let button = el.parentElement.firstElementChild;
  
  el.className = 'en';
  button.setAttribute( 'title', 'Show English sentence' ); // @TODO: Make translatable.
  button.innerHTML = '<i class="fas fa-caret-down"></i>';
}

document.querySelector( '.expand-all' ).onclick = function() {

  if ( this.className === 'expand-all expanded' ) {

    this.className = 'expand-all';
    this.innerHTML = '<i class="fas fa-caret-down"></i>';
    this.setAttribute( 'title', 'Show all English sentences.' ); // @TODO: Make translatable.

    for( var i = 0; i < sentsLI.length; i++ ) {
      contractEl(sentsLI[i].lastElementChild);
    }

  } else {

    this.className = 'expand-all expanded';
    this.innerHTML = '<i class="fas fa-caret-up"></i>';
    this.setAttribute( 'title', 'Hide all English sentences.' ); // @TODO: Make translatable.

    for( var i = 0; i < sentsLI.length; i++ ) {
      expandEl(sentsLI[i].lastElementChild);
    }
  }
}
