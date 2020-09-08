import React from 'react';
import API from '../../../utils/API';
import Header from '../Header/Header';
import Footer from '../Footer/Footer';
import CardContent from '@material-ui/core/CardContent';
import CardMedia from '@material-ui/core/CardMedia';
import Typography from '@material-ui/core/Typography';
import CardActions from '@material-ui/core/CardActions';
import Grid from '@material-ui/core/Grid';
import Button from '@material-ui/core/Button';
import Card from '@material-ui/core/Card';
import {withRouter} from 'react-router-dom';
import { createMuiTheme, MuiThemeProvider } from "@material-ui/core/styles";
import SplashScreen from "../SplashScreen/SplashScreen";
import ShoppingCartDialog from "../ShoppingCartDialog/ShoppingCartDialog";
import withAppContext from "../../../context/withAppContext";
import withAppContextAndRouter from "../../../context/withAppContextAndRouter";
import {compose} from 'recompose';
import AppContext from "../../../context/AppContext";


const theme = createMuiTheme();

class _Detail extends React.Component {


    state = {
        product: '',
        status: "LOADING",
        visibleErr: false,
        modal: false,
        numberInOrder: 0,
    };

    changeNumberProductsInOrder = (e) => {

        console.log("Method context", this.props.context);
        let order = e.target.value;
        this.setState({numberInOrder: order});
        console.log("hdbawbabawbd 2");

    };



    componentDidMount() {
        this.getProduct();
    }

    handleOpenDialog = (e) => {
        this.setState({modal: true});
    };


    handleCloseDialog = (e) => {
        this.setState({modal: false});
        this.props.context.onChangeShoppingBasket((this.state.numberInOrder));
        const count = this.state.numberInOrder;

        const product = this.state.product[0];
        console.log("III", this.props.context);
        this.props.context.setProductByOrder(product, count);
    };

    getProduct = async () => {
        console.log(this.props.match);

        try {
            const url = "product/" + this.props.match.params.id;
            const res = await API.get(url);
            console.log("Succesful response: \n", res);
            this.setState({product: res.data[0].individual[0], status: "OK"});
        }
        catch (e) {
            console.warn(`Fetch error occurred:\n ${e}`);

            if(e.status === 404){
                this.setState({
                    status: "NOT_FOUND"
                })
            }
        }
    };

    render() {
        console.log("Detail LOG", this.props);
        const product = this.state.product[0];
        console.log(product);
        const image = product !== undefined && product !== null ? product.image : null;
        console.log(image);
        const Loading = <SplashScreen/>;

        const Detail =
            <AppContext.Consumer>
                {(appContext) => {
                    console.log("Detail context", appContext);
                    return <React.Fragment>
                        <ShoppingCartDialog
                            fullscrean={true}
                            handleOpenDialog={this.handleOpenDialog}
                            handleCloseDialog={this.handleCloseDialog}
                            changeNumberProductsinOrder={this.changeNumberProductsInOrder}
                            modal={this.state.modal}
                            numberInOrder={this.state.numberInOrder}
                            changeNumberProductsInOrder={this.changeNumberProductsInOrder}
                            image={product !== undefined && ("/app/" + image[0]["img_path"] + image[0]["img_name"])}
                            productName={product !== undefined && (product.name)}
                        />
                        <Header
                            shoppingBasketCount={undefined}
                        />
                        {
                            product !== undefined &&
                            <Grid
                                container
                                direction="column"
                                justify="center"
                                alignItems="center"
                            >
                                <Card className="card mt-9 width-customize">
                                    <CardContent>
                                        <CardMedia
                                            className="img-detail"
                                            component="img"
                                            image={"/app/" + image[0]["img_path"] + image[0]["img_name"]}
                                            title={product.name}
                                        />
                                        {console.log("./app/" + image[0]["img_path"] + image[0]["img_name"])}
                                        <Typography className="bold" variant="headline" gutterBottom component="h2">
                                            {product.name}
                                        </Typography>
                                        <Typography component="p">
                                            <b>Popis</b><br/>
                                            {product.description}
                                        </Typography>

                                        <Typography component="p">
                                            <b>Dostupné množství skladem</b>
                                            <br/>
                                            <i>
                                                {product.stock_quantity} kusů skladem
                                            </i>
                                        </Typography>
                                        <Typography component="p">
                                            <b>Naše cena</b>
                                            <br/>
                                            <i>
                                                {product.price} Kč
                                            </i>
                                        </Typography>
                                    </CardContent>
                                    <CardActions>
                                        <Grid container direction="row" justify="flex-end" alignItems="flex-end">
                                            <Button color="secondary"
                                                    variant="contained"
                                                    size="medium"
                                                    className="mr-2"
                                                    onClick={this.handleOpenDialog}
                                            >
                                                Objednat
                                            </Button>
                                        </Grid>
                                    </CardActions>
                                </Card>
                            </Grid>
                        }
                        <Footer/>

                    </React.Fragment>
                }}
            </AppContext.Consumer>;

        return (product !== null ? Detail : Loading);
    }

}


export default withRouter(_Detail);