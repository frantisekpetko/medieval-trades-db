import React from 'react';
import ajax from '../utils/ajax';
import HeadHtml from '../HeadHtml';

class Character extends React.Component{

    state = {
        character: []
    };

    componentDidMount(){

        ajax.get("/character")
            .then((response) => {
                const character = response.data;
                console.log("response", response);
                this.setState({character});
                console.log(response.status);

            })
            .catch((error) => {
                console.log(error);
            })
    }

    sendData = () => {

        const data = {
            firstname:  "pílex",
            lastname:  "činorodostx",
            trade: "pokorax"
        };

        ajax.post("/character", data)
            .then((response) => {
                const character = response.data;
                console.log("response", response.data);
                this.setState({character});
                //console.log("Store http status", response);
            })
            .catch((error) => {
                console.log(error);
            })

    };


    render(){
        const {character} = this.state;

        return <div>
            <HeadHtml pageTitle="Character"/>
            <div>
                Character:
                <ul>
                    {character.map( pc => (
                            <React.Fragment key={pc.id}>
                                <li>{pc.firstname}</li>
                                <li>{pc.trade}</li>
                                <hr/>
                            </React.Fragment>
                        )
                    )}
                </ul>
                <button onClick={()=> this.sendData()}>Send data</button>
            </div>
        </div>;
    }


}

export default Character;