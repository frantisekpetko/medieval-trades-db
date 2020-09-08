import {reactLocalStorage} from "reactjs-localstorage";


const AppStore = {
    canVisit: false,
    isAuthorized: false,
    isAdmin: false,
    isSuperAdmin: false,
    isCustomer: false,
    dummyPassword: "",
    shoppingBasketCount: 0,
    category: "",
};



export default AppStore;


