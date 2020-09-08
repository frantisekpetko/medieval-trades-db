import React from 'react';
import _Content from "./_Content";
import AppContext from 'context/AppContext';

class Content extends React.Component {


    render(){

        return <AppContext.Consumer>
            {(context) => {
                const all = {
                    p: this.props,
                    context: context
                };
                return <_Content {...all}/>
            }}
        </AppContext.Consumer>;
    }
}


export default  Content;