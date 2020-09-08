//require('babel-core/register');
//import './utils/errorReporting';
// import * as serviceWorker from './serviceWorker'
import ajax from './utils/ajax';

require('babel-polyfill');
import './utils/phpPrettier';

import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter, Link } from 'react-router-dom';
import Grid from '@material-ui/core/Grid';
import Badge from '@material-ui/core/Badge';
import Button from '@material-ui/core/Button';
import AnimationContext from './context/AnimationContext';

import './utils/helpers.js';
import './index.scss';

import Routes from './Routes';

class App extends React.Component {

    state = {
        visible: false,
        level: 'success',
        message: 'Success',
        givePropToHighestComponent: (prop) => {
            console.log("Prop =>", prop);
            return this.changeState(prop)
        },
        showToaster: () => {this.setState({visible: true})}
    };


    componentDidMount() {
        //this.getRestfulException();
    }

    getRestfulException = () => {
        ajax.get("debug/client/error")
            .then(() => {
                //const data = res.data;
                console.log(res);
                //this.setState({resource: data});
            })
            .catch((err)=> {
                console.log(err);
            })
    };

    changeState = (prop) => {
        this.setState(prop);
    };

    render() {
        console.log("***************************************************");
        console.log("App Toast: ", this.toast);


        console.log("visible: ", this.state.visible);
        const isDev = process.env.NODE_ENV === 'development';

        let devGenerator = <Grid

            container
            justify="flex-start"
            alignItems="flex-start"
            spacing={0}
            direction="column"
            style={{position: "fixed", top: "53.75%",left: 0, width: "20%"}}
        >
            <Badge badgeContent={"Main page"} color={"secondary"}>
                <Button variant={"outlined"}
                        color={"secondary"}
                        to='/dev'
                        component={Link}
                        className="suitable-clickability"
                >
                    Scaffolding
                </Button>
            </Badge>
        </Grid>;

        const fixtures = <div>
                <div>
                    {devGenerator}
                </div>
        </div>;

        return (
            <BrowserRouter>
                <div>
                    <AnimationContext.Provider value={{context: this.state}}>
                        <Routes/>
                        {isDev ? fixtures : null}
                    </AnimationContext.Provider>
                </div>
            </BrowserRouter>
        );
    }
}

ReactDOM.render(<App />, document.getElementById('app'));

if (module.hot) {
    module.hot.accept('./index', () => {
        ReactDOM.render(<App />, document.getElementById('app'));
    });
}