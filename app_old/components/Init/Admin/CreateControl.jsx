import React from 'react';
import API from 'utils/API';

import Grid from "@material-ui/core/Grid";
import Typography from '@material-ui/core/Typography';
import Button from '@material-ui/core/Button';
import CreateAdmin from './CreateAdmin/CreateAdmin';
import AddAlert from '@material-ui/core/SvgIcon/SvgIcon';
import Snackbar from '../../../adminsrc/components/Snackbar/Snackbar';


const styles = {
    cardCategoryWhite: {
        "&,& a,& a:hover,& a:focus": {
            color: "rgba(255,255,255,.62)",
            margin: "0",
            fontSize: "14px",
            marginTop: "0",
            marginBottom: "0"
        },
        "& a,& a:hover,& a:focus": {
            color: "#FFFFFF"
        }
    },
    cardTitleWhite: {
        color: "#FFFFFF",
        marginTop: "0px",
        minHeight: "auto",
        fontWeight: "300",
        fontFamily: "'Roboto', 'Helvetica', 'Arial', sans-serif",
        marginBottom: "3px",
        textDecoration: "none",
        "& small": {
            color: "#777",
            fontSize: "65%",
            fontWeight: "400",
            lineHeight: "1"
        }
    }
};

class CreateControl extends React.Component {

    state = {
        // adminsrc
        name: "",
        email: "",
        //frantisek.petko876@gmail.com
        password: "",
        auth_status: "alright",
        tc: false,
    };

    // to stop the warning of calling setState of unmounted component
    componentWillUnmount() {
        var id = window.setTimeout(null, 0);
        while (id--) {
            window.clearTimeout(id);
        }
    }

    showNotification(place) {
        var x = [];
        x[place] = true;
        this.setState(x);
        this.alertTimeout = setTimeout(
            function() {
                x[place] = false;
                this.setState(x);
            }.bind(this),
            6000
        );
    }

    handleChange = (event, name) => {
        this.setState({
            [name]: event.target.value,
        });
    };

    registerAdmin = async () => {
        try {
            const data = {
                name: this.state.name,
                email: this.state.email,
                password: this.state.password,
                auth_status: this.state.auth_status,
            };

            const res = await API.post("admin/register", data);
            console.log("Succesful response: \n", res);
            this.showNotification("tc");
        }
        catch (e) {
            console.warn(`Fetch error occurred:\n ${e}`)
        }
    };

    render() {
        const message = `${this.state.name}, byl jste úspěšně zaregistrován jako admin/ka! :)`;

        return <React.Fragment>
            <Grid
                container
                direction="column"
                justify="center"
                alignItems="center"
            >
                <Snackbar
                    place="tc"
                    color="info"
                    icon={AddAlert}
                    message={message}
                    open={this.state.tc}
                    closeNotification={() => this.setState({ tc: false })}
                    close
                />
                <Typography className="bold" gutterBottom component="h1"  variant="headline" >
                    Admin - Sign up
                </Typography>
                <CreateAdmin
                    name={this.state.img_name}
                    email={this.state.email}
                    password={this.state.password}
                    changeImage={this.handleChange}
                />
                <Button
                    variant="contained"
                    size="small"
                    color="secondary"
                    onClick={this.registerAdmin}
                    className="mb-2"
                >
                    Register
                </Button>

            </Grid>
        </React.Fragment>
    }
}

export default CreateControl;