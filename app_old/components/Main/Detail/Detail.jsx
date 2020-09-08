import React from 'react';
import _Detail from './_Detail';
import AppContext from "../../../context/AppContext";

class Detail extends React.Component {


    render(){

        return <AppContext.Consumer>
            {(context) => {
                const all = {
                    p: this.props,
                    context: context
                };
                return <_Detail {...all}/>
            }}
        </AppContext.Consumer>;
    }
}

export default Detail;

/*
export default compose(
    withAppContext
)(withRouter(Detail));
*/

