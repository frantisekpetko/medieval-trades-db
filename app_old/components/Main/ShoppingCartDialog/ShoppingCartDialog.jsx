import React from 'react';

import green from '@material-ui/core/colors/green';
import FormGroup from '@material-ui/core/FormGroup';
import FormControlLabel from '@material-ui/core/FormControlLabel';
import Checkbox from '@material-ui/core/Checkbox';
import CheckBoxOutlineBlankIcon from '@material-ui/icons/CheckBoxOutlineBlank';
import CheckBoxIcon from '@material-ui/icons/CheckBox';
import Favorite from '@material-ui/icons/Favorite';
import FavoriteBorder from '@material-ui/icons/FavoriteBorder';
import TextField from '@material-ui/core/TextField';
import Field from '@material-ui/core/';
import Button from '@material-ui/core/Button';
import Dialog from '@material-ui/core/Dialog';
import DialogActions from '@material-ui/core/DialogActions';
import DialogContent from '@material-ui/core/DialogContent';
import DialogContentText from '@material-ui/core/DialogContentText';
import DialogTitle from '@material-ui/core/DialogTitle';
import withMobileDialog from '@material-ui/core/withMobileDialog';
import Grid from '@material-ui/core/Grid';
import Avatar from '@material-ui/core/Avatar';



function ShoppinGCartDialog(props) {
    const {
        fullScreen,
        modal,
        handleOpenDialog,
        handleCloseDialog,
        numberInOrder,
        changeNumberProductsInOrder,
        image,
        productName
    } = props;

    return (
        <div>
            <Dialog
                fullScreen={fullScreen}
                open={modal}
                onClose={handleCloseDialog }
                aria-labelledby="responsive-dialog-title"
            >
                <DialogTitle id="responsive-dialog-title">{"Nákup - "}<b>{productName}</b></DialogTitle>
                <DialogContent>
                        <Avatar alt="Remy Sharp" src={image} className="orderImage" />
                    <Grid>
                    <TextField
                        id="order"
                        label="Number of products"
                        type="number"
                        onChange={(e) => changeNumberProductsInOrder(e)}
                        value={numberInOrder}
                        InputLabelProps={{
                            shrink: true,
                        }}
                    />
                    </Grid>


                </DialogContent>
                <DialogActions>

                    <Button onClick={handleCloseDialog } color="primary">
                        Pokračovat v nákupu
                    </Button>
                    <Button onClick={handleCloseDialog } color="primary" autoFocus>
                        Přidat do košíku
                    </Button>
                </DialogActions>
            </Dialog>
        </div>
    );
}

export default withMobileDialog()(ShoppinGCartDialog);
