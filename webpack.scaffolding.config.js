'use strict';

const webpack = require('webpack');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const path = require('path');


module.exports = {
    entry: [
        './src/index.jsx',
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
                test: /\.(png|svg|jpg|gif|ico)$/,
                use: [
                    {
                        loader: 'url-loader?limit=25000'
                        //8192
                    }
                ]
            }
    ],
  },
  resolve: {
    alias: { 'dom-helpers': 'dom-helpers5' },
    extensions: ['*', '.js', '.jsx', '.config.js', '.web.js', ],
    modules: [
          path.resolve(__dirname, "src"), path.resolve(__dirname, "node_modules")
    ]
  },
  output: {
    path: __dirname + '/scaffolding',
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
              'PUBLIC_URL': JSON.stringify('http://localhost:7000'),
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
    contentBase: './scaffolding',
    hot: true,
    disableHostCheck: true,
    historyApiFallback: true,

    /*https: {
          key: fs.readFileSync(__dirname +  '/conf/key.pem'),
          cert: fs.readFileSync(__dirname +'/conf/cert.pem')
    },*/
    port: 7000
  },
};


