import React from 'react';
import './Toast.scss';
import Typography from '@material-ui/core/Typography';
import withAnimationContext from '../../../context/withAnimationContext';

class Toast extends React.Component {

    constructor (props) {
        super(props);
        this.state = {
            visible: false,
            timeout: null,
        }
    }

    closeToast = () => {
        const close = () => {
            this.setState({timeout: null});
        };
        const visible = {visible: false };
        this.props.context.givePropToHighestComponent(visible);
        close();
    };

    showToast = () => {
        const visible = {visible: true} ;
        const invisible = {visible: false };


        const displayToast = () => this.setState(
            {
                timeout: () => {
                    setTimeout(() =>
                            this.props.context.givePropToHighestComponent(visible)
                        ,  2000)}
            }, backToRegularRunning);

        const backToRegularRunning = () => {
            this.props.context.givePropToHighestComponent(invisible)
        };

       displayToast();
    };



    render () {
        console.log("TOAST", this.props.context.visible);

        let classes = `toast ${this.props.context.level} `;
        classes += this.props.context.visible ? 'visible' : '';
        console.log("Prop visible: ", this.props.context.visible);
        return (
            <div className={classes}>
                <Typography className="toast-text" component="p">
                    { this.props.context.message } <span style={{fontSize: '1rem'}}>&#9989;</span>
                    <span className="toast-cancel" onClick={this.closeToast}>&#10006;</span>
                </Typography>
            </div>
        )
    }

    getIcon () {
        switch (this.props.level) {
            case 'warning': return 'http://svgshare.com/i/19x.svg';
            case 'danger': return 'http://svgshare.com/i/19E.svg';
            case 'success': return <span style={{fontSize: '1.5rem'}}>&#10006;</span>;
        }
    }

    componentWillReceiveProps (nextProps) {
        // if (this.props.visible !== nextProps.visible) {
        //     /*this.setState({
        //         visible: nextProps.visible;
        //     })*/
        //     const visible = {visible: nextProps.visible};
        //
        //     this.props.givePropToHighestComponent(visible);
        // }
    }
}

export default withAnimationContext(Toast);