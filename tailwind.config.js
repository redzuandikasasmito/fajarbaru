/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    extend: {
      colors: {
        'primary': '#23486A',
        'secondary': '#F0A04B',
      },
    },
  },
  plugins: [
    require('daisyui'),
  ],
}

