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

// JS
mix.js('resources/js/app.js', 'public/js');

mix.scripts(
    [
        'resources/js/theme/leftmenu.js',
        'node_modules/jquery.nicescroll/dist/jquery.nicescroll.min.js',
        'resources/js/theme/rightside_bar.js',
        'resources/js/custom.js',
    ], 'public/js/vendor.js');

// CSS
// ========utility based css====
mix.sass('resources/sass/utility-core.scss', 'public/css').version();
mix.sass('resources/sass/app.scss', 'public/css');
mix.sass('resources/sass/auth.scss', 'public/css');

// Custom Styles
mix.styles(
    [
        'node_modules/animate.css/animate.min.css',
    ], 'public/css/all.css');

// Images
mix.copy('resources/images', 'public/images');

