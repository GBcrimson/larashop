const NODE_ENV = process.env.NODE_ENV || 'development';
const webpack = require('webpack');
const path = require('path');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const UglifyJSPlugin = require('uglifyjs-webpack-plugin');

let extractStyles = new ExtractTextPlugin({
    filename: 'css/[name].css',
    allChunks: false,
});

console.log('NODE_ENV = ', NODE_ENV);

const config = {
    context: path.resolve(__dirname, 'src'),

    entry: 'js/index.js',

    output: {
        path: path.resolve(__dirname, 'build'),
        filename: 'js/bundle.js',
        publicPath: "/"
    },
    devtool: NODE_ENV === 'production' ? 'source-map' : 'eval-source-map',
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: 'babel-loader'
            },
            {
                test: /\.scss$/,
                exclude: /node_modules/,
                loader: extractStyles.extract({
                        use: "css-loader?minimize=true!sass-loader",
                })

            },
            {
                test: /\.(eot|ttf|woff|woff2|jpe?g|png|gif|svg)$/,
                loader: 'file-loader?name=assets/[path][name].[ext]'
                // use: 'file-loader'
            },
            {
                test: /\.pug$/,
                loaders: ['file-loader?name=[name].html', 'pug-html-loader']

            }
        ]
    },
    resolve: {
        modules: ["./src", "node_modules"],

        alias: {
            'Styles': path.resolve(__dirname, './src/css'),
            'Js': path.resolve(__dirname, './src/js'),
            'Pug': path.resolve(__dirname, './src/pug'),
        }
    },
    plugins: [
        new CleanWebpackPlugin(path.resolve(__dirname, './build')),
        new webpack.DefinePlugin({
            __DEV__: JSON.stringify(NODE_ENV !== 'production'),
        }),
        extractStyles,
        new UglifyJSPlugin(),
        new CopyWebpackPlugin([{
            from: 'static',
            to: 'assets/static',
        }], {
            ignore: [
                '*.txt',
            ],
        })
    ],

};

module.exports = config;