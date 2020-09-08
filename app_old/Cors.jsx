import React from 'react';
import API from './utils/API';
import withErrorBoundary from './ErrorBoundary/withErrorBoundary';

class Cors extends React.Component {

    state = {
        cors: []
    };

    async componentDidMount() {
        try {
            const response = await API.get("/cors");
            const cors = response.data[0];
            console.log("response", response.data[0]);
            this.setState({cors: cors});
        }
        catch (e) {
            console.error(`Fetch error occurred: ${e}`)
        }
    }

    render() {
        console.log(this.state.cors);
        const {cors} = this.state;
        const Cors = <div>
            Cors:
            <div>{cors.enable
                ? <h3>Cors successfuly enabled!</h3>
                : <h3>No CORS :(</h3>}
                <div>Access Control Allow Methods:</div>
                {cors.id}
                <ul>
                    {cors.requestMethods === undefined ?  null :  cors.requestMethods.map
                       ( (rm, index) =>
                        <li key={index}>{rm}</li>
                    )}
                </ul>
            </div>
        </div>;

        const Loading = <React.Fragment><h3>Loading ...</h3></React.Fragment>;
        return cors.hasOwnProperty("id") > 0 ? Cors : Loading;
    }
}

export default withErrorBoundary(Cors);

