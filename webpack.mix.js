const mix = require('laravel-mix');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
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



mix.webpackConfig({
    plugins: [
        new BrowserSyncPlugin({
            proxy: 'http://localhost:8000', // URL de tu servidor local (Laravel con `php artisan serve`)
            files: [
                'app/**/*.php',
                'resources/views/**/*.blade.php',
                'routes/**/*.php',
                'public/js/**/*.js',
                'public/css/**/*.css'
            ],
            open: false,
            notify: false
        })
    ]
});




if (mix.inProduction()) {
    mix.version();
}