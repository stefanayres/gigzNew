let mix = require('laravel-mix');
const ExtractTextPlugin = require("extract-text-webpack-plugin");

  mix.react('resources/js/app.js', 'public/js')
  .sass('resources/sass/app.scss', 'public/css');
