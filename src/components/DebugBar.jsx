import React, {Component} from 'react';

import Grid from '@material-ui/core/Grid';
import Typography from '@material-ui/core/Typography';
import BurgerMenuIcon from "./BurgerMenuIcon";

class DebugBar extends Component {

    constructor(props){
        super(props);
    }

    render() {
        return <div>
            <div className="debug-bar">
                <Grid justify="space-between" container>
                    <Typography className="footer-text right-text" component="p">
                        lorem ipsum
                    </Typography>
                    <Typography className="footer-text customized-paragraph" component="p">
                        lorem ipsum
                    </Typography>

                    <BurgerMenuIcon innerMenu={false}
                                    changeIcon={this.props.open}
                                    clickable={this.props.nav}
                                    bottom={false}
                    />


                </Grid>
            </div>
        </div>
    }

}

export default DebugBar;