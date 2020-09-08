import React from 'react';
import AppBar from '@material-ui/core/AppBar';
import Toolbar from '@material-ui/core/Toolbar';
import Grid from '@material-ui/core/Grid';
import Button from '@material-ui/core/Button';
import {Link} from "react-router-dom";
import SearchInput, {createFilter} from 'react-search-input';
import Badge from "@material-ui/core/Badge";
import withAppContext from 'context/withAppContext';
import red from '@material-ui/core/colors/red';
import Icon from '@material-ui/core/Icon';
import AppContext from "../../../context/AppContext";
import OrderModal from "../OrderDialog/OrderDialog";


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

class _Header extends React.Component{

    state = {
        shoppingBasketCount: 0,
        category: "",
        orderModal: false
    };

    handleCloseOrder = () => {
        this.setState({orderModal: false});


    };

    startOrder = () => {

        this.setState({orderModal: true});

    };

    handleMoveToCategory = (category) => {

        this.props.context.onChangeCategory(category);
        this.setState({category: category})

    };

    render(){

        console.log("Header context", this.props.context);

        const count =
            this.props.context.shoppingBasketCount !== undefined
                ? (this.props.context.shoppingBasketCount + " ks") :  0;
        console.log("Wanted props", this.props);
        return <React.Fragment>
                <OrderModal
                    orderModal={this.state.orderModal}
                    handleCloseOrder={this.handleCloseOrder}
                />
                <AppBar position="fixed" color="secondary" className="menu-customized">
                    <Toolbar>
                        <Grid  to='/' component={Link}><img className="toolbar" src={require("img/header.png")} alt="image"/></Grid>
                        <Grid container justify="flex-end">

                            <Grid>
                                <Button
                                    className="right"
                                    variant={this.state.category === "Psi" ? "contained" : "text"}
                                    color={this.state.category === "Psi" ? "primary" : "inherit"}
                                    onClick={() => this.handleMoveToCategory("Psi")}
                                >
                                    Psi
                                </Button>
                            </Grid>

                            <Grid>
                                <Button
                                    className="right"
                                    variant={this.state.category === "Kočky" ? "contained" : "text"}
                                    color={this.state.category === "Kočky" ? "primary" : "inherit"}
                                    onClick={() => this.handleMoveToCategory("Kočky")}
                                >
                                    Kočky
                                </Button>
                            </Grid>

                            <Grid>
                                <Button
                                    className="right"
                                    variant={this.state.category === "Hlodavci" ? "contained" : "text"}
                                    color={this.state.category === "Hlodavci" ? "primary" : "inherit"}
                                    onClick={() => this.handleMoveToCategory("Hlodavci")}
                                >
                                    Hlodavci
                                </Button>
                            </Grid>

                            <Grid>
                                <Button
                                    className="right"
                                    variant={this.state.category === "Akvaristika" ? "contained" : "text"}
                                    color={this.state.category === "Akvaristika" ? "primary" : "inherit"}
                                    onClick={() => this.handleMoveToCategory("Akvaristika")}
                                >
                                    Akvaristika
                                </Button>
                            </Grid>

                            <Grid>
                                <Button
                                    className="right"
                                    variant={this.state.category === "discount" ? "contained" : "text"}
                                    color={this.state.category === "discount" ? "primary" : "inherit"}
                                    onClick={() => this.handleMoveToCategory("discount")}
                                >
                                    Výprodej a akce
                                </Button>
                            </Grid>
                        </Grid>
                    </Toolbar>
                </AppBar>

            <Grid
                container
                justify="flex-start"
                alignItems="flex-start"
                spacing={0}
                direction="column"
                style={{position: "fixed", top: "53.75%",left: 0, width: "20%"}}
            >
                <Badge badgeContent={ count }
                   color={"secondary"}>
                    <Grid>
                        <Button
                            size="large"
                            variant={"outlined"}
                            color="secondary"
                            className="badge-customize"
                            onClick={this.startOrder}
                        >
                            Košík
                        </Button>
                    </Grid>
                </Badge>
            </Grid>
            </React.Fragment>;
    }
}


class Header extends React.Component {


    render(){

        return <AppContext.Consumer>
            {(context) => {
                const all = {
                    p: this.props,
                    context: context
                };
                return <_Header {...all}/>
            }}
        </AppContext.Consumer>;
    }
}



export default Header;