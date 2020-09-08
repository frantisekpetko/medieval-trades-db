import React, { Component } from 'react';

import HeadHtml from '../../HeadHtml';
import ajax from '../../utils/ajax';

import Typography from '@material-ui/core/Typography';
import Divider from '@material-ui/core/Divider';
import Grid from '@material-ui/core/Grid';
import star from '../../img/starful.png';
import './Welcome.scss';


class Welcome extends Component {
    state = {
        phpVersion: 'Loading ..',
        scaffoldingVersion: 'Loading ..',
        open: false
    };

    componentDidMount() {
        document.body.style.backgroundColor = '#fbf6e8';

        ajax.get('/welcome')
            .then(res => {
                console.log(res.data[0]);
                const data = res.data[0];
                this.setState({
                    phpVersion: data.phpVersion,
                    scaffoldingVersion: data.scaffoldingVersion
                });
            })
            .catch(err => {
                console.log(err);
            });
    }

    componentWillUnmount() {
        document.body.style.backgroundColor = null;
    }

    render() {
        const { phpVersion, scaffoldingVersion } = this.state;

        const content = <div>
                <HeadHtml pageTitle="Welcome!" />
                <div>
                    <Grid container direction="row" justify="flex-end" alignItems="flex-start" />

                    <Grid className="mt-4" container direction="column" justify="center" alignItems="center">
                        <Typography className="bold fw-title" gutterBottom variant="subtitle1" component="h1">
                            Welcome
                        </Typography>

                        <img className="star" src={star} alt="logo" />

                        <Typography component="p" className="mt-2--5">
                            Your scaffolding version: {scaffoldingVersion}
                        </Typography>

                        <Typography component="p">
                            React.js version: {React.version}
                        </Typography>

                        <Typography component="p">
                            php version: {phpVersion}
                        </Typography>
                        <br />
                        <Divider className="divider" />
                        <br />

                        <Typography component="p">
                            <i>Begin your development with generation of source code, enter url: </i><b>/dev</b><i>  or click on button with text "Scaffolding"</i>
                        </Typography>

                    </Grid>
                </div>
            </div>;

        return (
            content
        );
    }
}

export default Welcome;
