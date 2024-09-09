/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './*.php',
    './template-parts/**/*.php',
    './**/*.js'
  ],
  theme: {
    extend: {
      colors: {
        primary: '#1D4ED8',
        secondary: '#1E40AF',
      },
    },
  },
  plugins: [
    require('@tailwindcss/typography'),
  ],
};
