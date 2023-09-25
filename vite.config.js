import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/add_ingredient.js',
                'resources/js/add_procedure.js',
                'resources/js/deleteRecipe.js',
            ],
            refresh: true,
        }),
    ],
});
