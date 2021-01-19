const common    = require("./webpack.common");
const { merge } = require('webpack-merge');

const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const WebpackRTLPlugin     = require("webpack-rtl-plugin");

const prodConfig = {
  mode: "production", // production | development
  plugins: [
    new MiniCssExtractPlugin({
      filename: "../css/[name].css",
      minify: true,
    }),
    new WebpackRTLPlugin({
      minify: true,
    }),
  ],
};

let configs = [];
common.forEach(element => {
  const _config = merge( element, prodConfig );
  configs.push( _config );
});

module.exports = configs;