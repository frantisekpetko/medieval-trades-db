import React from 'react';
import { Grid } from '@material-ui/core';

const Footer = () => (
    <div>
        <footer className="text-center pt-3 pb-1 border-silver border-medium">
            <Grid
                container
                direction="column"
                justify="center"
                alignItems="center"
            >

                <span className="footer-custom-text">Copyright&copy;2019 E-shop Sweetheart<br /></span>
                <span className="hand-writed"> Created by František Petko <br /></span>
            </Grid>
        </footer>
    </div>
);

export default Footer;