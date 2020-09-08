'use strict';

const webpack = require('webpack');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const path = require('path');

module.exports = {
    mode: 'production',
    entry: [
        'babel-polyfill','./app/index.jsx',
    ],
    module: {
        rules: [
            {
                test: /\.(js|jsx|json)$/,
                exclude: /node_modules/,
                use: ['babel-loader'],
            },
            {
                test: /\.scss$/,
                use: [
                    {
                        loader: "style-loader" // creates style nodes from JS strings
                    },
                    {
                        loader: "css-loader" // translates CSS into CommonJS
                    },
                    {
                        loader: "sass-loader" // compiles Sass to CSS
                    }
                ]
            },
            {
                test: /\.(png|svg|jpg|gif|ico|ttf|woff|eot)$/,
                use: [
                    {
                        loader: 'url-loader?limit=25000'
                        //8192
                    }
                ]
            },
            { test: /\.woff2(\?v=[0-9]\.[0-9]\.[0-9])?$/i, loader: 'url-loader', options: { limit: 10000, mimetype: 'application/font-woff2' } },
            { test: /\.woff(\?v=[0-9]\.[0-9]\.[0-9])?$/i, loader: 'url-loader', options: { limit: 10000, mimetype: 'application/font-woff' } },
            { test: /\.(ttf|eot|svg|otf)(\?v=[0-9]\.[0-9]\.[0-9])?$/i, loader: 'file-loader' }
    ],
  },
  resolve: {
    extensions: ['*', '.js', '.jsx', '.config.js', '.web.js', ],
    modules: [
        path.resolve(__dirname, "app"), path.resolve(__dirname, "node_modules")
    ]
  },
  output: {
    path: __dirname + '/public/',
    publicPath: '/',
    filename: 'bundle.js'
  },
  node: {
        console: true,
        fs: 'empty',
        net: 'empty',
        tls: 'empty'
  },
  devtool: "source-map",
  plugins: [
    new webpack.HotModuleReplacementPlugin(),
    new webpack.DefinePlugin({
          'process.env':{
              'PUBLIC_URL': JSON.stringify('http://localhost:8000'),
              'DEPLOY_URL': JSON.stringify('https://sweeetheart.herokuapp.com')
              /*'APP_ID': '698088170574676',
              'APP_SECRET': '48d582d34339686841a66350b041b0aa',
              'ACCESS_TOKEN':'957519524433404|GzGDbpHPgNN4kaKR9_0TVcvkH3s'*/
               /*NODE_ENV: JSON.stringify('development')*/
          }
    }),
  ],
  optimization: {
        minimizer: [new UglifyJsPlugin({
            sourceMap: true
        }),],
  },
  devServer: {
    //host: "project.test",
    contentBase: '.',
    hot: true,
    disableHostCheck: true,
    historyApiFallback: true,

    /*https: {
          key: fs.readFileSync(__dirname +  '/conf/key.pem'),
          cert: fs.readFileSync(__dirname +'/conf/cert.pem')
    },*/
    port: 3000
  },

};


