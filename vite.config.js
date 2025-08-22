// vite.config.js
import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
      // Opcional: buildDirectory: 'build', // por defecto ya es 'build'
    }),
  ],
  server: {
    host: true,
    // hmr: { host: 'nuevaera.test' }, // si usas Laragon con dominio local
  },
})
