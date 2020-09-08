import axios from 'axios';

const API = axios.create({
    //baseURL: process.env.NODE_ENV === 'development' ? 'http://localhost:8000/api/' : 'https://sweeetheart.herokuapp.com/api/',
    baseURL: location.protocol !=='https:' ? 'http://sweeetheart.herokuapp.com/api/' : "https://sweeetheart.herokuapp.com/api/",
    withCredentials: true, // https://developer.mozilla.org/en-US/docs/Web/API/XMLHttpRequest/withCredentials
    crossDomain: true
});


console.log('DEV MODE', process.env.NODE_ENV);

export default API;
