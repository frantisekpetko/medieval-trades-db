import React from 'react';
import HeadHtml from  '../HeadHtml';
import ajax from '../utils/ajax';

class BackendInfo extends React.Component{


    state = {
        infos: []
    };

    componentDidMount(){

        ajax.get("/info")
            .then((response) => {
                const {backend_info} = response.data;
                console.log("response", response.data);
                this.setState({infos: backend_info});

            })
            .catch((error) => {
                console.log(error);
            })
    }


    render(){
        const info = this.state.info;

        return <div>
            <HeadHtml pageTitle="Backend Info"/>
            <div>
                Produkty:
                {infos.map((info) =>
                    <li key={info.id}>{info.name}</li>
                )}
            </div>
        </div>;
    }


}

export default Home;