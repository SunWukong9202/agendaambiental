import preset from './vendor/filament/support/tailwind.config.preset'

/** @type {import('tailwindcss').Config} */
export default {
  presets: [preset],
  darkMode: 'class',
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/flowbite/**/*.js",
    './app/Filament/**/*.php',
    './resources/views/filament/**/*.blade.php',
    './vendor/filament/**/*.blade.php',
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './vendor/jaocero/activity-timeline/resources/views/**/*.blade.php',
  ],
  theme: {
    extend: {
      fontFamily: {
        roboto: ['Roboto', 'sans-serif'],
      },
      colors: {
        marine: {
          DEFAULT: '#1A3156',
          '50': '#eff8ff',
          '100': '#dceffd',
          '200': '#c1e4fc',
          '300': '#96d4fa',
          '400': '#65bbf5',
          '500': '#419ef0',
          '600': '#2b82e5',
          '700': '#236cd2',
          '800': '#2257ab',
          '900': '#214c87',
          '950': '#1a3156',
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
    require('flowbite/plugin'),
    require('tailwindcss-rtl'), 
  ],
}

