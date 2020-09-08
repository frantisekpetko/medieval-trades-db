import React from 'react';
import Typography from '@material-ui/core/Typography';
import CardActions from '@material-ui/core/CardActions';
import CardContent from '@material-ui/core/CardContent';
import Button from '@material-ui/core/Button';
import Grid from '@material-ui/core/Grid';
import { Link } from 'react-router-dom';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faChevronRight } from '@fortawesome/free-solid-svg-icons';
import { library } from '@fortawesome/fontawesome-svg-core';
import { fab } from '@fortawesome/free-brands-svg-icons';
import CardMedia from '@material-ui/core/CardMedia';
//Material UI Dependency for touch / tap / click events

import {Card} from 'material-ui/Card';
import Divider from 'material-ui/Divider';
import {Table, TableBody, TableHeader, TableHeaderColumn, TableRow, TableRowColumn} from 'material-ui/Table';
//Import the pagination component
import ReactPaginate from 'react-paginate';
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider';
import SearchInput, {createFilter} from 'react-search-input';
import withErrorBoundary from "../../../ErrorBoundary/withErrorBoundary";

//Demo API to simulate async actions
const KEYS_TO_FILTERS = [
    "name",
    "title",
    "price",
    "category.title"
];


class _Content extends React.Component{
    hasUnmounted = false;

    state = {
        searchTerm: '',
        searchTermCategory: '',
        shoppingBasketCount: 0,
        firstChange: false,
    };


    changeSearchByChangedCategory = () => {
        console.log("changeSearchByChangedCategory change");

        this.setState({
            searchTerm: this.props.context.category,
            searchTermCategory: this.props.context.category}
        );
    };

    componentDidUpdate(prevProps) {
        // Typical usage (don't forget to compare props):
        if (this.state.searchTerm !== this.state.searchTermCategory &&  this.state.firstChange === false) {
            //this.hasUnmounted && this.changeSearchByChangedCategory();
        }
    }

    searchUpdated = (term) => {
        /*this.props.context.category !== ""
            ? this.setState({searchTerm: this.props.context.category})
            : this.setState({searchTerm: term});*/
        this.hasUnmounted && this.setState({searchTerm: term});
    };

    componentDidMount() {
        this.hasUnmounted = true;
        this.changeSearchByChangedCategory();
    }



    componentWillUnmount() {
        this.hasUnmounted = false;

    }


    render(){
        console.log("PROPS Content ...", this.props);
        const filteredProducts = this.props.p.products !== undefined && this.props.p.products != null ? this.props.p.products.filter(createFilter(this.state.searchTerm, KEYS_TO_FILTERS )): null;

        const Loading = <React.Fragment><h3>Loading ...</h3></React.Fragment>;
        const Content =
            <MuiThemeProvider>
                <React.Fragment>
                    <Grid
                        container
                        direction="column"
                        justify="center"
                        alignItems="center"
                    >
                        <SearchInput
                            className="mt-4 search-input form-control"
                            caseSensitive={true}
                            placeholder="Hledej.."
                            onChange={this.searchUpdated}
                            value={this.state.searchTerm}
                        />
                    </Grid>
                    <Grid container spacing={16} style={{ paddingLeft: 200, paddingTop: 25, paddingRight: 200 }}>
                        {
                            filteredProducts !== null && filteredProducts.map((product, index) => {
                                const {image} = product;

                                const url = "./app/" + image[0]["img_path"] + image[0]["img_name"];
                                console.log(url);
                                return (
                                    <Grid key={index} item xs={12} sm={6} lg={4} xl={3} className="pb-3-5">
                                        <Card  key={product.id} className="card title-card">
                                            <CardContent>
                                                <CardMedia
                                                    component="img"
                                                    height="200"
                                                    image={url}
                                                    title="Contemplative Reptile"
                                                />
                                                <Typography className="bold" variant="headline" gutterBottom component="h2">
                                                    {product.name}
                                                </Typography>
                                                <Typography component="p">
                                                    Price.
                                                    <br />
                                                    <i>
                                                        {product.price} Kč
                                                    </i>
                                                </Typography>
                                            </CardContent>
                                            <CardActions>
                                                <Grid container direction="row" justify="flex-end" alignItems="flex-end">
                                                    <Button  color="secondary"
                                                             to={`/product/${product.id}/detail`}
                                                             component={Link}
                                                             variant="contained"
                                                             size="medium"
                                                             className="mr-2"

                                                    >
                                                        Detail
                                                    </Button>
                                                </Grid>
                                            </CardActions>
                                        </Card>
                                    </Grid>
                                )})}
                    </Grid>
                    <Grid
                        container
                        direction="column"
                        justify="center"
                        alignItems="center"
                    >
                        <ReactPaginate
                            previousLabel={"<"}
                            nextLabel={">"}
                            breakLabel={<button className={"react-paginate"}>...</button>}
                            breakClassName={"not-break-me"}
                            pageCount={4}
                            marginPagesDisplayed={2}
                            pageRangeDisplayed={6}
                            onPageChange={this.props.p.getProducts}
                            containerClassName={'react-paginate'}
                            subContainerClassName={'pages pagination'}
                            activeClassName={'active'}
                        />
                    </Grid>
                </React.Fragment>
            </MuiThemeProvider>;
        return (
            filteredProducts !== undefined && filteredProducts  !== null ? Content : Loading
        )
    }
}

export default withErrorBoundary(_Content);