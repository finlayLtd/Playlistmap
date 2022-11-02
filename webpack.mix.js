const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
    .sass('resources/sass/main.scss', 'public/css/codebase.css')
    .sass('resources/sass/codebase/themes/corporate.scss', 'public/css/themes/')
    .sass('resources/sass/icons.scss', 'public/css/icons.css')

    .js('resources/js/app.js', 'public/js/laravel.app.js')
    .js('resources/js/codebase/app.js', 'public/js/codebase.app.js')


    .options({
        processCssUrls: false
    })

    .js('resources/js/app.js', 'public/js').postCss('resources/css/app.css', 'public/css', [
    require('postcss-import'),
    require('tailwindcss'),
    require('autoprefixer'),
]);
