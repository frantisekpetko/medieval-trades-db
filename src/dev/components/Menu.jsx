import React, {Component} from 'react';
import AppBar from '@material-ui/core/AppBar';
import Toolbar from '@material-ui/core/Toolbar';
import Grid from '@material-ui/core/Grid';
import Button from '@material-ui/core/Button';
import header from "../../img/header.png";
import {Link} from "react-router-dom";
//import Toast from './Toast/Toast';
//import './Toast/Toast.scss';
import withAnimationContext from '../../context/withAnimationContext';

const Menu = (props) =>   {
    console.log("Menu visible: ", props.context.visible);
    return <div>
        {
            props.context.visible && <Toast/>
        }
        <AppBar position="fixed" color="default" className="menu-customized">
            <Toolbar>
                <Grid  to='/dev' component={Link}><img className="toolbar" src={header} alt="image"/></Grid>
                <Grid container justify="flex-end">
                    <Grid>
                        <Button
                            className="right"
                            color="inherit"
                            to='/dev'
                            component={Link}>
                            Dev
                        </Button>
                    </Grid>
                    <Grid>
                        <Button
                            className="right"
                            color="inherit"
                            to='/'
                            component={Link}>
                            Home
                        </Button>
                    </Grid>
                </Grid>
            </Toolbar>
        </AppBar>
    </div>
};

export default withAnimationContext(Menu);