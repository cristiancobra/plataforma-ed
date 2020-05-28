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

mix
        .styles('resources/views/css/style.css', 'public/css/style.css')

        .js('resources/views/js/menu.js', 'public/js/menu.js')

        .js('resources/js/app.js', 'js')

        .sass('resources/sass/app.scss', 'public/css')

        .version();

