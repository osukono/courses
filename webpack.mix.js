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

mix.js('resources/js/admin_3x0xof.js', 'public/js')
    .sass('resources/sass/admin_3x0xof.scss', 'public/css')
    // .sourceMaps(false)
    .version();

mix.js('resources/js/admin_vue_3x0xof.js', 'public/js')
    // .sourceMaps(false)
    .version();

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    // .sourceMaps(false)
    .version();

mix.js('resources/js/vue.js', 'public/js')
    .vue()
    // .sourceMaps(false)
    .version();
