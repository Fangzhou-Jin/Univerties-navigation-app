import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: [
                'resources/views/**',  // 监听所有视图文件
                'app/**',
                'routes/**',
            ],
        }),
        tailwindcss(),
    ],
    server: {
        host: '0.0.0.0',  // 允许外部访问
        port: 5173,
        hmr: {
            host: 'localhost',
        },
        watch: {
            usePolling: true,  // Docker 环境下需要轮询
        },
    },
});
