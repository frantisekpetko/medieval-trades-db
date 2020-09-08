import React from 'react';
import AppContext from './AppContext';


const withAppContext = (Component) => (

        <AppContext.Consumer>
            {(context) => (
                <Component {...context}/>
            )}
        </AppContext.Consumer>
);

/*
class withAppContext extends React.Component {
    render(){
        return <AppContext.Consumer>
        {(context) => (
            <Component {...context}/>
        )}
        </AppContext.Consumer>;
    }
}
*/
export default withAppContext;

