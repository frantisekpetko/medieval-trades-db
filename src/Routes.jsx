import React from 'react';
import { Route, Switch } from 'react-router-dom';

import Character from './components/Character';
import About from './components/About';
import NotFound from './components/NotFound/NotFound';
import CorsInfo from './components/CorsInfo';
import DebugBoundary from './components/DebugBoundary/DebugBoundary';
import Page from './components/Page';
import Dev from './dev/index';
import ModelGen from './dev/generators/ModelGen';
import Welcome from './components/Welcome/Welcome';
import EntityGen from './dev/generators/EntityGen';
import RedirectToApi from './RedirectToApi';
import RouteGen from "./dev/generators/RouteGen";
import ServerShutdown from './components/ServerShutdown';
import RelationshipGen from './dev/generators/RelationshipGen';
import DatabaseAssist from './dev/generators/DatabaseAssist';
import Exceptions from './dev/exceptions/Exceptions/Exceptions';
import withAnimationContext from './context/withAnimationContext';


const Routes = () => (

    <Switch>
        <Route
            path="/api/:resource/:index?"
            component={() => (
                <DebugBoundary>
                    <RedirectToApi/>
                </DebugBoundary>
            )}
        />

        <Route
            path="/dev/relationship"
            exact
            component={() => (
                <DebugBoundary>
                    <RelationshipGen/>
                </DebugBoundary>
            )}
        />

        <Route
            path="/dev/db-assistant"
            exact
            component={() => (
                <DebugBoundary>
                    <DatabaseAssist/>
                </DebugBoundary>
            )}
        />

        <Route
            path="/dev/exceptions"
            exact
            component={() => (
                <DebugBoundary>
                    <Exceptions/>
                </DebugBoundary>
            )}
        />


        <Route
            path="/dev/entity"
            exact
            component={() => (
                <DebugBoundary>
                    <EntityGen />
                </DebugBoundary>
            )}
        />

        <Route
            path="/dev/routing"
            exact
            component={() => (
                <DebugBoundary>
                    <RouteGen />
                </DebugBoundary>
            )}
        />

        <Route
            path="/dev/stars"
            exact
            component={() => (
                <DebugBoundary>
                    <ServerShutdown />
                </DebugBoundary>
            )}
        />

        <Route
            path="/dev/model"
            exact
            component={() => (
                <DebugBoundary>
                    <ModelGen />
                </DebugBoundary>
            )}
        />


        <Route
            path="/character"
            component={() => (
                <DebugBoundary>
                    <Character />
                </DebugBoundary>
            )}
        />

        <Route
            path="/welcome"
            component={() => (
                <DebugBoundary>
                    <Welcome />
                </DebugBoundary>
            )}
        />

        <Route
            path="/page"
            component={() => (
                <DebugBoundary>
                    <Page />
                </DebugBoundary>
            )}
        />

        <Route
            path="/cors"
            component={() => (
                <DebugBoundary>
                    <CorsInfo />
                </DebugBoundary>
            )}
        />
        <Route
            path="/about"
            component={() => (
                <DebugBoundary>
                    <About />
                </DebugBoundary>
            )}
        />

        <Route
            exact
            path="/dev"
            component={() => (
                <DebugBoundary>
                    <Dev />
                </DebugBoundary>
            )}
        />

        <Route
            exact
            path="/"
            component={() => (
                <DebugBoundary>
                    <Welcome />
                </DebugBoundary>
            )}
        />

        <Route
            component={() => (
                <DebugBoundary>
                    <NotFound />
                </DebugBoundary>
            )}
        />
    </Switch>
);

export default withAnimationContext(Routes);
