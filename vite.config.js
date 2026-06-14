import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: {
                styles: 'resources/css/app.css',
                app: 'resources/js/app.js',
            },
            refresh: true,
        }),
        tailwindcss(),
    ],
});
