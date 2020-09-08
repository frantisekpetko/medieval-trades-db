import React, {Component} from 'react';
import SweetAlert from 'sweetalert2-react';
import './sweetalert2.scss';

import withRouter from 'react-router-dom/withRouter';
import TextField from '@material-ui/core/TextField';
import Grid from '@material-ui/core/Grid';
import Typography from '@material-ui/core/Typography';
import { MuiThemeProvider, createMuiTheme } from '@material-ui/core/styles';

import Footer from '../components/Footer';
import Button from '@material-ui/core/Button';
import indigo from '@material-ui/core/colors/indigo';
import FormControlLabel from '@material-ui/core/FormControlLabel';
import Checkbox from '@material-ui/core/Checkbox';
import { fade } from '@material-ui/core/styles/colorManipulator';

import Modal from '../components/Modal';
import ajax from '../../utils/ajax';
import HeadHtml from "../../HeadHtml";
import Menu from '../components/Menu';
import Spinner from '../components/Spinner';
//import AnimationContext from '../../context/AnimationContext';

const theme = createMuiTheme({
    palette: {
        accent: { color: fade(indigo[500], 0.9) }
    },
    typography: {
        useNextVariants: true,
    },
});

class RouteGen extends Component {

    state = {
        name: '',
        open: false,
        routeMappingTxt: '',
        controllerTxt: '',
        checkedGetCollection: true,
        checkedGetResource: true,
        checkedPostResource: true,
        checkedPatchResource: true,
        checkedDeleteResource: true,
        controllerCreation: true,
        modelAssociation: true,
        modelName: '',
        show: false,
    };

    formatRouteNameToModelType = (name) => {
        const ucFirst = (string) =>
        {
            return string.charAt(0).toUpperCase() + string.slice(1);
        };

        const lastPart = name.split("/").pop();

        return ucFirst(lastPart)
    };


    handleSendData = () => {

        if(this.state.name !== ""){
            const data = {
                path: this.state.name,
                actionIndex: this.state.checkedGetCollection,
                actionSingle: this.state.checkedGetResource,
                actionStore: this.state.checkedPostResource,
                actionUpdate: this.state.checkedPatchResource,
                actionErase: this.state.checkedDeleteResource,
                controllerCreation: this.state.controllerCreation,
                modelAssociation: this.state.modelAssociation,
                modelName: this.formatRouteNameToModelType(this.state.name),
            };

            ajax.post('/route', data)
                .then((res) => {
                    console.log(res.data.controllerPreview);
                    this.setState({routeMappingTxt: res.data.preview, controllerTxt: res.data.controllerPreview });

                })
                .catch((err) => {
                    console.log(err)
                });

            this.handleClickOpen();
        }
        else {
            this.setState({show: true});
        }



    };

    handleClickOpen = () => {
        this.setState({
            open: true,
        });
    };

    handleChange = name => {
        return event => {

            let value = event.target.value;
            let final = value.replace(/[0-9`~!@#$%^&*()_|+\-=?;:'",.<>{}\[\]\\]/gi, '');
            final = final.toLowerCase();

            const formattedModelName = this.formatRouteNameToModelType(final);

            this.setState({
                [name]: final,
                modelName: formattedModelName
            });
        };
    };

    changeHandler = (name) =>  {

        this.setState({
            [name]: !this.state[name]
        });
    };

    handleClose = () => {
        this.setState({ open: false });
    };

    render(){

        return (

            <MuiThemeProvider theme={theme}>
                <SweetAlert
                    show={this.state.show}
                    title="Empty user input"
                    text="Please type suitable input."
                    onConfirm={() => this.setState({ show: false })}
                />
                <div>
                    <HeadHtml pageTitle={"Route Generator"}/>
                    <div>

                        <Menu />
                        <Grid
                            className="mt-7"
                            container
                            direction="column"
                            justify="center"
                            alignItems="center"
                        >
                            <Typography className="bold" gutterBottom variant="headline" component="h1">
                                Route Generator
                            </Typography>
                            <Typography component="p">
                                <b className="text-align-for-model">Example of text.</b><br/>
                                <i>
                                    This generator helps you to quickly generate a
                                    new route collection corresponding with your CRUD and API.
                                </i>

                            </Typography>

                            <br />
                                <Typography component="p">
                                    <b >"This options as checkboxes can be useful for select which rest methods you want at specific route your given path"</b><br/>
                                </Typography>

                            <TextField
                                id="filled-name"
                                label="Route basic path"
                                value={this.state.name}
                                onChange={this.handleChange('name')}
                                margin="normal"
                                variant="filled"
                            />


                            <Button
                                variant="contained"
                                size="small"
                                color="default"
                                onClick={this.handleSendData}>
                                Preview
                            </Button>

                            {!this.state.open || this.state.routeMappingTxt.length > 0
                            ? <Modal component="route"
                                       title="Subrouter"
                                       subjectName={this.state.name}
                                       open={this.state.open}
                                       close={this.handleClose}
                                       firstData={this.state.routeMappingTxt}
                                       secondData={this.state.controllerTxt}
                                       oneBtn={true}
                                />
                                : <Spinner/>
                            }
                        </Grid>

                        <Footer/>
                    </div>
                </div>

            </MuiThemeProvider>
        );
    }

}



export default withRouter(RouteGen);