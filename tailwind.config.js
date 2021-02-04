module.exports = {
    purge: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
      ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
        backgroundImage: {
            'hero-lg': "url('/images/template1.png')",
        },
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
