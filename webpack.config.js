const path = require('path');
const autoprefixer = require('autoprefixer');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const FixStyleOnlyEntriesPlugin = require('webpack-fix-style-only-entries');
const { WebpackManifestPlugin } = require('webpack-manifest-plugin');

const devMode = process.env.NODE_ENV !== 'production';

module.exports = {
  externals: {
    jquery: 'jQuery',
  },

  mode: devMode ? 'development' : 'production',

  /**
   * Entry files - Add more entries if needed.
   */
  entry: {
    'js/modularity-form-builder-admin': './source/js/modularity-form-builder-admin.js',
    'js/modularity-form-builder-front': './source/js/modularity-form-builder-front.js',
    'css/modularity-form-builder': './source/sass/modularity-form-builder.scss',
  },

  /**
   * Output files
   */
  output: {
    filename: devMode ? '[name].js' : '[name].[contenthash:8].js',
    chunkFilename: devMode ? '[id].js' : '[id].[contenthash:8].js',
    path: path.resolve(process.cwd(), 'dist'),
  },

  module: {
    rules: [
      /**
       * Babel
       */
      {
        test: /\.jsx?/,
        exclude: /(node_modules|bower_components)/,
        use: {
          loader: 'babel-loader',
          options: {
            // Babel config here
            presets: ['@babel/preset-env', '@babel/preset-react'],
            plugins: [
              '@babel/plugin-syntax-dynamic-import',
              '@babel/plugin-proposal-export-default-from',
              '@babel/plugin-proposal-class-properties',
              'react-hot-loader/babel',
            ],
          },
        },
      },

      /**
       * Compile sass to css
       */
      {
        test: /\.(sa|sc|c)ss$/,
        use: [
          MiniCssExtractPlugin.loader,
          {
            loader: 'css-loader',
            options: {
              importLoaders: 2, // 0 => no loaders (default); 1 => postcss-loader; 2 => sass-loader
            },
          },
          {
            loader: 'postcss-loader',
            options: {
              postcssOptions: {
                plugins: [autoprefixer],
              },
            },
          },
          'sass-loader',
        ],
      },

      /**
       * Images
       */
      {
        test: /\.(png|svg|jpg|gif)$/,
        use: [
          {
            loader: 'file-loader',
            options: {
              name: devMode ? '[name].[ext]' : '[name].[contenthash:8].[ext]',
            },
          },
        ],
      },
      /**
       * Fonts
       */
      {
        test: /\.(png|svg|jpg|gif)$/,
        use: [
          {
            loader: 'file-loader',
            options: {
              name: devMode ? '[name].[ext]' : '[name].[contenthash:8].[ext]',
            },
          },
        ],
      },
    ],
  },

  /**
   * Plugins
   */
  plugins: [
    new CleanWebpackPlugin(),
    new FixStyleOnlyEntriesPlugin(),
    // Minify css and create css file
    new MiniCssExtractPlugin({
      filename: devMode ? '[name].css' : '[name].[contenthash:8].css',
      chunkFilename: devMode ? '[name].css' : '[name].[contenthash:8].css',
    }),
    new WebpackManifestPlugin({
      fileName: 'rev-manifest.json',
      // Filter manifest items
      filter(file) {
        // Don't include source maps
        if (file.path.match(/\.(map)$/)) {
          return false;
        }
        return true;
      },
      generate: (seed, files, entries) => {
        const manifest = {};
        for (const file of files) {
          manifest[file.name] = file.path.replace(/^auto/, '');
        }
        return manifest;
      },
      // Custom mapping of manifest item goes here
      map(file) {
        // Fix incorrect key for fonts
        if (file.isAsset && file.isModuleAsset && file.path.match(/\.(woff|woff2|eot|ttf|otf)$/)) {
          const pathParts = file.path.split('.');
          const nameParts = file.name.split('.');

          // Compare extensions
          if (pathParts[pathParts.length - 1] !== nameParts[nameParts.length - 1]) {
            file.name = pathParts[0].concat('.', pathParts[pathParts.length - 1]);
          }
        }
        return file;
      },
    }),
  ],
};
