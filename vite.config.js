import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],


    //DESAHABILITAR ESTO SI NO QUIERES SERVIR LA APP EN TU RED
    // server: {
    //     host: '192.168.100.66', // Permite que Vite escuche en todas las interfaces de red
    //     port: 5000, // Puedes cambiar el puerto si lo deseas
    //     hmr: {
    //         host: '192.168.100.66',//'your_local_ip_address', // Reemplaza esto con tu dirección IP local
    //         port: 5000,
    //     },
    // },
});
