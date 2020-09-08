import React from 'react';

import Button from '@material-ui/core/Button';
import Dialog from '@material-ui/core/Dialog';
import MuiDialogTitle from '@material-ui/core/DialogTitle';
import DialogContent from '@material-ui/core/DialogContent';
import DialogActions from '@material-ui/core/DialogActions';
import IconButton from '@material-ui/core/IconButton';
import CloseIcon from '@material-ui/icons/Close';
import Typography from '@material-ui/core/Typography';
import AppBar from '@material-ui/core/AppBar';
import Tabs from '@material-ui/core/Tabs';
import Tab from '@material-ui/core/Tab';

import SwipeableViews from 'react-swipeable-views';
import Lowlight from 'react-lowlight';
import php from 'highlight.js/lib/languages/php';

Lowlight.registerLanguage('php', php);
import './default.scss';

import ajax from '../../utils/ajax';


const Btns = (props) => <DialogActions>
    <Button onClick={props.cancel} color="primary">
        Cancel
    </Button>
    {
        !(props.oneBtn)
            ? <Button onClick={props.comfortGenerate} color="primary">
                Generate with Model
            </Button>
            : <div>
            </div>
    }
    <Button onClick={props.customGenerate} color="primary">
        Generate
    </Button>
</DialogActions>;


function TabContainer({ children, dir }) {
    return (
        <Typography component="div" dir={dir} style={{ padding: 8 * 3 }}>
            {children}
        </Typography>
    );
}


const DialogTitle = props => {
    const { children, onClose } = props;
    return (
        <MuiDialogTitle disableTypography className="_root">
            <Typography variant="h6">{children}</Typography>
            {onClose ? (
                <IconButton aria-label="Close" className="closeButton" onClick={onClose}>
                    <CloseIcon />
                </IconButton>
            ) : null}
        </MuiDialogTitle>
    );
};


class Modal extends React.Component {


    constructor(props){
        super(props);
        this.state = {
            value: 0,
            tab1: "",
            tab2: "",
        }
    }

    componentDidMount() {
        this.selectDerivedStringDataByHigherComponent();
    }


    handleFinishGenerationOfComponent = (component, nextComponent) =>  {
        this.props.close();
        if(typeof nextComponent === 'undefined' || nextComponent === null){
            ajax.post(`/${component}/finish`, {name: this.props.subjectName})
                .then((res) => {
                    console.log(res);
                })
                .catch((err) => {
                    console.log(err)
                });
            console.log("single method");
        }
        else {

            const migrationFinish = () => {
                ajax.post(`/${component}/finish`, {name: this.props.subjectName})
                    .then((res) => {
                        console.log("Data", res.data);
                    })
                    .catch((err) => {
                        console.log(err)
                    });
            };


            const modelStart = () => {
                ajax.post(`/${nextComponent}`, {name: this.props.subjectName})
                    .then((res) => {
                        console.log("Data", res.data);
                    })
                    .catch((err) => {
                        console.log(err)
                    });
            };


            const modelFinish = () => {
                ajax.post(`/${nextComponent}/finish`, {name: this.props.subjectName, indexes: this.props.fourthData})
                    .then((res) => {
                        console.log("Data", res.data);
                    })
                    .catch((err) => {
                        console.log(err);
                    });

                    console.log("fourth data", this.props.fourthData);
            };

            new Promise(function(resolve, reject) {
                    resolve(migrationFinish());

            }).then(() => {
                    modelStart();
                //return res;
            }).then(() => {
                    modelFinish();

            }).catch((err) => {
                console.log(err);
            });

        }
    };

    handleCancelOperation = (component) => {
        this.props.close();
        ajax.post(`/${component}/cancel`, {})
            .then((res) => {
                console.log(res);
            })
            .catch((err) => {
                console.log(err)
            });
    };

    handleChange = (event, value) => {
        this.setState({ value });
    };

    handleChangeIndex = index => {
        this.setState({ value: index });
    };



    selectDerivedStringDataByHigherComponent = () => {
            switch (this.props.component) {
                case "route":
                    this.setState({tab1: "Routing", tab2: "Affiliated Rest Controller"});
                    break;
                case "migration":
                    this.setState({tab1:  "Entity Data Schema", tab2: "Entity Model", tab3: "Data maker"});
                    break;
            }
    };

    render() {

        const ucFirst = (string) =>
        {
            return string.charAt(0).toUpperCase() + string.slice(1);
        };

        return (
            <div>
                <Dialog
                    onClose={this.handleClose}
                    aria-labelledby="customized-dialog-title"
                    open={this.props.open}
                >
                    <div>
                    <AppBar position="static" color="default">
                        <Tabs
                            value={this.state.value}
                            onChange={this.handleChange}
                            indicatorColor="primary"
                            textColor="primary"
                            variant="fullWidth"
                        >
                            <Tab label={this.state.tab1}/>
                            <Tab label={this.state.tab2} />
                            {this.props.component !== "route" && <Tab label={this.state.tab3} />}
                        </Tabs>
                    </AppBar>
                    <SwipeableViews
                        axis={'x-reverse'}
                        index={this.state.value}
                        onChangeIndex={this.handleChangeIndex}
                    >
                        <TabContainer dir={'x-reverse'}>
                            <DialogTitle id="customized-dialog-title" onClose={this.handleClose}>
                                Preview of {
                                this.props.title === "Model"
                                    ? this.props.subjectName
                                    : (this.props.component === "route" ? this.props.subjectName .toLowerCase() + this.props.title : ucFirst(this.props.subjectName)  + this.props.title )
                            }
                                .php
                            </DialogTitle>
                            <DialogContent>
                                <Lowlight
                                    language="php"
                                    value={this.props.firstData}
                                />
                            </DialogContent>
                            <Btns
                                oneBtn={this.props.oneBtn}
                                customGenerate={() => this.handleFinishGenerationOfComponent(this.props.component, null)}
                                comfortGenerate={() => this.handleFinishGenerationOfComponent(this.props.component, this.props.nextComponent)}
                                cancel={() => this.handleCancelOperation(this.props.component, null)}
                            />
                        </TabContainer>
                        <TabContainer dir={'x-reverse'}>
                            <DialogTitle id="customized-dialog-title" onClose={this.handleClose}>
                                Preview of {
                                this.props.title === "Model"
                                    ? this.props.subjectName
                                    : (this.props.component === "route" ? `${ucFirst(this.props.subjectName)}Controller`  : ucFirst(this.props.subjectName)  )
                            }
                                .php
                            </DialogTitle>
                            <DialogContent>
                                <Lowlight
                                    language="php"
                                    value={this.props.secondData}
                                />
                            </DialogContent>
                            <Btns
                                oneBtn={this.props.oneBtn}
                                customGenerate={() => this.handleFinishGenerationOfComponent(this.props.component, null)}
                                comfortGenerate={() => this.handleFinishGenerationOfComponent(this.props.component, this.props.nextComponent)}
                                cancel={() => this.handleCancelOperation(this.props.component, null)}
                            />
                        </TabContainer>
                        {
                            this.props.thirdData ? <TabContainer dir={'x-reverse'}>
                                <DialogTitle id="customized-dialog-title" onClose={this.handleClose}>
                                    Preview of {
                                    this.props.title === "Model"
                                        ? this.props.subjectName
                                        : (this.props.component === "route" ? this.props.subjectName .toLowerCase() + this.props.title : `${ucFirst(this.props.subjectName)}Seeder` )
                                }
                                    .php
                                </DialogTitle>
                                <DialogContent>
                                    <Lowlight
                                        language="php"
                                        value={this.props.thirdData}
                                    />
                                </DialogContent>
                                <Btns
                                    oneBtn={this.props.oneBtn}
                                    customGenerate={() => this.handleFinishGenerationOfComponent(this.props.component, null)}
                                    comfortGenerate={() => this.handleFinishGenerationOfComponent(this.props.component, this.props.nextComponent)}
                                    cancel={() => this.handleCancelOperation(this.props.component, null)}
                                />
                            </TabContainer> :
                                <div>
                                </div>
                        }

                    </SwipeableViews>
                    </div>
                </Dialog>
            </div>
        );
    }
}

export default Modal;