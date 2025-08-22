/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
    './resources/**/*.vue', // si usas Vue/React, agrega las extensiones
  ],
  theme: { extend: {} },
  plugins: [],
}
