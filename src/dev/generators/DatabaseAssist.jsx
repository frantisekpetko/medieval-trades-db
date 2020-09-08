import React, {Component} from 'react';
import HeadHtml from '../../HeadHtml';
import Menu from '../components/Menu';
import Grid from '@material-ui/core/Grid';
import Typography from '@material-ui/core/Typography';
import Button from '@material-ui/core/Button';
import ajax from '../../utils/ajax';
import Footer from '../components/Footer';
import DatabaseAlert from '../components/DatabaseAlert';
import withAnimationContext from '../../context/withAnimationContext';


class DatabaseAssist extends Component {

    state = {
        show: false,
    };

    handleSendReqToCleanUpDatabase = () => {


        ajax.post('/database/cleanup', {})
            .then( (res) => {
                    console.log(`#################################\nRemovedTables => \n${res.data}`);

                }
            )
            .catch((err) => {
                console.error(`#################################\nError => \n${err}`);
            });
        //const visible = {visible: true} ;
        //this.props.context.givePropToHighestComponent(visible);
        this.props.context.showToaster();
        this.handleCloseAlert();



    };

    handleSendReqToInitDevDatabase = () => {
        ajax.post('/dev/database/init', {})
            .then( (res) => {
                    console.log(`#################################\nRemovedTables => \n${res.data}`);
                }
            )
            .catch((err) => {
                console.error(`#################################\nError => \n${err}`);
            });
    };

    handleOpenAlert = () => {
        this.setState({ show: true});
    };

    handleCloseAlert = () => {
        this.setState({ show: false });
    };

    render() {
        console.log(this.state.show);
        return <div>
            <HeadHtml pageTitle={"Database Assistant"}/>



            <div>
                {this.state.show && <DatabaseAlert
                    show={this.state.show}
                    sendReq={ this.handleSendReqToCleanUpDatabase}
                    close={this.handleCloseAlert}
                />}
                <Menu />
                <Grid
                    className="mt-7"
                    container
                    direction="column"
                    justify="center"
                    alignItems="center"
                >
                    <Typography className="bold" gutterBottom component="h1"  variant="headline" >
                        Database Assistant
                    </Typography>
                    <Typography component="p">
                        <b className="text-align-for-migration">Example of text.</b><br/>
                        <i>
                            This generator/assistant helps you with routine tasks at database, like seeding data to database, cleaning up and removing
                            data from database and re-creating of database schema.
                        </i>
                    </Typography>




                    <Button
                        className="mt-2"
                        variant="contained"
                        size="small"
                        color="default"
                        onClick={this.handleSendReqToInitDevDatabase}>
                        Init Dev Database
                    </Button>

                    <Button
                        className="mt-2"
                        variant="contained"
                        size="small"
                        color="default"
                        onClick={() => this.handleOpenAlert()}>
                        Clean Up Database
                    </Button>


                </Grid>
                <Footer/>
            </div>

        </div>
    }

}


export default withAnimationContext(DatabaseAssist);