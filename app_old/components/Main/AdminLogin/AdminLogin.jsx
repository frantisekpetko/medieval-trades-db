import React from 'react';
import Typography from '@material-ui/core/Typography';
import TextField from '@material-ui/core/TextField';
import API from 'utils/API';
import Button from '@material-ui/core/Button';
import Grid from '@material-ui/core/Grid';
import HeadHtml from '../../../HeadHtml';
import AppContext from 'context/AppContext'


class AdminLoginReadyForContext extends React.Component {

    state = {
        // adminsrc
        email: "",
        password: "",
        loading: false,
    };

    handleChange = (event, name) => {
        this.setState({
            [name]: event.target.value,
        });
    };

    loginAdmin =  () => {
        const data = {
            email: this.state.email,
            password: this.state.password,
        };

        this.setState({loading: true});
        return API.post('admin/login', data)
            .then(() => {
                this.props.onUserLoginSucceed();
            })
            .catch((err) => {
                console.error(err);
                this.setState({
                    loading: false,
                    err: true
                });
            });
    };

    render() {
        return <React.Fragment>
            <Grid
                container
                direction="column"
                justify="center"
                alignItems="center"
            >
                <Typography className="bold" gutterBottom component="h3"  variant="overline" >
                    Admin Login
                </Typography>

                <TextField
                    id="filled-name"
                    label={"email"}
                    type="email"
                    value={this.state.email}
                    onChange={(e)=> this.handleChange(e, "email")}
                    margin="normal"
                    variant="filled"
                    className="mb-2"
                />

                <TextField
                    id="filled-name"
                    label={"password"}
                    type="password"
                    value={this.state.password}
                    onChange={(e)=> this.handleChange(e, "password")}
                    margin="normal"
                    variant="filled"
                    className="ml-1"
                />

                <Button
                    variant="contained"
                    size="small"
                    color="secondary"
                    onClick={this.loginAdmin}
                    className="mb-2"
                >
                    Login
                </Button>
            </Grid>
        </React.Fragment>;
    }

}


export default class AdminLogin extends React.Component {

    render() {
        return <AppContext.Consumer>
            {(appContext) => <AdminLoginReadyForContext {...appContext}/>}
        </AppContext.Consumer>
    }
}