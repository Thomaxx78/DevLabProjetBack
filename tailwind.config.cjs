/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./index.php",
    "./connexion.php",
    "./*.{js,jsx,tsx,php,html,css}",
  ],
  theme: {
    extend: {
      colors: {
        'violetwe': '#646ECB',
        'darkgrey': '#201f1f',
        'darklightgrey': '#8f8a8a',
        'semidarkgrey': '#413F3F',
        'lightgrey': '#BCBCBC',    
      },
      backgroundImage: {
        'coco': "src='public/Fade-In-Background.svg'",
        'footer-texture': "url('/img/footer-texture.png')",
      }}}
  // plugins: [],
}
