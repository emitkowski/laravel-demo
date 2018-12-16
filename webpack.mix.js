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
        'node_modules/bootstrap-switch/dist/js/bootstrap-switch.min.js',
        'node_modules/datatables.net/js/jquery.dataTables.min.js',
        'node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js',
        'node_modules/bootstrap-table/dist/bootstrap-table.min.js',
        'node_modules/mark.js/dist/jquery.mark.js',
        'node_modules/datatables.mark.js/dist/datatables.mark.min.js',
        'resources/js/theme/responsive_datatables.js',
        'resources/js/theme/simple-table.js',
        'resources/js/theme/advanced_modals.js',
        'resources/js/custom.js',
    ], 'public/js/vendor.js');

// CSS
mix.sass('resources/sass/app.scss', 'public/css');
mix.sass('resources/sass/auth.scss', 'public/css');

// Custom Styles
mix.styles(
    [
        'node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css',
        'node_modules/datatables.mark.js/dist/datatables.mark.min.css',
        'node_modules/animate.css/animate.min.css',
        'node_modules/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css'
    ], 'public/css/all.css');

// Images
mix.copy('resources/images', 'public/images');

