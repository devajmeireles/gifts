import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    presets: [
        require('./vendor/wireui/wireui/tailwind.config.js')
    ],

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './vendor/wireui/wireui/resources/**/*.blade.php',
        './vendor/wireui/wireui/ts/**/*.ts',
        './vendor/wireui/wireui/src/View/**/*.php'
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Noto Sans', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                current: 'currentColor',
                'primary': {
                    DEFAULT: '#e63f66',
                    50: '#fef2f4',
                    100: '#fde6e9',
                    200: '#fbd0d9',
                    300: '#f7aab9',
                    400: '#f27a93',
                    500: '#e63f66',
                    600: '#d42a5b',
                    700: '#b21e4b',
                    800: '#951c45',
                    900: '#801b40',
                },
            },
        },
    },

    plugins: [forms],
};
