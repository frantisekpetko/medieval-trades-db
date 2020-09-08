import React from 'react';
import Button from '@material-ui/core/Button';
import Grid from '@material-ui/core/Grid';
import {withRouter} from 'react-router-dom';
import AdminHeader from './AdminHeader/AdminHeader';

import API from 'utils/API';


class CMS extends React.Component {

    state = {
        loading: false,
        showDrawer: false,
    };

    showMenu = () => {

        this.setState({showDrawer: true});
    };

    logout = (e) => {
        e.preventDefault();
        this.setState({loading: true});
        API.post('admin/logout')
            .then(res => {
                this.props.history.push("/");
                location.reload();

            })
            .catch(error => {
                console.log(error);
            });
    };


    render() {
        console.log(this.state.showDrawer);

        return<React.Fragment>
            <AdminHeader/>
            <div className="mt-9">

                <h1>Hello Admin</h1>
                <br/>
                <Button
                    variant="contained"
                    size="small"
                    color="secondary"
                    onClick={this.logout}
                    className="mb-2"
                >
                    Logout
                </Button>
            </div>

        </React.Fragment>;
    }

}

export default withRouter(CMS);