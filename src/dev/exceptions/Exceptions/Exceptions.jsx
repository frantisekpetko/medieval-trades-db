import React, {PureComponent} from 'react';
import HeadHtml from '../../../HeadHtml';
import Footer from '../../components/Footer';
import Menu from '../../components/Menu';
import BrilliantTable from '../common/BrilliantTable';

import Grid from '@material-ui/core/Grid';
import Typography from '@material-ui/core/Typography';
import AppBar from '@material-ui/core/AppBar';
import Tabs from '@material-ui/core/Tabs';
import Tab from '@material-ui/core/Tab';
import SwipeableViews from 'react-swipeable-views';
import ajax from '../../../utils/ajax';
import "./Exceptions.scss";


function TabContainer({ children, dir }) {
    return (
        <Typography component="div" dir={dir} style={{ padding: 8 * 3 }}>
            {children}
        </Typography>
    );
}

class Exceptions extends PureComponent {

    state = {
        value: 0,
        tab1: "exceptions",
        tab2: "errors",
        errors: []
    };


    componentDidMount() {
        ajax.post("/overview/client/error")
            .then((res) => {
                this.setState({errors: res.data.errors});
                console.log(res.data.errors);
            })
            .catch( (err) => {

            })
    }

    handleChange = (event, value) => {
        this.setState({ value });
    };

    handleChangeIndex = index => {
        this.setState({ value: index });
    };

    render() {
        console.log("exp", this.state.errors);

        return <div>
            <HeadHtml pageTitle="Exceptions"/>
            <Menu/>
            <Grid
                container
                direction="column"
                justify="center"
                alignItems="center">
            <AppBar className="mt-4--5 width-50-percent" position="static" color="default" >
                <Tabs
                    value={this.state.value}
                    onChange={this.handleChange}
                    indicatorColor="primary"
                    textColor="primary"
                    variant="fullWidth"
                >
                    <Tab label={"exceptions"}/>
                    <Tab label={"errors"} />
                </Tabs>
            </AppBar>
            <SwipeableViews
                axis={'x-reverse'}
                index={this.state.value}
                onChangeIndex={this.handleChangeIndex}
            >
                <TabContainer dir={'x-reverse'}>
                    <Grid
                        container
                        direction="column"
                        justify="center"
                        alignItems="center">
                        <BrilliantTable name="Exceptions" cupa="x" log={this.state.errors}/>
                    </Grid>
                </TabContainer>
                <TabContainer dir={'x-reverse'}>
                    <Grid
                        container
                        direction="column"
                        justify="center"
                        alignItems="center">
                        <BrilliantTable name="Errors" cupa="x" log={this.state.errors}/>
                    </Grid>
                </TabContainer>
            </SwipeableViews>
            </Grid>
            <Footer />
        </div>

    }


}


export default Exceptions;