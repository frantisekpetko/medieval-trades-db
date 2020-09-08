import React from 'react';
import "./SplashScreen.scss";

const LoaderIn = (props) => (
    <div className="body-color">
        <div className="page-loader">
            <div className="border-radius-for-icon">
               <img className="logo" src={"public/logo.png"}/>
            </div>
            <h2 className="header2 h2-size">Sweetheart.cz</h2>
        </div>
    </div>
);

export default LoaderIn;