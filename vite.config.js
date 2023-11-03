import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        hmr: {
            host: 'localhost',
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/add_ingredient.js',
                'resources/js/add_procedure.js',
                'resources/js/deleteButton.js',
                'resources/js/delete_ingredient.js',
                'resources/js/delete_procedure.js',
            ],
            refresh: true,
        }),
    ],
});
