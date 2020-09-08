import React from 'react';

import Button from '@material-ui/core/Button';
import Dialog from '@material-ui/core/Dialog';
import MuiDialogTitle from '@material-ui/core/DialogTitle';
import Grid from '@material-ui/core/Grid';
import DialogContent from '@material-ui/core/DialogContent';
import DialogActions from '@material-ui/core/DialogActions';
import IconButton from '@material-ui/core/IconButton';
import CloseIcon from '@material-ui/icons/Close';
import Typography from '@material-ui/core/Typography';
import Lowlight from 'react-lowlight';
import json from 'highlight.js/lib/languages/json';

Lowlight.registerLanguage('json', json);
import './default.scss';

const DialogTitle = props => {
    const { children, onClose } = props;
    return (
        <Grid
            container
            direction="column"
            justify="center"
            alignItems="center">
            <MuiDialogTitle disableTypography>
                <IconButton aria-label="Close" className="closeBtn" onClick={onClose}>
                    <CloseIcon />
                </IconButton>
                <Typography variant="h6">{children}</Typography>


            </MuiDialogTitle>
        </Grid>

    );
};

function TabContainer({ children, dir }) {
    return (
        <Typography component="div" dir={dir} style={{ padding: 8 * 3 }}>
            {children}
        </Typography>
    );
}

const SimpleModal = (props) => (
    <div>
        <Dialog
            onClose={props.handleManipulateWithModal}
            aria-labelledby="customized-dialog-title"
            open={props.open}
            className="modal-size"
        >
            <TabContainer dir={'x-reverse'}>
                <DialogTitle id="customized-dialog-title" onClose={props.close}>
                    Available Entities
                </DialogTitle>
                <DialogContent>
                    <Lowlight
                        language="json"
                        value={props.data}
                    />
                </DialogContent>
                <DialogActions>
                </DialogActions>
            </TabContainer>
        </Dialog>
    </div>
);


export default SimpleModal;