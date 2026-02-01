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

// setting for debug with vuecli with laravel mix
mix.webpackConfig({ devtool: 'source-map' });

mix.js('resources/js/app.js', 'public/js').vue().sourceMaps()
    .sass('resources/sass/app.scss', 'public/css')
    .webpackConfig(require('./webpack.config'))
	.version();

if (mix.inProduction()) {
    mix.version();
}
