/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./index.php",
    "./*.{js,jsx,tsx,php,html,css}",
  ],
  theme: {
    extend: {
      colors:{
        'darkgrey': '#201F1F',
        'semidarkgrey': '#413F3F',
        'lightgrey': '#BCBCBC',      
      },
    },
  },
  plugins: [],
}
