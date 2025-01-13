import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  build: {
    outDir: 'dist', // Esto asegura que los archivos construidos se guardan en "dist"
  },
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'], // Incluye tus archivos
      refresh: true,
    }),
  ],
});
