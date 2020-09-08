import React from 'react';
import {withRouter} from 'react-router-dom';
const AppContext = React.createContext({
    isAuthorized: false,
    isAdmin: false,
    isSuperAdmin: false,
    isCustomer: false,
    shoppingBasketCount: 0,
    products: [],
});

export default withRouter(AppContext);