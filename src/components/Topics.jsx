import React from 'react';
import Home from "./Character";
import {Link, Route } from 'react-router-dom';
import Topic from './Topic';
import {Helmet} from "react-helmet";
const Topics = ({ match }) => (
    <div>
        <Helmet>
            <meta charSet="utf-8" />
            <title>{props.appName + "- " + match.url}</title>
        </Helmet>
        <h2>Topics</h2>
        <ul>
            <li>
                <Link to={`${match.url}/rendering`}>
                    Rendering with React
                </Link>
            </li>
            <li>
                <Link to={`${match.url}/components`}>
                    Components
                </Link>
            </li>
            <li>
                <Link to={`${match.url}/props-v-state`}>
                    Props v. State
                </Link>
            </li>
        </ul>
        <Route path={`${match.path}/:topicId`} component={Topic}/>
        <Route exact path={match.path} render={() => (
            <h3>Please select a topic.</h3>
        )}/>


    </div>
);

export default Topics;