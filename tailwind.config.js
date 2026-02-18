export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          DEFAULT: '#02B0AF',
          50: '#e0f6f6',
          100: '#b3e9e8',
          200: '#80dbd9',
          300: '#4dcdca',
          400: '#26c1bd',
          500: '#02B0AF', // MAIN COLOR
          600: '#029695',
          700: '#027b7b',
          800: '#016161',
          900: '#014646',
        },
        accent: {
          DEFAULT: '#f0a700',
          50: '#fff8e1',
          100: '#ffefb6',
          200: '#ffe08a',
          300: '#ffd15e',
          400: '#ffc232',
          500: '#f0a700', // MAIN COLOR
          600: '#cc8a00',
          700: '#a86e00',
          800: '#845200',
          900: '#603600',
        },
        secondary: '#02b0b081', // Mapped to Primary for consistency
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
