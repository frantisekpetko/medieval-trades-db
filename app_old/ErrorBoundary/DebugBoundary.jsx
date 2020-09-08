import React from 'react';
import HeadHtml from '../HeadHtml';
import ajax from '../utils/API';
import moment from 'moment';
import "./DebugBoundary.scss";
import Grid from '@material-ui/core/Grid';
import Typography from '@material-ui/core/Typography';
import Paper from '@material-ui/core/Paper';
import StarfieldAnimation from 'react-starfield-animation';

class DebugBoundary extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            hasError: false,
            line: null,
            info: null,
            exception: [],
            params: null,
        };
    }


    fetchData() {
        ajax.get('/exception')
            .then(res => {
                if (res.data[0].__exception[0].message !== 'sCall to a member function getStatusCode() on null') {
                    this.setState({
                        exception: res.data[0].__exception
                    });

                    //console.warn("*****Exception*********\n", res.data[0]);
                }
            })
            .catch(err => {
                console.log(err);
            });
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
        /*
        StackTrace.fromError(error).then(err => {
            StackTrace.report(
                err,
                `//${window.location.hostname}:${process.env.REACT_APP_LOGGER_PORT || 3334}/jsnlog.logger`,
                {
                    type: "React boundary",
                    url: window.location.href,
                    userId: window.userId,
                    agent: window.navigator.userAgent,
                    date: new Date(),
                    msg: error.toString()
                }
            );
        });

        let params = {stackframes: ErrorStackParser.parse(error)};
        console.warn("Warning", params);

        */
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
                            Client Side Error at<br/> 
                            {` ${moment()
                            .format('YYYY-MM-DD HH:mm:ss:SSS')
                            .toString()} `}
                            </Typography>
                            <Typography className="debug-txt error" variant="body1" gutterBottom>The error: {this.state.error.toString()}</Typography>
                            <Typography className="bold-text mt-1 debug-txt" component="h5" variant="title" gutterBottom>
                                Component Stack: 
                             </Typography>
                            <Typography className="component-stack debug-txt" variant="caption" gutterBottom style={{ whiteSpace: 'pre-wrap' }}>
                                {this.state.info.componentStack}¨
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

export default DebugBoundary;
