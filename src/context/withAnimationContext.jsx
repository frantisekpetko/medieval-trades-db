import React from 'react';
import AnimationContext from './AnimationContext';


const withAnimationContext = (Component) => {

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

export default withAnimationContext;

