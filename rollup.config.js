import resolve from "rollup-plugin-node-resolve";
import buble from "rollup-plugin-buble";
import commontjs from "rollup-plugin-commonjs";

import postcss from "rollup-plugin-postcss";
import cssMqpacker from "css-mqpacker";
import mergeRules from "postcss-merge-rules";
import cssnano from "cssnano";
import presetEnv from "postcss-preset-env";

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
        commontjs({
            include: "node_modules/**"
        }),
        postcss({
            extract: true,
            modules: false,
            plugins: [
                presetEnv({
                    browsers: "last 2 versions"
                }),
                mergeRules,
                cssMqpacker,
                cssnano
            ]
        }),
        buble({
            jsx: "h",
            objectAssign: "Object.assign"
        })
    ]
};
