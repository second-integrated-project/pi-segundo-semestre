import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/componentes/nav.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
