import React, {Component} from 'react';

import HeadHtml from "../../HeadHtml";

import TextField from '@material-ui/core/TextField';
import Grid from '@material-ui/core/Grid';
import Typography from '@material-ui/core/Typography';
import FormControlLabel from '@material-ui/core/FormControlLabel';
import AddIcon from '@material-ui/icons/Add';
import RemoveIcon from '@material-ui/icons/Remove';
import Tooltip from '@material-ui/core/Tooltip';
import Fab from '@material-ui/core/Fab';
import MenuItem from '@material-ui/core/MenuItem';
import FormControl from '@material-ui/core/FormControl';
import Select from '@material-ui/core/Select';
import Checkbox from '@material-ui/core/Checkbox';

import Menu from '../components/Menu';
import Footer from '../components/Footer';
import Button from '@material-ui/core/Button';

import ajax from '../../utils/ajax';
import Modal from "../components/Modal";

import SweetAlert from 'sweetalert2-react';
import Spinner from '../components/Spinner';

class EntityGen extends Component {

    state = {
        name: '',
        open: false,
        dataSchemaTxt: '',
        entityModelTxt: '',
        seederClassTxt: '',
        column: [{
            openSelection: false,
            nameOfColumn: "",
            datatype: "varchar",
            notNull: true,
            unique: false,
            index: false,
        }],
        relationship: "none",
        relationshipOpen: false,
        attachedTable: "",
        show: false,
    };

    handleSendData = () => {
        if(this.state.name !== ""){
        ajax.post('/migration',
            { name: this.state.name, count: this.state.column.length, columns: this.state.column})
            .then((res) => {
                console.log("Callback data", res.data.modelPreview);

                let result =  res.data.preview.split('{')[1];
                let entityModel=  `${res.data.modelPreview.substring(0, res.data.modelPreview.length - 1)}${result.substr(1)}` ;
                entityModel = entityModel.substring(1);

                entityModel = deleteLines(entityModel, 9);
                console.log("uadwhgywadgwda", result);

                containLineBreaks(entityModel);
                function containLineBreaks(stringContainingNewLines){
                    stringContainingNewLines = stringContainingNewLines.replace(/(\r\n|\n|\r)/gm, "<br/>");
                    console.log("BR", stringContainingNewLines);
                }
                entityModel.replaceAt(9, <br/>);
                this.setState({
                    dataSchemaTxt: res.data.preview,
                    entityModelTxt: entityModel,
                    seederClassTxt: res.data.seeder
                });


            })
            .catch((err) => {
                console.log(err)
            });

        const deleteLines = (string, n = 1)=>{
            return string.replace(new RegExp(`(?:.*?/(\\r\\n|\\n|\\r)/gm){${n-1}}(?:.*?/(\\r\\n|\\n|\\r)/gm)`), '');
        };

        this.handleClickOpen();
        }
        else {
            this.setState({show: true});
        }


    };


    handleChangeAttachedTable = (event) => {
        this.setState({attachedTable: event.target.value});
    };


    handleDropSelection = (column) => {

        let columnObj = this.state.column;

        columnObj.splice(column, 1);


        console.log("report", columnObj);

        this.setState({
            columnObj: [...columnObj],
        });

    };


    handleSelectionIncrement = () => {

        const oldData = this.state.column;

        let actualColumn =  this.state.column.length;
        console.log(this.state.column.length);

        this.setState({ column:
                [...oldData,
                 {openSelection: false, nameOfColumn: "", datatype: "varchar", notNull: true, unique: false, index: false}]
        });
        console.log("increment", this.state.column);

    };

    handleSelectionClose = (column) => {

        let columnObj = this.state.column;
        columnObj[column].openSelection = false;

        this.setState({ openSelection: [...columnObj] });
    };

    handleSelectionOpen = (column) => {
        let columnObj = this.state.column;
        columnObj[column].openSelection = true;

        this.setState({ openSelection: [...columnObj] });
    };


    handleClickOpen = () => {
        this.setState({
            open: true,
        });
    };


    handleClose = () => {
        this.setState({ open: false });
    };


    handleChange = ( name, column ) => event =>  {

        
        if (name === "relationship" && column === null){
            this.setState({
                relationship: event.target.value,
            });
        }
        
        if(typeof column === 'undefined' || column === null){

                this.setState({
                    [name]: event.target.value,
                });

        }
        else {

            if(name === "nameOfColumn" || name === "notNull" || name === "unique" || name === "App.jsx") {
                if(name === "nameOfColumn") {
                    let columnObj = this.state.column;
                    console.log("columnObj", columnObj);
                    columnObj[column][name]= event.target.value;
                    this.setState({
                        column: [...columnObj],
                    });
                }
                else {
                    let columnObj = this.state.column;
                    console.log("columnObj", columnObj);
                    columnObj[column][name]= !columnObj[column][name];
                    this.setState({
                        column: [...columnObj],
                    });
                }
            }
            else {

                let columnObj = this.state.column;
                console.log("datatypes !!!!!", columnObj, column, event.target.value);

                columnObj[column].datatype =  event.target.value;

                this.setState({
                    [name]: columnObj,
                });
            }

        }

    };


    render() {
        console.log("column report",this.state.open, this.state.open, this.state.seederClassTxt.length);

        return <div>
            <HeadHtml pageTitle={"Entity Generator"}/>

            <SweetAlert
                show={this.state.show}
                title="Empty user input"
                text="Please type suitable input."
                onConfirm={() => this.setState({ show: false })}
            />
            <div>
                <Menu />
                <Grid
                    className="mt-7"
                    container
                    direction="column"
                    justify="center"
                    alignItems="center"
                >
                    <Typography className="bold" gutterBottom component="h4"  variant="h4" >
                        Entity Generator
                    </Typography>
                    <Typography component="p">
                        <b className="text-align-for-migration">Example of text.</b><br/>
                        <i>
                            This generator allows generate schema of data in given table as entity in database,
                            or generate Active-Record class having CRUD database to current entity with generated data schema.
                        </i>
                    </Typography>
                    <TextField
                        label="Entity Name"
                        value={this.state.name}
                        onChange={this.handleChange('name')}
                        margin="normal"
                        variant="filled"
                    />

                    { this.state.column.map((column, index) => (

                        <Grid
                            container
                            direction="row"
                            justify="center"
                            alignItems="center"
                            key={index}
                        >
                            <TextField
                                label={"Column " + (index + 1)}
                                value={this.state.column[index].nameOfColumn}
                                onChange={ this.handleChange('nameOfColumn', index)}
                                margin="normal"
                                variant="filled"
                                className="ml-1"
                            />

                            <FormControl>

                                <Select
                                    open={this.state.column[index].openSelection}
                                    onClose={()=> this.handleSelectionClose(index)}
                                    onOpen={()=> this.handleSelectionOpen(index)}
                                    value={ this.state.column[index].datatype }
                                    onChange={ this.handleChange('datatype', index)}
                                    inputProps={{
                                        name: 'datatype',
                                        id: 'demo-controlled-open-select',
                                    }}
                                    className="ml-1"
                                >
                                    <MenuItem value="varchar">String</MenuItem>
                                    <MenuItem value="text">Text</MenuItem>
                                    <MenuItem value="integer">Integer</MenuItem>
                                    <MenuItem value="blob">Blob</MenuItem>
                                    <MenuItem value="real">Double</MenuItem>
                                    <MenuItem value="boolean">Boolean</MenuItem>
                                    <MenuItem value="date">Date</MenuItem>
                                    <MenuItem value="datetime">Datetime</MenuItem>
                                </Select>
                            </FormControl>

                            <FormControlLabel
                                control={
                                    <Checkbox
                                        color="default"

                                        checked={this.state.column[index].notNull}
                                        onChange={this.handleChange('notNull', index)}

                                    />
                                }
                                label="Not Null"
                                className="ml-1"
                            />
                            <FormControlLabel
                                control={
                                    <Checkbox
                                        color="default"
                                        checked={this.state.column[index].unique}
                                        onChange={this.handleChange('unique', index)}

                                    />
                                }
                                label="Unique"
                                className="ml-1"
                            />
                            <FormControlLabel
                                control={
                                    <Checkbox
                                        color="default"
                                        checked={this.state.column[index].CMS}
                                        onChange={this.handleChange('App.jsx', index)}

                                    />
                                }
                                label="Index"
                                className="ml-1"
                            />

                            <Tooltip onClick={() => this.handleDropSelection(index )} title="Remove" aria-label="Remove" className="ml-1">
                                <Fab color="primary" className="fab">
                                    <RemoveIcon />
                                </Fab>
                            </Tooltip>
                        </Grid>
                    ))}

                    <TextField
                        id="relationship-table"
                        label="Attached table"
                        value={this.state.attachedTable}
                        onChange={  this.handleChangeAttachedTable}
                        margin="normal"
                        variant="filled"
                        style={ this.state.relationship === "none" ? {display: "none"} : {display: "inline"} }
                    />
                    <Tooltip className="mb-1" title="Add" aria-label="Add" onClick={this.handleSelectionIncrement}>
                        <Fab color="primary" className="fab">
                            <AddIcon />
                        </Fab>
                    </Tooltip>

                    <Button
                        variant="contained"
                        size="small"
                        color="default"
                        onClick={this.handleSendData}>
                        Preview
                    </Button>
                    {!this.state.open || this.state.seederClassTxt.length > 0 ?
                        <Modal nextComponent="model"
                               component="migration"
                               title="Migration"
                               subjectName={this.state.name}
                               open={this.state.open}
                               close={this.handleClose}
                               firstData={this.state.dataSchemaTxt}
                               secondData={this.state.entityModelTxt}
                               thirdData={this.state.seederClassTxt}
                               fourthData={this.state.column}
                        />
                        : <Spinner/>
                    }

                </Grid>
                <Footer/>
            </div>
        </div>
    }
}

export default EntityGen;