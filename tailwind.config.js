/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        // Aquí puedes definir los colores de tu marca "Nueva Era"
        brand: {
          primary: '#e11d48', // Un rojo rose-600
          dark: '#111827',
        }
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'), // Muy importante para que los formularios se vean bien
  ],
}