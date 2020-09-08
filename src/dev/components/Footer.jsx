import React from 'react';
import Typography from '@material-ui/core/Typography';
import Grid from '@material-ui/core/Grid';

const Footer = () => (
    <div className="footer">
        <Grid justify="space-between" container>
            <Typography className="footer-text right-text" component="p">
                A product of František Petko
            </Typography>
            <Typography className="footer-text customized-paragraph" component="p">
                Powered by 	Activeness
            </Typography>
        </Grid>
    </div>
);

export default Footer;