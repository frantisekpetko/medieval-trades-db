import React from 'react';

const BurgerMenuIcon = (props) => (

    <div onClick={props.clickable}
         className={
             props.changeIcon ? ( props.innerMenu ?  "clickable change" : "clickable unvisible menu-icon" ) : "clickable menu-icon"
         }
         style={props.bottom ? { marginTop: "60%" }: null}
    >
        <div className="piece1">{" "}</div>
        <div className="piece2">{" "}</div>
        <div className="piece3">{" "}</div>
        <div className="piece4">{" "}</div>
    </div>

);

export default BurgerMenuIcon;