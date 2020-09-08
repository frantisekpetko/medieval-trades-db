import React from 'react';
import API from 'utils/API';

import Grid from "@material-ui/core/Grid";
import Typography from '@material-ui/core/Typography';
import CreateProduct from './CreateProduct/CreateProduct';
import CreateImage from './CreateImage/CreateImage';
import CreateCategory from './CreateCategory/CreateCategory';
import Button from '@material-ui/core/Button';

class CreateInitData extends React.Component {

    state = {
        // product
        name: "",
        title: "",
        description: "",
        stock_quantity: 50,
        price: "",
        price_vat: 0,
        vat: 15,
        discount: 0,
        category: "",
        admin_id: 1,
        // image
        img_name: "",
        img_path: "img/products/",
        // category
        c_title: "",
        product_count: "",
        parent_id: "null"

    };

    handleChange = (event, name) => {
        this.setState({
            [name]: event.target.value,
        });
    };

    sendExtendedProduct = async () => {
        try {
            const data = {
                //product
                name: this.state.name,
                title: this.state.title,
                description: this.state.description,
                stock_quantity: this.state.stock_quantity,
                price: this.state.price,
                price_vat: this.state.price_vat,
                vat: this.state.vat,
                discount: this.state.discount,
                admin_id: this.state.admin_id,
                category: this.state.category,
                //image
                img_name: `${this.state.img_name}.jpg`,
                img_path: this.state.img_path,
            };

            const res = await API.post("product", data);
            console.log("Succesful response: \n", res);
        }
        catch (e) {
            console.warn(`Fetch error occurred:\n ${e}`)
        }
    };

    sendCategory = async () => {
        try {
            const data = {
                title: this.state.c_title,
                product_count: this.state.product_count,
                parent_id: this.state.parent_id,
            };

            const res = await API.post("category", data);
            console.log("Succesful response: \n", res);
        } catch (e) {
            console.warn(`Fetch error occurred:\n ${e}`)
        }
    };

    render() {
        return <React.Fragment>
        <Grid
            container
            direction="column"
            justify="center"
            alignItems="center"
        >
            <Typography className="bold" gutterBottom component="h1"  variant="headline" >
                Create product
            </Typography>
            <CreateProduct
                name={this.state.name}
                title={this.state.title}
                description={this.state.description}
                stockQuantity={this.state.stock_quantity}
                price={this.state.price}
                priceVat={this.state.price_vat}
                vat={this.state.vat}
                discount={this.state.discount}
                category={this.state.category}
                changeProduct={this.handleChange}
            />
            <CreateImage
                imageName={this.state.img_name}
                imagePath={this.state.img_path}
                changeImage={this.handleChange}
            />
            <Button
                variant="contained"
                size="small"
                color="secondary"
                onClick={this.sendExtendedProduct}
                className="mb-2"
            >
                Create
            </Button>

            <CreateCategory
                category_title={this.state.c_title}
                product_count={this.state.product_count}
                parent_id={this.state.parent_id}
                changeCategory={this.handleChange}
            />

            <Button
                variant="contained"
                size="small"
                color="secondary"
                onClick={this.sendCategory}>
                Create
            </Button>

        </Grid>
    </React.Fragment>
    }
}

export default CreateInitData;