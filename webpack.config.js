const path = require('path');
const themeConfig = require('./theme-options.json');

const TerserPlugin = require("terser-webpack-plugin");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const DependencyExtractionWebpackPlugin = require('@wordpress/dependency-extraction-webpack-plugin');

// the `remove: false` rule stops autoprefixer from removing prefixes that we manually insert
// this gives us more granular control to support older browsers on a case-by-case basis.
const Autoprefixer = require('autoprefixer')({ remove: false });
const Stylelint = require('stylelint');
const StylelintPlugin = require('stylelint-webpack-plugin');

module.exports = (env) => {
    const isProduction = env.production === true;
    let minificationPlugins = [
        new CssMinimizerPlugin()
    ];

    if (isProduction) {
        minificationPlugins.push(
            new TerserPlugin({
                terserOptions: {
                    compress: true,
                    format: {
                        comments: false,
                    }
                }
            })
        )
    }

    /**
     * If an entrypoint starts with "blocks/", remove that part to return the subfolder name.
     * This is so the folder name can be used as the relative pathname for dist/ inside the block.
     * Otherwise you get /blocks/blocks/[block-name]/dist instead of /blocks/[block-name]/dist.
     */
    const removeBlockName = (entryName) => {
        return entryName.replace(/^blocks\//, '');
    };

    const entries = {
        'theme': './assets/js/theme.js',
        'block-editor': './assets/js/block-editor-styles.js',

        // Layouts
        'archive-news': './assets/js/archive-news.js',

        // Custom Blocks
        'blocks/accordion': './blocks/accordion/main.js',
        'blocks/contact-map': './blocks/contact-map/main.js',
        'blocks/countdown-timer': './blocks/countdown-timer/main.js',
        'blocks/featured-heading': './blocks/featured-heading/main.js',
        'blocks/form-redirect': './blocks/form-redirect/main.js',
        'blocks/hero': './blocks/hero/main.js',
        'blocks/image-content': './blocks/image-content/main.js',
        'blocks/image-gallery-preview': './blocks/image-gallery-preview/main.js',
        'blocks/image-slider': './blocks/image-slider/main.js',
        'blocks/latest-news': './blocks/latest-news/main.js',
        'blocks/logo-slider': './blocks/logo-slider/main.js',
        'blocks/testimonial': './blocks/testimonial/main.js',
        'blocks/testimonial-slider': './blocks/testimonial-slider/main.js',
        'blocks/timeline': './blocks/timeline/main.js',
        'blocks/video': './blocks/video/main.js',
        'blocks/video-popup': './blocks/video-popup/main.js',
    }

    const blockEntries = Object.keys(entries).filter(entry => entry.startsWith('blocks/'));
    const otherEntries = Object.keys(entries).filter(entry => !entry.startsWith('blocks/'));

    const commonConfig = {
        mode: isProduction ? 'production' : 'development',
        devtool: isProduction ? 'source-map' : 'eval-cheap-module-source-map',
        target: 'web',
        context: __dirname,
        // rules for how webpack should resolve/find file names.
        resolve: {
            /** import files without extensions
             *  ------------------------------------------------------------------------------------------
             *  these are the filetypes that we can import without their extensions if we want.
             *   i.e import Header from '../shared/components/Header/Header';
             *  the '*' allows us to also include an explicit extension if we want (i.e. .jpg)
             *  ref: https://webpack.js.org/configuration/resolve/#resolve-extensions
             *  ref: http://stackoverflow.com/questions/37529513/why-does-webpack-need-an-empty-extension
             **/
            extensions: ['.js', '.json', '*'],
        },
        // Control how much info we output. Errors disabled as we are using custom webpack logger.
        stats: {
            // preset: 'minimal',
            errors: true,
        },
        // Performance hints for large file sizes
        performance: (() => {
            // see the devServer entry for explanation of this function syntax (() => {})()
            if (isProduction) {
                return {
                    // could set to error for production...
                    hints: 'warning',

                    // each 'entry' bundle (250kb)
                    maxEntrypointSize: 250000,

                    // any individual assets (250kb)
                    maxAssetSize: 250000,
                };
            }
            // development doesn't show performance hints currently
            return {};
        })(),



        externals: {
            jquery: "jQuery"
        },

        output: {
            /** where should we output?
             *  ------------------------------------------------------------------------------------------
             *  Only relevant for prod because dev server compiles in memory...
             **/
            path: path.resolve(__dirname),
            filename: (pathData) => {
                const entryName = pathData.chunk.name;
                // Check if the entry name starts with "blocks/"
                if (isBlockEntry(entryName)) {
                    // Remove "blocks/" from the entry name to get the block name
                    const blockName = removeBlockName(entryName);
                    // Construct the output path for block JS files
                    return `blocks/${blockName}/dist/main.min.js`;
                } else {
                    return `assets/dist/js/[name].min.js`; // Regular output path for JS
                }
            },

            /** Debug comments in output?
             *  ------------------------------------------------------------------------------------------
             *  outputs comments in the bundled files with details of path/tree shaking
             *  should be false in production, true for development
             **/
            pathinfo: !isProduction,
        },
        /** Loaders to handle files
         *  --------------------------------------------------------------------------------------------
         *  loaders are used to tell webpack how to interpret different file types.
         **/
        module: {
            rules: [
                /** babel
                 *  ----------------------------------------------------------------------------------------
                 *  Run all of our .js files through babel.
                 *  use ES6+ features that aren't widely supported and transpile them back to ES5...
                 **/
                {
                    test: /\.(js|jsx)$/,
                    // only transpile files in our own dirs (theme and Boostrap)
                    include: [
                        path.resolve(__dirname, themeConfig.paths.js),
                        path.resolve(__dirname, 'blocks'), // Include JavaScript files under the blocks directory
                    ],
                    exclude: /node_modules/,
                    enforce: 'pre', // Run this before other loaders
                    loader: 'eslint-loader',
                    options: {
                        configFile: path.resolve(__dirname, 'assets/js/.eslintrc.json'),
                        emitWarning: true, // Emit ESLint warnings as webpack warnings (not errors)
                    },
                    // Transpile all .js files with babel
                    // use: 'babel-loader',
                },

                /** SCSS to CSS, with autoprefixer and stylelint
                 *  ----------------------------------------------------------------------------------------
                 **/
                {
                    test: /.s?css$/,
                    /** LOADERS RUN BOTTOM TO TOP!
                     *  --------------------------------------------------------------------------------------
                     *  to get an idea of the process start with the last array item and work up!
                     **/
                    use: [
                        /** finally we actually load the css!
                         *  ------------------------------------------------------------------------------------
                         *  in production MiniCssExtractPlugin loads the css as file/s
                         *  in development the css is loaded through JS using style-loader
                        **/
                        {
                            loader: MiniCssExtractPlugin.loader
                            // loader: isProduction ? MiniCssExtractPlugin.loader : 'style-loader',
                        },

                        /** next parse import/url() rules
                         *  ------------------------------------------------------------------------------------
                         **/
                        {
                            loader: 'css-loader',
                            options: {
                                sourceMap: true,
                            },
                        },

                        /** Third autoprefix the css
                         *  ------------------------------------------------------------------------------------
                         *  Autoprefixer uses the browserlist in package.json by default,
                         *  we also pass extra options to it when we `require()` it at the top ^^
                         *  this has to run after the sass is converted to css which is why there
                         *  are two separate postcss-loader blocks. One to lint, one to prefix
                        **/
                        {
                            loader: 'postcss-loader',
                            options: {
                                // need this all the way up, so successive loaders hang on to source maps!
                                sourceMap: true,
                                postcssOptions: {
                                    plugins: [
                                        // we specify some rules for Autoprefixer where we `require` it
                                        // at the top of this file...
                                        Autoprefixer,
                                    ],
                                },
                            },
                        },


                        /** Second convert our sass to standard css
                         *  ------------------------------------------------------------------------------------
                         *  this runs node-sass with the options we pass it!
                         **/
                        {
                            loader: 'sass-loader',
                            options: {
                                sourceMap: true,
                                sassOptions: {
                                    outputStyle: 'compressed',
                                }
                            },
                        },


                        /** First lint our non-transformed css
                         *  ------------------------------------------------------------------------------------
                         *  this runs first so that we lint before sass-loader compresses the code!
                         **/
                        {
                            loader: 'postcss-loader',
                            options: {
                                // we install postcss-scss in package.json.
                                // it is a parser that allows postcss to understand scss syntax
                                // we're running stylelint on our .scss code, so we need this parser here
                                postcssOptions: {
                                    parser: 'postcss-scss',
                                    plugins: [
                                        // this const is brought in with `require()` at the top of this file
                                        Stylelint,
                                    ],
                                },
                            },
                        }
                    ],
                },

                /** Asset files
                 *  ----------------------------------------------------------------------------------------
                 *  Asset Modules is a type of module that allows one to use asset files (fonts, icons, etc) without configuring additional loaders.
                 *  use ES6+ features that aren't widely supported and transpile them back to ES5...
                 **/
                {
                    test: /\.(woff|woff2|eot|ttf|otf|svg)$/i,
                    type: 'asset/resource',
                    generator: {
                        filename: './fonts/[name][ext]',
                    },
                }
            ]
        },
        /** Optimisations
         *  --------------------------------------------------------------------------------------------
         *  Run optimization based on the current mode.
         *  override the default minimizer by providing a different one or more customized
         **/
            optimization: {
                minimize: true,
                minimizer: minificationPlugins,
            }
        

        

        /** webpack plugins
         *  --------------------------------------------------------------------------------------------
         *  Array of plugins used to expand webpack functionality
         *  we finish this array with [].filter(plugin => plugin != null),
         *  which removes any empty entries
         *  i.e. `[1,2,,4,5,6].filter(p => p != null)` -- would return --> [1, 2, 4, 5, 6]
         *  this allows us to conditionally include plugins based on the dev/production env.
        **/
    }; // client config object

    const blockConfig = {
        ...commonConfig,
        entry: blockEntries.reduce((obj, key) => ({ ...obj, [key]: entries[key] }), {}),
        output: {
            path: path.resolve(__dirname),
            filename: (pathData) => {
                const entryName = pathData.chunk.name;
                const blockName = removeBlockName(entryName);
                return `blocks/${blockName}/dist/main.min.js`;
            },
            pathinfo: !isProduction,
        },
        plugins: [
            new MiniCssExtractPlugin({
                filename: (pathData) => {
                    const entryName = pathData.chunk.name;
                    const blockName = removeBlockName(entryName);
                    return `blocks/${blockName}/dist/main.min.css`;
                },
            }),
            /** Include a custom logger
            *  ------------------------------------------------------------------------------------------
            *  In order to make the errors clearer I've installed a separate logger by disabling the 
            *  the default output.
            **/
            // new WebpackMessages({
            // 	name: 'Local',
            // 	logger: str => console.log(`>> ${str}`)
            // }),
            new CssMinimizerPlugin(),
            new StylelintPlugin({
                configFile: path.resolve(__dirname, '.stylelintrc'),
                context: path.resolve(__dirname, 'assets/sass'),
                exclude: ['node_modules'],
                files: '**/*.scss'
            }),

            // Set up browsersync using options specified by options.
            // See included theme-options.json file for info.
            new BrowserSyncPlugin(themeConfig.browserSyncOptions),

            // Apply the DependencyExtractionWebpackPlugin conditionally
            new DependencyExtractionWebpackPlugin({
                injectPolyfill: true,
            }),

        ],
    }

    const otherConfig = {
        ...commonConfig,
        entry: otherEntries.reduce((obj, key) => ({ ...obj, [key]: entries[key] }), {}),
        output: {
            path: path.resolve(__dirname),
            filename: 'assets/dist/js/[name].min.js',
            pathinfo: !isProduction,
        },
        plugins: [
            new MiniCssExtractPlugin({
                filename: 'assets/dist/css/[name].min.css',
            }),
            new CssMinimizerPlugin(),
            new StylelintPlugin({
                configFile: path.resolve(__dirname, '.stylelintrc'),
                context: path.resolve(__dirname, 'assets/sass'),
                exclude: ['node_modules'],
                files: '**/*.scss'
            }),
            new BrowserSyncPlugin(themeConfig.browserSyncOptions),
        ],
    };

    return [blockConfig, otherConfig];
};