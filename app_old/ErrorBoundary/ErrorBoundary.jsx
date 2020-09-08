import React from 'react';
import HeadHtml from '../HeadHtml';
import ajax from '../utils/API';
import moment from 'moment';
import "./ErrorBoundary.scss";
import Grid from '@material-ui/core/Grid';
import Typography from '@material-ui/core/Typography';
import Paper from '@material-ui/core/Paper';
import StarfieldAnimation from 'react-starfield-animation';

class ErrorBoundary extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            hasError: false,
            params: null,
        };
    }


    log() {
        const { error, info } = this.state;
        console.log('log', error);
        let pos = this.state.error.stack.toString().indexOf('?:');
        let line = this.state.error.stack.toString().substring(pos + 2, pos + 4);
        line = parseInt(line);
        console.log('????????POS', this.state.error.stack.toString());
        console.log('__________-POS', pos);
        console.log('Line', line);
        const data = {
            createdAt: moment()
                .format('YYYY-MM-DD HH:mm:ss:SSS')
                .toString(),
            //line: line,
            info: this.state.error.toString(),
            error: this.state.info.componentStack.toString(),
            example: this.state.error,
        };

        ajax.post('/debug/client/error', data)
            .then(response => {
                console.log(response.data);
            })
            .catch(error => {
                console.log(error);
            });
    }

    componentDidCatch(error, info) {
        this.setState({
            hasError: true,
            error: error,
            info: info
        });
    }

    render() {
        //console.warn("Exception\n", this.state.exception);
        //const {error} = this.state;
        console.log(moment().format('YYYY-MM-DD HH:mm:ss:SSS'));


        const maxWindowHeigh = window.innerHeight - 100;

        if (this.state.hasError) {
            this.log();

            //console.log("pos", pos);
            console.log('this.state.error', this.state.error);
            return (
                <div className="black-bg">
                    <StarfieldAnimation
                        numParticles={500}
                        style={{
                            position: 'fixed',
                            zIndex: 50000,
                            top: 0,
                            left: 0,
                            right: 0,
                            bottom: 0,
                            width: "100%",
                            height: "100%",
                            overflowY: "hidden", overflowX: "auto"
                        }}
                    />
                    <div>
                        <HeadHtml isDebug={true} pageTitle={this.state.error.toString()} />
                        <Paper id="scrollbar-style"  className="red-screen scrollbar "  style={{maxHeight: maxWindowHeigh, overflow: 'auto'}}>
                            <Grid
                                container
                                direction="column"
                                justify="center"
                                alignItems="center"

                            >

                                <Typography variant="h4" gutterBottom className="center debug-txt">
                                    We are sorry, something went wrong at<br/>
                                    {` ${moment()
                                        .format('YYYY/MM/DD HH:mm:ss')
                                        .toString()} `}
                                </Typography>
                                <Typography className="debug-txt error" variant="body1" gutterBottom>Server side Error</Typography>
                                <Typography className="bold-text mt-1 debug-txt" component="h5" variant="title" gutterBottom>
                                    Server side Error occured at this website. Please back to basic http/s address or try it later.
                                </Typography>
                            </Grid>
                        </Paper>


                    </div>
                </div>


            );
        }
        return this.props.children;
    }
}

export default ErrorBoundary;
