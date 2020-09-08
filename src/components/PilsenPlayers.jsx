import React from 'react';
import HeadHtml from  '../HeadHtml';
import ajax from '../utils/ajax';

class PilsenPlayers extends React.Component {

    static defaultProps = {
        //fb: null
    };

    constructor(props){
        super(props);
    }

    state = {
        name: null,
        status: null,
        html: null
    };

   testAPI = async () => {
        console.log('Welcome!  Fetching your information.... ');

        try {
            const html = await ajax.get("https://www.facebook.com/groups/1554967328065893/members");
            //const html = await ajax.get("https://www.facebook.com/groups/1554967328065893/members/");
            console.log(html);
            this.setState({html: html});

        }
        catch (error) {
            console.log(error);
        }
    };

    handleClick(){
        this.testAPI();
    }

    render() {
        const status = this.state.status;
        const name =this.state.name;
        return <div>
            <HeadHtml pageTitle="Facebook login"/>
            <div>
                <div>Status: {status !== null ?  status : " ___"}</div>

                <div>Name: {name !== null ?  status : " ___"}</div>
                <hr/>
                <button onClick={() => this.handleClick()}>Login</button>
            </div>
        </div>
    }

}
export default PilsenPlayers;