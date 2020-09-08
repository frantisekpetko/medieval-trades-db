import Swal from 'sweetalert2'
import React from 'react';

class DatabaseAlert extends React.Component {

    alert =() => {
        Swal.fire({
            title: 'Might critical loss of data in Database!',
            type: "warning",
            text: "You gonna intend to obliterate data in database, are you sure?",
            showConfirmButton: true,
            showCancelButton: true,
        }).then((result) => {
            const value = result.dismiss;
            console.log("result", result.dismiss);
            if (value !== "cancel") {
                this.props.sendReq();
            }
            else {
                this.props.close();
            }
        })

    };

    render = () => {
        return <div>
            {this.alert()}
        </div>;
    }
}


export default DatabaseAlert;