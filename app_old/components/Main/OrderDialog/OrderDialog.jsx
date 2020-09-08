import React from 'react';
import ProductList from "./ProductList";
import green from '@material-ui/core/colors/green';
import FormControlLabel from '@material-ui/core/FormControlLabel';
import Checkbox from '@material-ui/core/Checkbox';
import TextField from '@material-ui/core/TextField';
import Field from '@material-ui/core/';
import Button from '@material-ui/core/Button';
import Dialog from '@material-ui/core/Dialog';
import DialogActions from '@material-ui/core/DialogActions';
import DialogContent from '@material-ui/core/DialogContent';
import DialogTitle from '@material-ui/core/DialogTitle';
import Typography from '@material-ui/core/Typography';
import Grid from '@material-ui/core/Grid';
import Avatar from '@material-ui/core/Avatar';
import AppContext from "../../../context/AppContext";
import API from 'utils/API';

class _OrderDialog extends React.Component {


    state = {
        name: "",
        surname: "",
        email: "",
        telephone: "",
        postalCode: "",
        city: "",
        address: "",
        checked: [0],
        totalPrice: 0,
        order: []
    };

    componentDidMount(){
        const product = [ this.props.context.getProductByOrder()];
        const order = [product[0].product];

        this.getTotalPrice(order);

    }

    sendOrder = async () => {


        const {name, surname, email, telephone, postalCode, city, address, totalPrice, order} = this.state;

        const data = {
            name: name,
            surname: surname,
            email: email,
            telephone: telephone,
            postalCode: postalCode,
            city: city,
            address: address,
            totalPrice: totalPrice,
            products: order
        };

        try {
            const res = API.post("order", data);
            this.props.p.handleCloseOrder();
            this.props.context.deleteProductByOrder();
            localStorage.setItem("canVisit", true);
        }
        catch (e) {
            console.warn(`Fetch error occurred:\n ${e}`);
        }


    };

    getTotalPrice = (order) => {
        let length = order.length;

        this.setState({order: order});
        function getSum(total, num) {
            return total + Math.round(num);
        }

        let totalPriceArr = [];

        order[0] !== undefined ? order[0].map((o, index) => {
            totalPriceArr.push(parseInt(o.price));
            console.log(parseInt(o.price));
            if ((length -1) === index){
                return totalPriceArr;
            }
        }) : null;

        console.log(totalPriceArr);

        let totalPrice = totalPriceArr.length <=1 ? totalPriceArr.reduce(getSum, 0) : null;

        console.log("total", totalPrice);
        this.setState({totalPrice: totalPrice});
    };


    handleToggle = (value) => {
        const currentIndex = this.state.checked.indexOf(value);
        const newChecked = [...checked];

        if (currentIndex === -1) {
            newChecked.push(value);
        } else {
            newChecked.splice(currentIndex, 1);
        }

        this.setState({checked: newChecked});
    };

    handleChange = (event, name) => {
        this.setState({
            [name]: event.target.value,
        });
    };

    handleCloseOrder = () => {
        this.setState({orderModal: false});
    };

    render(){
        const product =  [ this.props.context.getProductByOrder()];
        const order = [product[0].product];

        console.log("OrderDialog", order );

        /*
        const {
            orderModal,
            handleCloseOrder
        } = context;
        */
        return <React.Fragment>
            <Dialog
                fullScreen={true}
                open={this.props.p.orderModal}
                onClose={this.props.p.handleCloseOrder }
                aria-labelledby="responsive-dialog-title"
            >
                <DialogTitle id="responsive-dialog-title"><b>{"Nákup"}</b></DialogTitle>
                <DialogContent>
                    <React.Fragment>
                        <Grid
                            container
                            direction="column"
                            justify="center"
                            alignItems="center"
                        >

                            <TextField
                                id="filled-name"
                                label={"jméno"}
                                type="text"
                                value={this.state.name}
                                onChange={(e)=> this.handleChange(e, "name")}
                                margin="normal"
                                variant="filled"
                                className="mb-2"
                            />

                            <TextField
                                id="filled-name"
                                label={"příjmeni"}
                                type="text"
                                value={this.state.surname}
                                onChange={(e)=> this.handleChange(e, "surname")}
                                margin="normal"
                                variant="filled"
                                className="mb-2"
                            />


                            <TextField
                                id="filled-name"
                                label={"email"}
                                type="text"
                                value={this.state.email}
                                onChange={(e)=> this.handleChange(e, "email")}
                                margin="normal"
                                variant="filled"
                                className="mb-2"
                            />

                            <TextField
                                id="filled-name"
                                label={"telefon"}
                                type="text"
                                value={this.state.telephone}
                                onChange={(e)=> this.handleChange(e, "telephone")}
                                margin="normal"
                                variant="filled"
                                className="mb-2"
                            />

                            <TextField
                                id="filled-name"
                                label={"adresa"}
                                type="text"
                                value={this.state.address}
                                onChange={(e)=> this.handleChange(e, "address")}
                                margin="normal"
                                variant="filled"
                                className="mb-2"
                            />

                            <TextField
                                id="filled-name"
                                label={"město"}
                                type="text"
                                value={this.state.city}
                                onChange={(e)=> this.handleChange(e, "city")}
                                margin="normal"
                                variant="filled"
                                className="mb-2"
                            />

                            <TextField
                                id="filled-name"
                                label={"PSČ"}
                                type="text"
                                value={this.state.postalCode}
                                onChange={(e)=> this.handleChange(e, "postalCode")}
                                margin="normal"
                                variant="filled"
                                className="mb-2"
                            />


                            <ProductList
                                checked={ this.state.checked }
                                order={order}
                                handleToogle={(index) => this.handleToggle(index)}
                            />



                            <Grid>
                                <FormControlLabel
                                    control={
                                        <Checkbox checked={true} value="checkedA" />
                                    }
                                    label="Osobní odběr"
                                />
                            </Grid>


                            <Grid>
                                <FormControlLabel
                                    control={
                                        <Checkbox checked={true} value="checkedA" />
                                    }
                                    label="Platba přes bankovní převod"
                                />
                            </Grid>


                            <Typography  component="p">
                                Cena celkem {this.state.totalPrice} kč
                            </Typography>

                            <Typography className="footer-text right-text" component="p">
                                Odesláním objednávky souhlasíte s obchodními podmínkami
                            </Typography>
                        </Grid>
                    </React.Fragment>
                </DialogContent>
                <DialogActions>

                    <Button onClick={this.props.p.handleCloseOrder } color="primary">
                        Pokračovat v nákupu
                    </Button>
                    <Button onClick={() => this.sendOrder() } color="primary" autoFocus>
                        Dokončit objednávku
                    </Button>
                </DialogActions>
            </Dialog>
        </React.Fragment>;
    }
}



class OrderDialog extends React.Component {


    render(){

        return <AppContext.Consumer>
            {(context) => {
                const all = {
                    p: this.props,
                    context: context
                };
                return <_OrderDialog {...all}/>
            }}
        </AppContext.Consumer>;
    }
}


export default OrderDialog;