const mix = require("laravel-mix");

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

mix.js("resources/js/app.js", "public/js").postCss(
    "resources/css/app.css",
    "public/css",
    [
        //
    ]
);

// mix.copy(
//     "ramani-expenses-frontend/src/index.template.html",
//     "resources/views/index.blade.php"
// ).copyDirectory("ramani-expenses-frontend/src", "public");


mix
.copy('ramani-expenses-frontend/dist/spa/index.html', 'resources/views/index.blade.php')
.copyDirectory('ramani-expenses-frontend/dist/spa', 'public');

// mix
// .copy('ramani-expenses-frontend/src', 'resources/views/index.blade.php')
// .copyDirectory('ramani-expenses-frontend/dist/spa', 'public');

mix.webpackConfig({
    module: {
        rules: [
            {
                test: /\.mjs$/,
                resolve: { fullySpecified: false },
                include: /node_modules/,
                type: "javascript/auto",
            },
        ],
    },
});

