import pkg from "./package.json";
import resolve from "rollup-plugin-node-resolve";
import { terser } from "rollup-plugin-terser";
import sucrase from "rollup-plugin-sucrase";
import postcss from "rollup-plugin-postcss";

let plugins = [
	resolve({
		extensions: [".js", ".ts"]
	}),
	postcss({
		extract: true,
		minimize: true
	}),
	sucrase({
		production: true,
		exclude: ["node_modules/**"],
		jsxPragma: "h",
		transforms: ["typescript", "jsx"]
	})
];

if (!process.env.ROLLUP_WATCH) {
	plugins.push(terser());
}

export default {
	input: pkg.source,
	output: [
		{
			file: pkg.output,
			format: "iife",
			sourcemap: true
		}
	],
	plugins
};
