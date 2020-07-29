// Extends the default `webpack.config.js` from the @wordpress/scripts package.

// Build for production with `npm run build:js`.
// Build for development with `npm run dev`. (Live reload, source maps, Ctrl-C to exit.)
//
// The WordPress Scripts package generates a dependencies file with the
// extension `.deps.json` that you can use to determine required dependencies
// when enqueueing scripts:
//
// wp_enqueue_script(
//	'example-file',
//	JOHANNES_DIR_URL . '/build/example-file.js',
//	[ 'wp-polyfill', 'wp-other-dependency' ], // This line from build/example-file.deps.json.
//	PARENT_THEME_VERSION,
//	true
//);
//
// The *.deps.json files are gitignored and do not need to be committed.

const defaultConfig = require("./node_modules/@wordpress/scripts/config/webpack.config");

module.exports = [
	// Initial JS File
	{
		...defaultConfig,
		entry: __dirname + '/includes/admin/js/src/index.js',
		output: {
			path: __dirname + '/',
			filename: 'includes/admin/js/build/index.js',
		},
		module: {
			rules: [
				{
					test: /\.(js|jsx)$/,
					exclude: /node_modules/,
					use: ['babel-loader']
				}
			]
		},
	}
];
