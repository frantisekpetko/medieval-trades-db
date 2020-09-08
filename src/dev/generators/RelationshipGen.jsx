import React, {Component} from 'react';

import HeadHtml from "../../HeadHtml";

import TextField from '@material-ui/core/TextField';
import Grid from '@material-ui/core/Grid';
import Typography from '@material-ui/core/Typography';

import Menu from '../components/Menu';
import Footer from '../components/Footer';
import Button from '@material-ui/core/Button';


import ajax from '../../utils/ajax';
import FormControl from '@material-ui/core/FormControl';
import InputLabel from '@material-ui/core/InputLabel';
import Select from '@material-ui/core/Select';
import MenuItem from '@material-ui/core/MenuItem';
import SweetAlert from 'sweetalert2-react';
import lime from '@material-ui/core/colors/lime';
import red from '@material-ui/core/colors/red';
import { createMuiTheme } from '@material-ui/core/styles';
import { fade } from '@material-ui/core/styles/colorManipulator';
import SimpleModal from '../components/SimpleModal';
import Spinner from '../components/Spinner';

const theme = createMuiTheme({
    styles: {
        correct: { backgroundColor: fade(lime[500], 0.8) },
        incorrect: { backgroundColor: fade(red[500], 0.7) }
    },
    typography: {
    useNextVariants: true,
    },
});

class RelationshipGen extends Component {

    state = {
        firstEntity: '',
        secondEntity: '',
        open: false,
        text: '',
        relationship: "oneToOne",
        show: false,
        modelNames: [],
        modelNamesString: "",
        txtFieldValidity: {
            firstEntity: null,
            secondEntity: null,
        },
        modalOpen: false,
    };

    componentDidMount() {

        ajax.get('/relationship/search')
            .then(response => {
                const modelNames = response.data.modelNames;
                const modelNamesString = JSON.stringify(modelNames);
                this.setState({ modelNames: modelNames, modelNamesString: modelNamesString});
                console.log(response.status);
            })
            .catch(error => {
                console.log(error);
            });

    }


    handleManipulateWithModal = () => {
        this.setState({
            modalOpen: !this.state.modalOpen,
        });
    };


    handleClickOpen = () => {
        this.setState({
            open: true,
        });
    };

    showAvailableModals = () => {
        this.handleManipulateWithModal();
    };


    handleSendData = () => {
        if(this.state.firstEntity !== "" && this.state.secondEntity !== "") {
            ajax.post('/relationship/create',
                {
                    firstEntity: this.state.firstEntity,
                    secondEntity: this.state.secondEntity,
                    relationship: this.state.relationship,
                })
                .then((res) => {
                    console.warn("Successful: ", res.data);
                    //this.setState({text: res.data.preview });

                })
                .catch((err) => {
                    console.log(err)
                });

            this.handleClickOpen();
        }
        else {
            this.setState({show:true});
        }

    };


    handleChange = name => event => {
        let value = event.target.value;
        let counter = 0;
        this.setState({
            [name]: value,
        });
        let txtFieldValidity = this.state.txtFieldValidity;
        this.state.modelNames.some((item) => {
            console.log(item, value);
            if(item !== value) {
                txtFieldValidity[name] = false;
                this.setState({txtFieldValidity: txtFieldValidity});

            }
            else {
                txtFieldValidity[name] = true;
                this.setState({txtFieldValidity: txtFieldValidity});
                return true;
            }
        });



    };



    handleRelationshipSelectionManipulate = () => {
        this.setState({
            relationshipOpen: !this.state.relationshipOpen,
        });
    };


    render(){

        return (
            <div>
                <HeadHtml pageTitle={"Relationship Generator"}/>
                <SweetAlert
                    show={this.state.show}
                    title="At least one from inputs is empty"
                    text="Please type suitable input."
                    onConfirm={() => this.setState({ show: false })}
                />
                <div>
                    <Menu />
                    <Grid
                        className="mt-7"
                        container
                        direction="column"
                        justify="center"
                        alignItems="center"
                    >
                        <Typography className="bold" gutterBottom component="h1"  variant="headline" >
                            Relationship Generator
                        </Typography>
                        <Typography component="p">
                            <b className="text-align-for-model">Example of text.</b><br/>
                            <i>
                                This generator generates a relationships between entities/tables,
                                after generating common entities, and helps you assemble your database together.
                            </i>
                        </Typography>
                        <TextField
                            id="filled-name"
                            label="First entity name"
                            value={this.state.firstEntity}
                            onChange={this.handleChange('firstEntity')}
                            margin="normal"
                            variant="filled"
                            style={typeof this.state.txtFieldValidity.firstEntity === "boolean" ? (
                                !this.state.txtFieldValidity.firstEntity ?  theme.styles.incorrect : theme.styles.correct) : null }

                        />
                        <TextField
                            id="filled-name"
                            label="Second entity name"
                            value={this.state.secondEntity}
                            onChange={this.handleChange('secondEntity')}
                            margin="normal"
                            variant="filled"
                            style={typeof this.state.txtFieldValidity.secondEntity === "boolean" ? (
                                !this.state.txtFieldValidity.secondEntity ?  theme.styles.incorrect : theme.styles.correct) : null }
                        />

                        <FormControl className="mb-2 mt-1">
                            <InputLabel htmlFor="relationship">Relationship</InputLabel>
                            <Select
                                open={this.state.relationshipOpen}
                                onClose={()=> this.handleRelationshipSelectionManipulate()}
                                onOpen={()=> this.handleRelationshipSelectionManipulate()}
                                value={ this.state.relationship }
                                onChange={ this.handleChange('relationship', null)}
                                inputProps={{
                                    name: 'datatype',
                                    id: 'demo-controlled-open-select',
                                }}

                            >
                                <MenuItem value="oneToOne">1:1</MenuItem>
                                <MenuItem value="oneToMany">N:1</MenuItem>
                                <MenuItem value="manyToMany">N:M</MenuItem>
                            </Select>

                        </FormControl>
                        <Grid
                            container
                            direction="column"
                            justify="center"
                            alignItems="center"
                        >
                            <Button
                                className="mb-2"
                                variant="contained"
                                size="small"
                                color="default"
                                onClick={this.showAvailableModals}>
                                Show Available Entities
                            </Button>
                            <Button
                                className="mb-2"
                                variant="contained"
                                size="small"
                                color="default"
                                onClick={this.handleSendData}>
                                Pair
                            </Button>
                        </Grid>

                        {!this.state.open || this.state.modelNamesString.length > 0
                            ? <SimpleModal
                                open={this.state.modalOpen}
                                close={this.handleManipulateWithModal}
                                data={this.state.modelNamesString}
                            />
                            : <Spinner/>
                        }


                    </Grid>
                    <Footer/>
                </div>
            </div>

        );
    }

}

export default RelationshipGen;