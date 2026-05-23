import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            // Point the plugin to the project root which now acts as the public directory for built assets
            publicDirectory: '.',
            buildDirectory: 'build',
            hotFile: 'hot',
        }),
    ],
    build: {
        outDir: 'build',
        emptyOutDir: true,
        // Ensure Laravel finds the manifest at build/manifest.json (not the Vite 5 default .vite/manifest.json)
        manifest: 'manifest.json',
    },
    base: './',
});
