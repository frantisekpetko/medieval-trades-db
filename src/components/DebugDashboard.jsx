import BurgerMenuIcon from "./BurgerMenuIcon";
import React from "react";
import Grid from '@material-ui/core/Grid';


class DebugDashboard extends React.Component {

    constructor(props){
        super(props);
    }

    render() {
        return <div>
            <div id="mySidenav"
                 style={this.props.open === true ? {width:  "100%"} :  {width:  "0"} }
                 className="sidenav">
                <Grid
                    container
                    direction="row"
                    justify="flex-end"
                    alignItems="flex-end"
                >
                </Grid>
                <BurgerMenuIcon className="bot"
                                innerMenu={true}
                                changeIcon={this.props.open}
                                clickable={this.props.nav}
                                bottom={true}
                />

            </div>
        </div>
    }
}

export default DebugDashboard;

