import React, {Component} from 'react';

import HeadHtml from "../../HeadHtml";

import TextField from '@material-ui/core/TextField';
import Grid from '@material-ui/core/Grid';
import Typography from '@material-ui/core/Typography';

import Menu from '../components/Menu';
import Footer from '../components/Footer';
import Button from '@material-ui/core/Button';
import Modal from '../components/Modal';

import ajax from '../../utils/ajax';

class ModelGen extends Component {

    state = {
        name: '',
        open: false,
        text: '',
    };

    handleClickOpen = () => {
        this.setState({
            open: true,
        });
    };


    handleClose = () => {
        this.setState({ open: false });
    };


    handleSendData = () => {
        ajax.post('/model', { name: this.state.name })
            .then((res) => {
                console.log(res.data.preview);
                this.setState({text: res.data.preview });

            })
            .catch((err) => {
                console.log(err)
            });

        this.handleClickOpen();

    };


    handleChange = name => event => {
        this.setState({
            [name]: event.target.value,
        });
    };


    render(){

        return (
            <div>
                <HeadHtml pageTitle={"Model Generator"}/>
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
                            Model Generator
                        </Typography>
                        <Typography component="p">
                            <b className="text-align-for-model">Example of text.</b><br/>
                            <i>
                                This generator generates an ActiveRecord
                                class for the specified database table.
                            </i>
                        </Typography>
                        <TextField
                            id="filled-name"
                            label="Model Class Name"
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
                        <Modal component="model"
                               title="Model"
                               subjectName={this.state.name}
                               open={this.state.open}
                               close={this.handleClose}
                               text={this.state.text}
                        />
                    </Grid>
                    <Footer/>
                </div>
            </div>

        );
    }

}

export default ModelGen;