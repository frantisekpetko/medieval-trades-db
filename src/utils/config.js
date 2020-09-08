
import {registerObserver} from 'react-perf-devtool';

const options = {
    shouldLog: true,
    port: 3000
};
const callback = (measures) => {
    console.log(measures)
};
const isDev = process.env.NODE_ENV === 'development';
const observer = registerObserver(options, callback);


const config = () => ({
        options: options,
        isDev: isDev,
        observer: observer
});


export {config};