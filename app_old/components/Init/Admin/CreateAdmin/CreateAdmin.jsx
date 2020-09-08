import React from 'react';
import Typography from '@material-ui/core/Typography';
import TextField from '@material-ui/core/TextField';
import Grid from '@material-ui/core/Grid';
import Snackbar from '../../../../adminsrc/components/Snackbar/Snackbar';
import AddAlert from '@material-ui/core/SvgIcon/SvgIcon';
import GridItem from '../../../../adminsrc/components/Grid/GridItem';


export default function CreateAdmin(props){

        return (
            <React.Fragment>
                <Typography className="bold" gutterBottom component="h3"  variant="overline" >
                    Register
                </Typography>

                <TextField
                    id="filled-name"
                    label={"name"}
                    value={props.name}
                    onChange={(e)=> props.changeImage(e, "name")}
                    margin="normal"
                    variant="filled"
                    className="ml-1"
                />

                <TextField
                    id="filled-name"
                    label={"email"}
                    type="email"
                    value={props.email}
                    onChange={(e)=> props.changeImage(e, "email")}
                    margin="normal"
                    variant="filled"
                    className="mb-2"
                />

                <TextField
                    id="filled-name"
                    label={"password"}
                    type="password"
                    value={props.password}
                    onChange={(e)=> props.changeImage(e, "password")}
                    margin="normal"
                    variant="filled"
                    className="ml-1"
                />
            </React.Fragment>
        );
}