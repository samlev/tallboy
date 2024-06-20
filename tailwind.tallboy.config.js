/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    // Handle dynamic class names in Blade components
    './src/View/**/*.php',
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}

