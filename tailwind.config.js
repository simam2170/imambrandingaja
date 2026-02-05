export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
  ],
  theme: {
    extend: {
      colors: {
        primary: '#02B0AF',   // MAIN COLOR
        secondary: '#02b0b081', // Mapped to Primary for consistency
        accent: '#f0a700',    // Mapped to Primary for consistency
        dark: '#404145',      // Neutral Dark Text
        light: '#f7f7f7',     // Neutral Light Bg
      },
      fontFamily: {
        sans: ['Inter', 'sans-serif'], // Professional font if available, fallback to sans
      }
    },
  },
  plugins: [],
}
