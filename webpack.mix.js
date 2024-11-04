const mix = require('laravel-mix');
// require('postcss-import');
// require('postcss-nesting');
// require('tailwindcss');
// const tailwindcss = require('tailwindcss');

const {
  MIX_DOMAIN,
  MIX_SYNC_PREFIX,
  MIX_SYNC_PORT,
  MIX_DIR_SRC,
  MIX_DIR_DIST,
  MIX_SYNC,
} = process.env;

mix.setPublicPath('./public');

mix.options({
  processCssUrls: false,
  publicPath: ('./'),
  // terser: {},
});

mix.js(
  `${MIX_DIR_SRC}js/core.js`,
  `${MIX_DIR_DIST}core.js`,
// ).extract();
);


// mix.sass(
//   `${MIX_DIR_SRC}scss/core.scss`,
//   `${MIX_DIR_DIST}core.css`,
// );
mix.sass(
  `${MIX_DIR_SRC}scss/core.scss`,
  `${MIX_DIR_DIST}core.css`,
).options({
  processCssUrls: false,
  postCss: [
    // 'postcss-import',
    // 'postcss-nesting',
    'tailwindcss',
    // tailwindcss('./tailwind.config.js'),
    // 'autoprefixer',
  ],
});

mix.babelConfig({
  // plugins: [],
  presets: [
    [
      '@babel/preset-env',
      {
        targets: {
          browsers: [
            'chrome 70',
            'firefox 62',
            'safari 10',
            'edge 15',
            // 'ie 11',
          ],
        },
        useBuiltIns: 'usage',
        corejs: 3,
        // corejs: { version: 3, proposals: true },
      },
    ],
  ],
});

// mix.webpackConfig({
//   watchOptions: {
//     poll: 1000, // Check for changes every second
//   },
// });

// TS
// mix.webpackConfig({
//   module: {
//     rules: [
//       {
//         test: /\.tsx?$/,
//         loader: 'ts-loader',
//         options: { /* appendTsSuffixTo: [/\.vue$/] */ },
//         exclude: /node_modules/,
//         // doesn't work here :( so it's in tsconfig.json with paths hardcoded
//         // include: [
//         //   `/${process.env.MIX_DIR_SRC}/js/**/*`,
//         //   `/${process.env.MIX_DIR_SRC}/vue/**/*`,
//         // ],
//       },
//     ],
//   },
//   resolve: {
//     extensions: ['*', '.js', '.jsx', '.vue', '.ts', '.tsx'],
//   },
// });

if (MIX_SYNC == 1) {
  mix.browserSync({
    // ui: false,
    injectChanges: false,
    notify: true,
    host: `${MIX_SYNC_PREFIX}.${MIX_DOMAIN}`,
    port: MIX_SYNC_PORT,
    proxy: MIX_DOMAIN,
    open: 'external',
    logLevel: 'info',
    logConnections: true,
    files: [
      `${MIX_DIR_DIST}*.*`,
    ],
  });
}

mix.sourceMaps(false, 'inline-source-map');

// Full API
// mix.js(src, output);
// mix.react(src, output); <-- Identical to mix.js(), but registers React Babel compilation.
// mix.preact(src, output); <-- Identical to mix.js(), but registers Preact compilation.
// mix.coffee(src, output); <-- Identical to mix.js(), but registers CoffeeScript compilation.
// mix.ts(src, output); <-- TypeScript support. Requires tsconfig.json to exist in the same folder as webpack.mix.js
// mix.extract(vendorLibs);
// mix.sass(src, output);
// mix.less(src, output);
// mix.stylus(src, output);
// mix.postCss(src, output, [require('postcss-some-plugin')()]);
// mix.browserSync('my-site.test');
// mix.combine(files, destination);
// mix.babel(files, destination); <-- Identical to mix.combine(), but also includes Babel compilation.
// mix.copy(from, to);
// mix.copyDirectory(fromDir, toDir);
// mix.minify(file);
// mix.sourceMaps(); // Enable sourcemaps
// mix.version(); // Enable versioning.
// mix.disableNotifications();
// mix.setPublicPath('path/to/public');
// mix.setResourceRoot('prefix/for/resource/locators');
// mix.autoload({}); <-- Will be passed to Webpack's ProvidePlugin.
// mix.webpackConfig({}); <-- Override webpack.config.js, without editing the file directly.
// mix.babelConfig({}); <-- Merge extra Babel configuration (plugins, etc.) with Mix's default.
// mix.then(function () {}) <-- Will be triggered each time Webpack finishes building.
// mix.dump(); <-- Dump the generated webpack config object to the console.
// mix.extend(name, handler) <-- Extend Mix's API with your own components.
// mix.options({
//   extractVueStyles: false, // Extract .vue component styling to file, rather than inline.
//   globalVueStyles: file, // Variables file to be imported in every component.
//   processCssUrls: true, // Process/optimize relative stylesheet url()'s. Set to false, if you don't want them touched.
//   purifyCss: false, // Remove unused CSS selectors.
//   terser: {}, // Terser-specific options. https://github.com/webpack-contrib/terser-webpack-plugin#options
//   postCss: [] // Post-CSS options: https://github.com/postcss/postcss/blob/master/docs/plugins.md
// });

// mix.options({ processCssUrls: false });
// mix.webpackConfig({
//   node: {
//     fs: "empty",
//     request: "empty"
//   },
//   resolve: {
//     alias: {
//         "handlebars" : "handlebars/dist/handlebars.js"
//     }
//   },
// });

// https://webpack.js.org/guides/shimming/
