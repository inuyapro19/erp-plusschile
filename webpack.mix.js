const mix = require('laravel-mix');

const path = require('path');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css')
    //.sass('resources/assets/sass/style.scss', 'public/css')
    .alias({
      '@': path.resolve('resources/js'),
    })


mix.webpackConfig({
    devServer: {
        hot: true,
        contentBase: path.resolve(__dirname, 'public'),
        publicPath: '/',
        host: 'trabajadores-v3.test',
        port: 8080,
        disableHostCheck: true,
        headers: {
            'Access-Control-Allow-Origin': '*'
        }
    }
});

if (mix.inProduction()) {
    mix.version();
}
