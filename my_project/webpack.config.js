const Encore = require('@symfony/webpack-encore');

// Configure Webpack Encore
Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('app', './assets/js/app.tsx')  // Fichier d'entrée TypeScript/React
    .enableReactPreset()                     // Activer React
    .enableTypeScriptLoader()                // Activer TypeScript
    .enablePostCssLoader()                   // Activer PostCSS pour Tailwind
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction());

// Exporter la configuration
module.exports = Encore.getWebpackConfig();