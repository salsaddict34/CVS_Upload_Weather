const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

var config = {
    entry: "./client/src/assets/js/main.js",
    watch: true,
    output: {
        path: path.resolve('./dist'),
        filename: 'bundle.js'
    },
    plugins: [new MiniCssExtractPlugin({
        filename: '[name].css'
    })],
    module: {
        rules: [
            {
                test: /\.m?js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: [
                            ['@babel/preset-env', { targets: "defaults" }]
                        ]
                    }
                }
            },
            {
                test: /\.css$/i,
                use: [
                    MiniCssExtractPlugin.loader,
                    "css-loader",
                    {
                        loader: "postcss-loader",
                        options: {
                            postcssOptions: {
                                plugins: [
                                    [
                                        "postcss-preset-env",
                                        {
                                            // Options
                                            browsers: ['last 2 versions', 'IE > 8']
                                        },
                                    ],
                                ],
                            },
                        },
                    },
                ],
            },
            {
                test: /\.s[ac]ss$/i,
                use: [
                    // Creates `style` nodes from JS strings
                    "style-loader",
                    // Translates CSS into CommonJS
                    {
                        loader: "css-loader",
                        options: {
                            importLoaders: 1,
                        }
                    },
                    // PostCss
                    {
                        loader: "postcss-loader",
                        options: {
                            postcssOptions: {
                                plugins: [
                                    [
                                        "postcss-preset-env",
                                        {
                                            // Options
                                        },
                                    ],
                                ],
                            },
                        },
                    },
                    // Compiles Sass to CSS
                    "sass-loader",
                ],
            }
        ]
    }
}

module.exports = (env, argv) => {
    if (argv.mode === 'development') {
        config.devtool = 'source-map';
    }

    if (argv.mode === 'production') {
        //...
    }

    return config;
};