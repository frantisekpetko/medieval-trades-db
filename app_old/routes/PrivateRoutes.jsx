import React from 'react';
import { Route, Switch } from 'react-router-dom';
import CreateInitData from '../components/Init/Product/CreateInitData';
import Cors from '../Cors';
import App from '../components/Main/App';
import CreateControl from '../components/Init/Admin/CreateControl';
import CMS from '../components/Init/Admin/CMS/CMS';
import AdminLogin from '../components/Main/AdminLogin/AdminLogin';
import NotFound from '../components/Main/NotFound/NotFound';
import Notifications from 'components/Init/Admin/Notifications';
import Dashboard from '../components/Init/Admin/CMS/Dashboard';
import TableList from '../components/Init/Admin/CMS/TableList';
import UserProfile from '../components/Init/Admin/CMS/UserProfile';

const PrivateRoutes = (props) => (
    <Switch>
        <Route
            exact
            path="/create"
            component={() => (
                <CreateInitData />
            )}
        />

        <Route
            exact
            path="/new"
            component={() => (
                <CreateControl />
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
            path="/cms"
            component={() => (
                <CMS />
            )}
        />

        <Route
            exact
            path="/"
            component={() => (
                <CMS/>
            )}CSSImportRule
        />

        <Route
            component={() => (
                <NotFound />
            )}
        />
    </Switch>
);

export default PrivateRoutes;