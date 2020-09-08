import React from 'react';
import HeadHtml from  '../HeadHtml';
import ajax from '../utils/ajax';



class ProductDebug extends React.Component{


    state = {
        debugsql: []
    };

    componentDidMount(){

        ajax.get("/productdebug")
            .then((response) => {
                //const {debugsql} = response.data;
                const debugsql = response;
                console.log("response", debugsql.data);
                this.setState({debugsql: debugsql});

            })
            .catch((error) => {
                console.log(error);
            })
    }


    render(){
        const debug = this.state.debugsql;

        return <div>
            <HeadHtml pageTitle="Product Insert SQL Debug"/>
            <div>
                xx
            </div>
        </div>;
    }


}

export default ProductDebug;