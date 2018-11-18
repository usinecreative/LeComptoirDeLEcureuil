let Encore = require('@symfony/webpack-encore');
let WebpackNotifierPlugin = require('webpack-notifier');
let CopyWebpackPlugin = require('copy-webpack-plugin');

Encore
    // The project directory where compiled assets will be stored
    .setOutputPath('public/build/')

    // The public path used by the web server to access the previous directory
    .setPublicPath('/build')

    // Remove the build directory on each build
    .cleanupOutputBeforeBuild()

    // Enable the assets versioning only in production mode to allow debug
    .enableVersioning(Encore.isProduction())

    // Enable source map in production
    .enableSourceMaps(!Encore.isProduction())

    .disableSingleRuntimeChunk()

    // Enable build notifications
    .addPlugin(new WebpackNotifierPlugin())

    // Auto provide the Sass loader and jQuery
    .enableSassLoader()
    .autoProvidejQuery()

    // Add the main js entries
    .addEntry('app', './assets/js/app.js')
    .addEntry('cms', './assets/js/cms.js')
    .addEntry('tinymce/cms.tinymce', './assets/js/cms.tinymce.js')

    // Copy the jquery file-upload files into the public directory of the cms bundle
    .copyFiles({
        from: 'node_modules/blueimp-file-upload/js',
        to: '../../src/JK/CmsBundle/Resources/public/js/jquery-file-upload/[name].[ext]',
        pattern: /\.(js)$/
    })

    // Copy the files required for the file upload
    .copyFiles({
        from: 'node_modules/blueimp-file-upload/js',
        to: '../../src/JK/CmsBundle/Resources/public/js/jquery-file-upload/[name].[ext]',
        pattern: /\.(js)$/
    })

    // Copy the files required by tinymce
    .addPlugin(new CopyWebpackPlugin([
        {from: 'node_modules/tinymce/skins', to: 'tinymce/skins'},
        {from: 'node_modules/tinymce-i18n/langs', to: 'tinymce/langs'},
        {from: 'node_modules/tinymce/plugins/emoticons/img/', to: 'tinymce/plugins/emoticons/img/'}
    ]))

    // Add loaders to load font files
    .addLoader({
        test: /\.woff(2)?(\?v=[0-9]\.[0-9]\.[0-9])?$/,
        loader: "url-loader?limit=10000&mimetype=application/font-woff"
    })
    .addLoader({
        test: /\.(ttf|eot|svg)(\?v=[0-9]\.[0-9]\.[0-9])?$/,
        loader: "file-loader"
    })
;

module.exports = Encore.getWebpackConfig();
