const mix = require('laravel-mix');

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
    .sass('resources/sass/app.scss', 'public/css')

        .js([
    'resources/js/general.js',
    'resources/js/menu.js'
    ], 'public/js/script.js')

        .styles([
    'resources/css/app.css',
    'resources/css/dashboard.css',
    'resources/css/list.css',
    'resources/css/show.css',
    'resources/css/style.css'
        ], 'public/css/style.css')

        .styles('resources/css/pdf.css', 'public/css/pdf.css')
        
        .version();
