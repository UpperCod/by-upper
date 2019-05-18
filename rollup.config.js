import pkg from "./package.json";
import resolve from "rollup-plugin-node-resolve";
import { terser } from "rollup-plugin-terser";
import sucrase from "rollup-plugin-sucrase";
import del from "rollup-plugin-delete";
import importCss from "@atomico/rollup-plugin-import-css";
import postcss from "rollup-plugin-postcss";
import cssnano from "cssnano";

let plugins = [
	del({
		targets: [pkg.output]
	}),
	resolve({
		extensions: [".js", ".ts"]
	}),
	importCss({
		include: [/\web-components(\/|\\)([^\.]+)\.css$/]
	}),
	postcss({
		exclude: [/\web-components(\/|\\)/],
		extract: true,
		modules: false,
		plugins: [cssnano()]
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
			dir: pkg.output,
			format: "esm",
			sourcemap: true
		}
	],
	plugins
};
