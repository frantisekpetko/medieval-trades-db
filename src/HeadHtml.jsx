import React from 'react';
import {Helmet} from "react-helmet";
import ajax from './utils/ajax';
import favicon from './img/favicon.ico';


class HeadHtml extends React.Component {

    constructor(props) {
        super(props);
        this.state = {appName: "Loading .."};
    }

    componentDidMount()
    {
        ajax.get("/app-name")
                .then((response) => {
                    const appName = response.data[0].appName;
                    //console.log("response", response.data);
                    this.setState({appName: appName});

                })
                .catch((error) => {
                    console.log(error);
        })
    }

    render()
    {
        const {appName} = this.state;

        let checkForIsDebug = !(this.props.isDebug === null || this.props.isDebug === undefined);

        const {pageTitle} = this.props;
        return <Helmet>
                <meta charSet="utf-8"/>
                <title>{`${!checkForIsDebug ? "Scaffolding" : "Debug >"} ${!checkForIsDebug ?   "-" : ""} ${pageTitle}`}</title>
                <link rel="shortcut icon" href={favicon} />
                {/*process.env.PUBLIC_URLs + "/favicon.ico"*/}
                /*
                * TODO udělat kompatibilizu icony pro android mobilní zařízení
                */
                {/*<link rel="manifest" href="/manifest.json"/>*/}
                <meta
                    name="viewport"
                    content="minimum-scale=1, initial-scale=1, width=device-width, shrink-to-fit=no"
                />
        </Helmet>
     }

}

export default HeadHtml;
