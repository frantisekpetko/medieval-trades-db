import React from 'react';
import Typography from '@material-ui/core/Typography';
import TextField from '@material-ui/core/TextField';


const CreateCategory = props =>  {
    return <React.Fragment>
        <Typography className="mt-2 bold" gutterBottom component="h3" variant="overline">
            Category
        </Typography>

        <TextField
            id="filled-name"
            label={"title"}
            value={props.title}
            onChange={(e) => props.changeCategory(e, "c_title")}
            margin="normal"
            variant="filled"
            className="ml-1"
        />

        <TextField
            id="filled-name"
            label={"product count"}
            value={props.product_count}
            onChange={(e) => props.changeCategory(e, "product_count")}
            margin="normal"
            variant="filled"
            className="ml-1"
        />

        <TextField
            id="filled-name"
            label={"parent id"}
            value={props.parent_id}
            onChange={(e) => props.changeCategory(e, "parent_id")}
            margin="normal"
            variant="filled"
            className="ml-1"
        />
    </React.Fragment>;
};

export default CreateCategory;