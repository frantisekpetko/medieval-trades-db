import React from 'react';
import {Helmet} from "react-helmet";

const Topic = ({ match }) => (
    <div>
        <Helmet>
            <meta charSet="utf-8" />
            <title>{props.appName} - Topic</title>
        </Helmet>
        <h3>{match.params.topicId}</h3>
    </div>
);

export default Topic;