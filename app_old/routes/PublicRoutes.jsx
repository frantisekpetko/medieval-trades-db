import React from 'react';
import { Route, Switch } from 'react-router-dom';
import CreateInitData from '../components/Init/Product/CreateInitData';
import Cors from '../Cors';
import App from '../components/Main/App';
import CreateControl from '../components/Init/Admin/CreateControl';
import AdminLogin from '../components/Main/AdminLogin/AdminLogin';
import RedirectToApi from '../RedirectToApi';
import Detail from '../components/Main/Detail/Detail';
import NotFound from '../components/Main/NotFound/NotFound';
import withAppContext from "../context/withAppContext";
import DebugBoundary from "../ErrorBoundary/DebugBoundary";


const PublicRoutes = (props) => (

    <Switch>

        <Route
            path="/api/:resource/:index?"
            component={() => (
                <RedirectToApi/>
            )}
        />

        <Route
            exact
            path="/product/:id/detail"
            component={() => (
                    <Detail />
            )}
        />

        <Route
            exact
            path="/admin"
            component={() => (
                <AdminLogin />
            )}
        />


        <Route
            exact
            path="/cors"
            component={() => (
                <Cors />
            )}
        />

        <Route
            exact
            path="/"
            component={() => (
                    <App/>
            )}
        />

        <Route
            component={() => (
                <NotFound />
            )}
        />
    </Switch>
);

export default PublicRoutes;