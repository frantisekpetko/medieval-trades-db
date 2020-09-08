import React from 'react';
import Grid from '@material-ui/core/Grid';
import HeadHtml from '../../HeadHtml';
import './NotFound.scss';

const NotFound = (props) => (
    <React.Fragment>
        <HeadHtml pageTitle="Not Found"/>
        <div className="vertical-center">
            <div className="container">
            <Grid container direction="row"  justify="center" alignItems="flex-end">
            <h1 className="center">404 Error - Page with url '{window.location.pathname}' not found. <br/>
            Ouu, have mercy on us, Magnificent stars!
            </h1>
           </Grid>
            </div>
        </div>
    </React.Fragment>
);

export default NotFound;