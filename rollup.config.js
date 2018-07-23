import resolve from "rollup-plugin-node-resolve";
import commonjs from "rollup-plugin-commonjs";
import buble from "rollup-plugin-buble";

import postcss from "rollup-plugin-postcss";
import cssMqpacker from "css-mqpacker";
import mergeRules from "postcss-merge-rules";
import cssnano from "cssnano";
import cssimport from "postcss-import";
import cssProperties from "postcss-custom-props";
import presetEnv from "postcss-preset-env";

export default {
    input: "assets/index.js",
    output: {
        file: "static/bundle.js",
        format: "iife",
        name: "bundle"
    },
    sourceMap: true,
    plugins: [
        resolve({
            jsnext: true,
            main: true
        }),
        commonjs({
            include: "node_modules/**"
        }),
        postcss({
            extract: true,
            modules: false,
            plugins: [
                cssimport,
                presetEnv({
                    stage: 0,
                    browsers: "last 2 versions"
                }),
                cssProperties(),
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
