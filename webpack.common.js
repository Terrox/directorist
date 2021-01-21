const path                 = require("path");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const VueLoaderPlugin      = require('vue-loader/lib/plugin');

const commonConfig = {
  resolve: {
    extensions: [ '.js', '.vue' ],
    alias: {
      'vue$': 'vue/dist/vue.esm.js'
    }
  },
  plugins: [
    new VueLoaderPlugin()
  ],
  module: {
    rules: [
      // Loading Images
      {
        test: /\.(png|jpe?g|gif|svg)$/i,
        use: [
          {
            loader: "file-loader",
            options: {
              outputPath: "../images",
            },
          },
        ],
      },
      // Loading Fonts
      {
        test: /\.(woff|woff2|eot|ttf|otf)$/,
        use: {
          loader: "file-loader",
          options: {
            outputPath: "../fonts",
          },
        },
      },
      // Loading JS
      {
        test: /\.vue$/,
        loader: 'vue-loader',
      },
      {
        test: /\.m?js$/,
        exclude: /(node_modules|bower_components)/,
        use: [
          {
            loader: "babel-loader",
            options: {
              presets: ["@babel/preset-env"],
            }
          },
        ]
      },
      // Loading SASS
      {
        test: /\.s[ac]ss$/i,
        use: [
          {
            loader: MiniCssExtractPlugin.loader,
            options: {
              hmr: process.env.NODE_ENV === "development",
              reloadAll: true,
            },
          },
          {
            loader: 'css-loader',
            options: {
              sourceMap: true,
            }
          },
          'resolve-url-loader',
          {
            loader: 'postcss-loader',
            options: {
              sourceMap: true,
              config: {
                path: 'postcss.config.js'
              }
            }
          },
          {
            loader: "sass-loader",
            options: {
              sourceMap: true,
              sassOptions: {
                // outputStyle: 'compressed',
              },
            },
          },
        ],
      },
    ],
  },

  devtool: 'source-map'
};

// Public Config
const publicConfig = {
  entry: {
    ['main']: "./public/assets/src/js/main.js",
  },

  output: {
    // filename: "[name].js",
    path: path.resolve(__dirname, "public/assets/js"),
  },

  ...commonConfig
};

// Admin Config
const adminConfig  = {
  entry: {
    ['main']: "./public/assets/src/js/admin/main.js",
    ['custom-field']: "./public/assets/src/js/admin/custom-field.js",
    ['directorist-plupload']: "./public/assets/src/js/admin/directorist-plupload.js",
    ['extension-update']: "./public/assets/src/js/admin/extension-update.js",
    ['import-export']: "./public/assets/src/js/admin/import-export.js",
    ['plugins']: "./public/assets/src/js/admin/plugins.js",
    ['setup-wizard']: "./public/assets/src/js/admin/setup-wizard.js",
    ['multi-directory-builder']: "./public/assets/src/js/admin/multi-directory-builder.js",
    ['multi-directory-archive']: "./public/assets/src/js/admin/multi-directory-archive.js",
    ['settings-manager']: "./public/assets/src/js/admin/settings-manager.js",
  },

  output: {
    // filename: "[name].js",
    path: path.resolve(__dirname, "admin/assets/js"),
  },

  ...commonConfig
};

module.exports = [ publicConfig, adminConfig ];
