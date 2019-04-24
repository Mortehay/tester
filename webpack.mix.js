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

mix.options({
    processCssUrls: false
});

mix.scripts('resources/js/main.js', 'public/js/app.js').version()
    .less('resources/less/style.less', 'public/css/app.css').version()
    .less('resources/less/admin.less', 'public/css/admin.css').version()
    .less('resources/less/login.less', 'public/css/login.css').version();
