const defaultTheme = require('tailwindcss/defaultTheme');

const colors = require('tailwindcss/colors');

module.exports = {
  mode: 'jit',
  purge: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  darkMode: false, // Opciones: 'media', 'class', false
  theme: {
    extend: {
      colors: {
          'monsa-blue': '#0C41FA',
          'monsa-yellow': '#FFC006',
          'monsa-dark-light': '#333333',
          'monsa-dark': '#101415',
          orange: colors.orange,
          gray: {
            light: '#f0f4f7',
            lightfa: '#fafafa',
          },
          dark: {
            default: '#263238',
            light: '#324144',
            800: '#202b30',
          },
          black: {
            '000': '#000',
            '333': '#333',
            '666': '#666',
          },
          primary: {
            100: '#3899ec',
            300: '#64B5F6',
            400: '#42A5F5',
            500: '#2196F3',
            600: '#1E88E5',
            700: '#1976D2',
            800: '#1565C0',
          },   
          secondary: {
            300: '#9575CD',
            400: '#7E57C2',
            500: '#673AB7',
            600: '#5E35B1',
            700: '#512DA8',
            800: '#4527A0',
          },
          warning: {
            400: '#FF7043',
            500: '#FF5722',
            700: '#ec683e',
          },   
          'warm-gray': colors.warmGray,
          teal: colors.teal,                
      },
      fontSize: {
        tiny: '.8125rem',
      },   
      animation: {
        marquee: 'marquee 25s linear infinite',
        marquee2: 'marquee2 25s linear infinite',
        marqueeright: 'marqueeright 25s linear infinite',
        marquee2right: 'marquee2right 25s linear infinite',
      },
      keyframes: {
        marquee: {
          '0%': { transform: 'translateX(0%)' },
          '100%': { transform: 'translateX(-100%)' },
        },
        marquee2: {
          '0%': { transform: 'translateX(100%)' },
          '100%': { transform: 'translateX(0%)' },
        },
        marqueeright: {
          '0%': { transform: 'translateX(-100%)' },
          '100%': { transform: 'translateX(0%)' },
        },
        marquee2right: {
          '0%': { transform: 'translateX(0%)' },
          '100%': { transform: 'translateX(100%)' },
        },
      },      
    },
  },
  variants: {
    extend: {
        opacity: ['disabled'],
        backgroundColor: ['active'], // Asegúrate de que 'active' está habilitado para backgroundColor

    },
  },

  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/aspect-ratio'),
  ],
}

