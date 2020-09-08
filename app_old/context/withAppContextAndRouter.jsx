import React from 'react';
import AnimationContext from './AppContext';
import { withRouter } from 'react-router-dom';

const withAppContext = (Component) => {

    return (props) => (
        <AnimationContext.Consumer>
            {(context) => {
                console.log("context", context);
                return context === null || context === undefined
                    ? <Component  {...props} />
                    : <Component {...context} />
            }}
        </AnimationContext.Consumer>
    )};

export default withRouter(withAppContext);

