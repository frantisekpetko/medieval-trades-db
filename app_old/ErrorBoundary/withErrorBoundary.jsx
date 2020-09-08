import React from 'react';
import DebugBoundary from './DebugBoundary';
import ErrorBoundary from './ErrorBoundary';

const isDev = process.env.NODE_ENV === 'development';

const withErrorBoundary = (Component) => {

    return (props) => (
        isDev
            ? <DebugBoundary><Component {...props}/></DebugBoundary>
            : <ErrorBoundary><Component {...props}/></ErrorBoundary>
    )};

export default withErrorBoundary;