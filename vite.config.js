import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

const cssFiles = [
    'resources/css/common.css',
];

const jsFiles = [
    'resources/js/common.js',
    'resources/js/nocache.js',
    'resources/js/lib/jquery-validation/additional-setting.js',
    'resources/js/screens/auth/login.js',
    'resources/js/screens/user/userList.js',
];

export default defineConfig({
    plugins: [
        laravel({
            input: [
                ...cssFiles,
                ...jsFiles,
            ],
            refresh: true,
        }),
    ],
});
