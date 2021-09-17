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

 //ADMIN LTE
mix.styles([
    'resources/assets/admin/plugins/fontawesome-free/css/all.min.css',
    'resources/assets/admin/css/adminlte.min.css',
    'resources/assets/admin/plugins/select2/css/select2.css', // Добавляем 2 папки для select списка
    'resources/assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.css',  // Добавляем 2 папки для select списка
], 'public/assets/admin/css/admin.css');

mix.scripts([
    'resources/assets/admin/plugins/jquery/jquery.min.js',
    'resources/assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js',
    'resources/assets/admin/plugins/select2/js/select2.full.js', //для select списка
    'resources/assets/admin/js/adminlte.min.js',
    'resources/assets/admin/js/demo.js',
], 'public/assets/admin/js/admin.js');

mix.copyDirectory('resources/assets/admin/plugins/fontawesome-free/webfonts', 'public/assets/admin/webfonts'); // копир шрифты
mix.copyDirectory('resources/assets/admin/img', 'public/assets/admin/img'); // копир картинки

mix.copy('resources/assets/admin/css/adminlte.min.css.map', 'public/assets/admin/css'); //копир map
mix.copy('resources/assets/admin/js/adminlte.min.js.map', 'public/assets/admin/js');
