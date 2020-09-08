import React from 'react';

import HeadHtml from '../HeadHtml';

import Typography from '@material-ui/core/Typography';
import Divider from '@material-ui/core/Divider';

import Menu from './components/Menu';
import Content from './components/Content';
import Footer from './components/Footer';

import withAnimationContext from '../context/withAnimationContext';
import "./index.scss";

const Dev = (props) => (
    <React.Fragment>
        <HeadHtml pageTitle={"Dev Code Generator"} />
        <Menu/>
        <div className="mt-4" style={{display:"flex"}}>
            <Typography className="title" variant="h1" color="inherit">
                Welcome to Astrum <small>a supergalactic tool that can write code for you</small>
            </Typography>
        </div>
        <Divider/>
        <Content />
        <Divider className="mt-2 mb-1"/>
        <Footer />
    </React.Fragment>

);


export default withAnimationContext(Dev);