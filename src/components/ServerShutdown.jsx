import React, { Component } from 'react'

import StarfieldAnimation from 'react-starfield-animation';
import HeadHtml from '../HeadHtml';


class ServerShutdown extends Component {

    componentDidMount() {
        document.body.style.backgroundColor = 'black';
    }

    componentWillUnmount() {
        document.body.style.backgroundColor =  null;
    }

    render () {
        return (
            <div style={{ maxHeight: '1rem'}}>
                <HeadHtml pageTitle={"Server Shutdown"} />
                <h1
                    style={{
                        color: '#fff',
                        fontSize: '3em',
                        fontFamily: 'Quicksand, "Helvetica Neue", sans-serif',
                        textShadow: '2px 2px 8px rgba(0, 0, 0, 0.5)',

                        textAlign: "center",
                        verticalAlign: "middle",
                        lineHeight: "45rem",

                    }}
                >
                    Server is temporary under maintenance.

                </h1>
                <StarfieldAnimation
                    numParticles={400}
                    style={{
                        position: 'absolute',
                        zIndex: 1,
                        top: 0,
                        left: 0,
                        right: 0,
                        bottom: 0,
                        overflowY: "hidden", overflowX: "auto"
                    }}
                />
            </div>


        )
    }
}

export default ServerShutdown;