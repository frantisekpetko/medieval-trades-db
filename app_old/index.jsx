import React from 'react';
import ReactDOM from 'react-dom';
import Root from './Root';
import { BrowserRouter } from 'react-router-dom';

ReactDOM.render(<BrowserRouter><Root /></BrowserRouter>, document.getElementById('app'));

if (module.hot) {
    module.hot.accept('./index', () => {
        ReactDOM.render(<App />, document.getElementById('app'));
    });
}