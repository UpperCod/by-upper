import resolve from "rollup-plugin-node-resolve";
import buble from "rollup-plugin-buble";

import postcss from "rollup-plugin-postcss";
import cssMqpacker from "css-mqpacker";
import mergeRules from "postcss-merge-rules";
import cssnano from "cssnano";
import cssnext from "postcss-cssnext";

export default {
    input: "assets/index.js",
    output: {
        file: "static/bundle.js",
        format: "iife",
        name: "bundle",
        sourceMap: true
    },
    plugins: [
        resolve({
            jsnext: true,
            main: true
        }),
        postcss({
            extract: true,
            modules: false,
            plugins: [cssnext, mergeRules, cssMqpacker, cssnano]
        }),
        buble({
            jsx: "h",
            objectAssign: "Object.assign"
        })
    ]
};
