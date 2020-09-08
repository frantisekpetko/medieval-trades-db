import React from 'react';
import ajax from '../utils/ajax';
import HeadHtml from '../HeadHtml';

class CorsInfo extends React.Component{

    state = {
        corsInfo: []
    };

    componentDidMount(){

        ajax.get("/cors")
            .then((response) => {
                const corsInfo = response.data;
                console.log("response", response.data);
                this.setState({corsInfo: corsInfo});

            })
            .catch((error) => {
                console.log(error);
            })
    }


    render(){
        const {corsInfo} = this.state;

        return <div>
            <HeadHtml pageTitle="Cors Info"/>
            <div>
                Cors:
                {corsInfo.map(cors =>
                    <div key={cors.id}>{cors.enable
                        ? <h3>Cors successfuly enabled!</h3>
                        : <h3>No CORS :(</h3>}
                          <div>Access Control Allow Methods:</div>
                    <ul>
                    {cors.request_methods.map( (rm, index) =>
                        <li key={index}>{rm}</li>
                    )}
                    </ul>
                    </div>
                )}
            </div>
        </div>;
    }


}

export default CorsInfo;
