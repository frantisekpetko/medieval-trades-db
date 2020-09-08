import React from 'react';
import Typography from '@material-ui/core/Typography';
import TextField from '@material-ui/core/TextField';
import Grid from '@material-ui/core/Grid';


export default function CreateImage(props) {
    return (
        <React.Fragment>
            <Typography className="bold" gutterBottom component="h3"  variant="overline" >
                Image
            </Typography>

            <TextField
                id="filled-name"
                label={"image name"}
                value={props.imageName}
                onChange={(e)=> props.changeImage(e, "img_name")}
                margin="normal"
                variant="filled"
                className="ml-1"
            />

            <TextField
                id="filled-name"
                label={"image path"}
                value={props.imagePath}
                onChange={(e)=> props.changeImage(e, "img_path")}
                margin="normal"
                variant="filled"
                className="mb-2"
            />
        </React.Fragment>
    );
}