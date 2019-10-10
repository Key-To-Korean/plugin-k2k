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
  el.setAttribute( 'title', 'Hide English sentence' );
  el.innerHTML = '<i class="fas fa-caret-up"></i>';
}

function contractEl(el) {
  let eng = el.parentElement.lastElementChild;
  
  eng.className = 'en';
  el.setAttribute( 'title', 'Show English sentence' );
  el.innerHTML = '<i class="fas fa-caret-down"></i>';
}

document.querySelector( '.expand-all' ).onclick = function() {
  for( var i = 0; i < sents.length; i++ ) {
    expandEl(sents[i]);
  }
}

document.querySelector( '.contract-all' ).onclick = function() {
  for( var i = 0; i < sents.length; i++ ) {
    contractEl(sents[i]);
  }
}