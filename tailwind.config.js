/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/flowbite/**/*.js",
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
  ],
  theme: {
    extend: {
      colors: {
        marine: {
          DEFAULT: '#1A3156',
          50: '#bac1cc',
          100: '#8d98ab',
          200: '#5f6f89',
          300: '#314667',
          900: '#080f1a',
          800: '#0d192b',
          700: '#101d34',
          600: '#12223c',
          500: '#152745',
          400: '#172c4d',
        },
        'gold': {
          DEFAULT: '#BDA465',
          '50': '#f8f6ee',
          '100': '#ede9d4',
          '200': '#dcd2ac',
          '300': '#c8b67c',
          '400': '#bda465',
          '500': '#a8894a',
          '600': '#906f3e',
          '700': '#745534',
          '800': '#624731',
          '900': '#553d2e',
          '950': '#312017'},
      }
    },
  },
  plugins: [
    require('flowbite/plugin')
  ],
}

