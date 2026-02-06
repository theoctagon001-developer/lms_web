import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from 'tailwindcss';
import os from 'os';
function getLocalNetworkIP() {
    const interfaces = os.networkInterfaces();
    for (const name in interfaces) {
        for (const iface of interfaces[name]) {
            if (iface.family === 'IPv4' && !iface.internal) {
                return iface.address;
            }
        }
    }
    return '127.0.0.1';
}

const localIP = getLocalNetworkIP();



export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: localIP,
        port: 5173,
        strictPort: true,
        hmr: {
            host: localIP,
        },
    },
    css: {
        postcss: {
            plugins: [tailwindcss()],
        },
    },
});






// import { defineConfig } from 'vite';
// import laravel from 'laravel-vite-plugin';
// import tailwindcss from 'tailwindcss';
// export default defineConfig({
//     plugins: [
//         laravel({
//             input: ['resources/css/app.css', 'resources/js/app.js'],
//             refresh: true,
//         }),
//     ],server: {
//         host: '192.168.0.110', 
//         port: 5173, 
//         strictPort: true,
//         hmr: false,
//     },
//     css: {
//         postcss: {
//           plugins: [tailwindcss()],
//         },
//     }
// });
