// 'use strict';

const e = React.createElement;

class GrammarArchives extends React.Component {
  state = {
    level: [],
    book: [],
    partOfSpeech: [],
    expression: [],
    usage: [],
    tag: []
  }

  render() {
    return (
      <div className='something-fun'>
        <h1 className='page-title'>Grammar Index</h1>
        <div className='grammar-filter-box'>
          <div className='grammar-filter-button button btn'>Filter</div>
          <p><strong>Level:</strong> <select></select></p>
          <p><strong>Book:</strong> <select></select></p>
          <p><strong>Part of Speech:</strong> <select></select></p>
          <p><strong>Expression:</strong> <select></select></p>
          <p><strong>Usage:</strong> <select></select></p>
          <p><strong>Tag:</strong> <select></select></p>
        </div>
      </div>
    )
  }
}

ReactDOM.render( <GrammarArchives />, document.getElementById( 'grammar_root' ) );