let Encore = require('@symfony/webpack-encore');
let WebpackNotifierPlugin = require('webpack-notifier');
let CopyWebpackPlugin = require('copy-webpack-plugin');

Encore
    // the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .enableSassLoader()
    .autoProvidejQuery()
    .addPlugin(new WebpackNotifierPlugin())
    .addPlugin(new CopyWebpackPlugin([
        {from: 'node_modules/tinymce/skins', to: 'skins'},
        {from: 'node_modules/tinymce-i18n/langs', to: 'langs'},
        {from: 'node_modules/tinymce/plugins/emoticons/img/', to: 'plugins/emoticons/img/'}
    ]))
    .addLoader({
        test: /\.woff(2)?(\?v=[0-9]\.[0-9]\.[0-9])?$/,
        loader: "url-loader?limit=10000&mimetype=application/font-woff"
    })
    .addLoader({
        test: /\.(ttf|eot|svg)(\?v=[0-9]\.[0-9]\.[0-9])?$/,
        loader: "file-loader"
    })
    // uncomment to create hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())
    // uncomment to define the assets of the project
    .addEntry('app', './assets/js/app.js')
    .addEntry('cms', './assets/js/cms.js')
;

module.exports = Encore.getWebpackConfig();
