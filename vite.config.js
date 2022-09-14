import reactRefresh from '@vitejs/plugin-react-refresh';
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel([
            'resources/css/app.css', 
            'resources/js/App.jsx',
        ],
        reactRefresh(),
        ),
    ],
});

// export default ({ command }) => ({
//     base: command === 'serve' ? '' : '/build/',
//     publicDir: 'fake_dir_so_nothing_gets_copied',
//     build: {
//         manifest: true,
//         outDir: 'public/build',
//         rollupOptions: {
//             input: 
//         },
//     },
//     plugins: [
        
//     ],
// });