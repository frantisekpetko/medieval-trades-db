import React from 'react';
import List from "@material-ui/core/List";
import ListItem from "@material-ui/core/ListItem";
import ListItemIcon from "@material-ui/core/ListItemIcon";
import Checkbox from "@material-ui/core/Checkbox";
import ListItemText from "@material-ui/core/ListItemText";

export default function ProductList(props){

    return <List>
        {props.order[0] !== undefined
            ? props.order[0].map( (order, index) => {

                const labelId = `checkbox-list-label-${index}`;
                console.log("ProductList props", props);
                return( <ListItem  key={index} role={undefined}
                                   dense button onClick={(index) => props.handleToggle(index)}>
                    <ListItemIcon>
                        <Checkbox
                            color={"primary"}
                            edge="start"
                            checked={true}
                            tabIndex={-1}
                            disableRipple
                            inputProps={{ 'aria-labelledby': labelId }}
                        />
                    </ListItemIcon>
                    <ListItemText inset id={labelId} >
                        {order.name + " #" + (index + 1)}
                    </ListItemText>
                </ListItem>)})
            : " "}

    </List>
}