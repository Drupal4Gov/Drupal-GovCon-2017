'use strict';

const path = require("path");
const glob = require("glob");
const files = glob.sync("./js/modules/*.js");

let config = {
  entry: {},
  output: {
    filename:'[name].js',
  },
  module: {
    loaders: [
      {
        test: /\.js$/,
        loader: 'babel-loader',
        options: {
          presets: ['es2015'],
        },
      }
    ]
  }
}

files.forEach(function(file, i){
  const entry = path.basename(file).replace(/\.js$/, '');
  config.entry[entry] = file;
});

module.exports = config;