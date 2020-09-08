import React from 'react';
import Header from './Header/Header';

import Content from './Content/Content';
import Footer from './Footer/Footer';

import "./App.scss";
import API from '../../utils/API';
import SplashScreen from './SplashScreen/SplashScreen';
import Grid from '@material-ui/core/Grid';
import AppContext from 'context/AppContext';

class _App extends React.Component {

    constructor(props, context) {
        super(props, context);
        this.hasUnmounted = false;
        this.state = {
            products: [],
            numberInOrder: 0,

            rowsPerPage: [12, 24, 36, 48],
            offset: 0,
            numberOfRows: 12,
            page: 1,
            total: undefined,
        };

    }

    componentDidMount() {
        this.hasUnmounted = true;
        this.hasUnmounted && this.getProductsByLimit(this.state.numberOfRows);
    }



    componentWillUnmount() {
        this.hasUnmounted = false;
    }



    getProductsByLimit = async () => {
        try {
            console.log("requestPerform", `product/${this.state.numberOfRows}/paginate`);
            const res = await API.get(`product/${this.state.numberOfRows}/paginate`);
            console.log("Succesful response: \n", res);
            this.hasUnmounted && this.setState({products: res.data[0].collection[0]});
        }
        catch (e) {
            console.warn(`Fetch error occurred:\n ${e}`)
        }
    };

    updateProductsByLimit = async (numberOfProducts) => {
        try {
            const res = await API.get(`product/${this.state.numberOfRows}/paginate`);
            console.log("Succesful response: \n", res);
            this.hasUnmounted && this.setState({products: res.data[0].collection[0]});
        }
        catch (e) {
            console.warn(`Fetch error occurred:\n ${e}`)
        }
    };


    getProducts = async () => {
        try {
            const res = await API.get("product");
            console.log("Succesful response: \n", res);
            this.hasUnmounted && this.props.givePropToHighestComponent({products:  res.data[0].collection[0]});
            this.hasUnmounted && this.setState({products: res.data[0].collection[0]});
        }
        catch (e) {
            console.warn(`Fetch error occurred:\n ${e}`)
        }
    };


    render() {
        console.log("This props", this.props);
        const splashScreen = <SplashScreen/>;
        const page  = <React.Fragment>
            <Header
                shoppingBasketCount={this.props.shoppingBasketCount}
            />
            <Grid
                container
                direction="column"
                justify="center"
                alignItems="center"
            >
                <img className="mt-9 mb-2 img" src={"/app/img/title_image.png"}/>
            </Grid>
            <Content
                products={this.state.products.length > 0 ?  this.state.products : null}

                total={this.state.total}
                rowsPerPage={this.state.rowsPerPage}
                page={this.state.page}
                numberOfRows={this.state.numberOfRows}
                updateRows={this.updateRows}
                getProducts={this.getProductsByLimit}
            />
            <Footer/>
        </React.Fragment>;

        return (
            this.state.products.length > 1 ? page : splashScreen
        );
    }
}



class App extends React.Component {


    render(){
        return <AppContext.Consumer>
            {(context) => {
                const all = {
                    p: this.props,
                    context: context
                };
                return <_App {...all}/>
            }}
        </AppContext.Consumer>;
    }
}



export default App;