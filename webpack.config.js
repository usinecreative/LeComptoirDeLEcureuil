let Encore = require('@symfony/webpack-encore');
let WebpackNotifierPlugin = require('webpack-notifier');
let path = require('path');

Encore
    // the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .enableSassLoader((options) => {
        options.includePaths = [
            path.resolve(__dirname, "./node_modules/compass-mixins/lib")
        ];
    })
    // .addRule({
    //     test: /\.css$/,
    //     use: ['style-loader', 'css-loader']
    // })
    .autoProvidejQuery()
    .addPlugin(new WebpackNotifierPlugin({
        alwaysNotify: true
    }))
    // uncomment to create hashed filenames (e.g. app.abc123.css)
    // .enableVersioning(Encore.isProduction())
    // uncomment to define the assets of the project
    .addEntry('app', './assets/js/app.js')
;

module.exports = Encore.getWebpackConfig();
