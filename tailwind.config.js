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
        'header': '#9b4d5c',
        'maroon': {
          100: '#f8e4ea',
          700: '#7c2a38',
          800: '#651f2e',
        }
      }
    },
  },
  plugins: [],
}

