import React from 'react';
import AppBar from '@material-ui/core/AppBar';
import Toolbar from '@material-ui/core/Toolbar';
import Grid from '@material-ui/core/Grid';
import Button from '@material-ui/core/Button';
import {Link} from "react-router-dom";
import SearchInput, {createFilter} from 'react-search-input';

const KEYS_TO_FILTERS = [
    "name",
    "title",
    "description:",
    "stock_quantity",
    "price",
    "price_vat",
    "vat",
    "discount",
];

class AdminHeader extends React.Component{

    render(){
        return <React.Fragment>
                <AppBar position="fixed" color="primary" className="menu-customized">
                    <Toolbar>
                        <Grid  to='/' component={Link}><img className="toolbar" src={require("img/header.png")} alt="image"/></Grid>
                        <Grid container justify="flex-end">

                            <Grid>
                                <Button
                                    className="right"
                                    color="inherit"
                                    to='/dev'
                                    component={Link}>
                                    Psi
                                </Button>
                            </Grid>

                            <Grid>
                                <Button
                                    className="right"
                                    color="inherit"
                                    to='/'
                                    component={Link}>
                                    Kočky
                                </Button>
                            </Grid>

                            <Grid>
                                <Button
                                    className="right"
                                    color="inherit"
                                    to='/'
                                    component={Link}>
                                    Hlodavci
                                </Button>
                            </Grid>

                            <Grid>
                                <Button
                                    className="right"
                                    color="inherit"
                                    to='/'
                                    component={Link}>
                                    Akvaristika
                                </Button>
                            </Grid>

                            <Grid>
                                <Button
                                    className="right"
                                    color="inherit"
                                    to='/'
                                    component={Link}>
                                    Výprodej a akce
                                </Button>
                            </Grid>

                            <Grid>
                                <Button
                                    className="right"
                                    color="inherit"
                                    to='/'
                                    component={Link}>
                                    Blog
                                </Button>
                            </Grid>
                            <Grid><Button className="right" color="inherit">Support</Button></Grid>

                            <SearchInput className="mt-4 search-input form-control"
                                         caseSensitive={true}
                                         placeholder="Search.."
                                         onChange={this.searchUpdated}
                            />
                        </Grid>
                    </Toolbar>
                </AppBar>
            </React.Fragment>;
    }

}

export default AdminHeader;