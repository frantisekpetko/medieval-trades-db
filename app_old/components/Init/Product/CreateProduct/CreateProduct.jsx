import React from 'react';
import Typography from '@material-ui/core/Typography';
import TextField from '@material-ui/core/TextField';


export default function CreateProduct(props) {
    return (
        <React.Fragment>
            <Typography className="bold" gutterBottom component="h3" variant="overline">
                Product
            </Typography>
            <TextField
                id="filled-name"
                label={"name"}
                value={props.name}
                onChange={(e) => props.changeProduct(e, "name")}
                margin="normal"
                variant="filled"
                className="ml-1"
            />

            <TextField
                id="filled-name"
                label={"title"}
                value={props.title}
                onChange={(e) => props.changeProduct(e, "title")}
                margin="normal"
                variant="filled"
                className="ml-1"
            />

            <TextField
                id="filled-name"
                label={"description"}
                multiline
                rowsMax="10"
                value={props.description}
                onChange={(e) => props.changeProduct(e, "description")}
                margin="normal"
                variant="filled"
                className="ml-1"
            />


            <TextField
                id="filled-name"
                label={"stock quantity"}
                value={props.stockQuantity}
                onChange={(e) => props.changeProduct(e, "stock_quantity")}
                margin="normal"
                variant="filled"
                className="ml-1"
            />

            <TextField
                id="filled-name"
                label={"price"}
                value={props.price}
                onChange={(e) => props.changeProduct(e, "price")}
                margin="normal"
                variant="filled"
                className="ml-1"
            />

            <TextField
                id="filled-name"
                label={"vat"}
                value={props.vat}
                onChange={(e) => props.changeProduct(e, "vat")}
                margin="normal"
                variant="filled"
                className="ml-1"
            />

            <TextField
                id="filled-name"
                label={"discount"}
                value={props.discount}
                onChange={(e) => props.changeProduct(e, "discount")}
                margin="normal"
                variant="filled"
                className="ml-1"
            />

            <TextField
                id="filled-name"
                label={"category"}
                value={props.category}
                onChange={(e) => props.changeProduct(e, "category")}
                margin="normal"
                variant="filled"
                className="ml-1"
            />
        </React.Fragment>
    )
}