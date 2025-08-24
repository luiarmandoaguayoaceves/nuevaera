import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
  server: {
    host: true,                 // escucha en LAN/WSL/Docker
    strictPort: true,
    port: 5173,
    cors: true,
    hmr: {
      host: 'nuevaera.test',    // 👈 tu dominio local
      protocol: 'ws',           // si usas `valet secure`, cambia a 'wss'
      port: 5173
    },
  },
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
  ],
})
