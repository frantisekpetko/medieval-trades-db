import axios from 'axios';

const ajax = axios.create({
    baseURL: process.env.NODE_ENV === 'development' ? 'http://localhost:8000/api' : null,
    withCredentials: true,
    crossDomain: true,
});

console.log('DEV MODE', process.env.NODE_ENV);

export default ajax;
