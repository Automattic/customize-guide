import { babel } from '@rollup/plugin-babel';
import commonjs from '@rollup/plugin-commonjs';
import eslint from '@rollup/plugin-eslint';
import { nodeResolve } from '@rollup/plugin-node-resolve';
import { terser } from "rollup-plugin-terser";

const prod = ( process.env.NODE_ENV === 'production' );

const config = [
	{
		input: 'src/customize-guide.js',
		output: {
			file: 'js/customize-guide.js',
			format: 'iife',
			globals: {
				$: 'window.jQuery',
				jquery: 'window.jQuery',
			}
		},
		plugins: [
			nodeResolve({
				browser: true,
			}),
			commonjs(),
			prod && eslint(),
			babel({
				exclude: 'node_modules/**'
			}),
			prod && terser(),
		],
		external: [
			'jquery',
			'underscore',
		],
	}
];


if (prod) {
	config.external.push('debug');
	config.output.globals.debug = 'function(){ return window._.noop; }';
}

export default config;