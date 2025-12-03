import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/js/app.js',

        // Additional tracked files
        'resources/css/ecoModal.css',
        'resources/js/ecoModal.js',
      ],
      refresh: true,
    }),
    tailwindcss(),
  ],

  // Optional server config
  // server: {
  //   host: '0.0.0.0',
  //   port: 5173,
  //   hmr: {
  //     host: '192.168.174.41',
  //   },
  // },
})
