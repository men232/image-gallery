var webpack = require('webpack');

module.exports = {
	entry: './app/driver.coffee',
	module: {
		loaders: [
			{ test: /\.html$/, loader: 'underscore-template-loader' },
			{ test: /\.coffee$/, loader: 'coffee' }
		]
	},
	output: {
		path: __dirname + '/static/js',
		filename: 'bundle.js'
	},
	plugins: [
	new webpack.ProvidePlugin({
		_: 'underscore'
	})
	],
	resolve: {
		extensions: ['', '.web.coffee', '.web.js', '.coffee', '.js'],
		modulesDirectories: [__dirname + '/node_modules'],
		root: __dirname + '/app'
	},
	resolveLoader: {
		root: __dirname + '/node_modules'
	},
	devServer: {
		proxy: {
			'/api/*': {
				target: 'http://localhost:8000/'
			}
		}
	}
};