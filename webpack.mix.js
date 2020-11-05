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

/* mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        
    ]); */

mix
    .scripts([
        'resources/crystal/js/sweetalert2.all.js',
        'resources/crystal/js/functionGeneral.js',
        'resources/crystal/js/moment.js',
    ], 'public/js/crystal.js')
    .autoload({
        'jquery': ['$', 'window.jQuery', 'jQuery'],
        'vue': ['Vue','window.Vue'],          
    })
    .js(['resources/js/app.js'],'public/js/app.js');
