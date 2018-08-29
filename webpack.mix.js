let mix = require('laravel-mix');
let fs = require('fs');

mix .options({
        processCssUrls: false,
    })
    .sass('assets/css/ripples.sass', 'assets/css/')
    .sourceMaps()
    .setPublicPath('./');

mix .js('assets/js/ripples.js', 'assets/js/ripples.dist.js')
    .setPublicPath('./');