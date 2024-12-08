import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'selector',
    presets: [
        require('./vendor/wireui/wireui/tailwind.config.js')
    ],
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './vendor/wireui/wireui/resources/**/*.blade.php',
        './vendor/wireui/wireui/ts/**/*.ts',
        './vendor/wireui/wireui/src/View/**/*.php'
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    100: '#4B9B4A',
                    200: '#388E3C',
                    300: '#2B7B2E',
                    400: '#1D681F',
                    500: '#085309', // Cor principal
                    600: '#074208',
                    700: '#053006',
                    800: '#032004',
                    900: '#021502',
                    DEFAULT:'#085309BF'
                },
                /* secondary: {
                    100: '#FF8A50',
                    200: '#FF7043',
                    300: '#FF5722', // Cor principal
                    400: '#F4511E',
                    500: '#D84315',
                    600: '#BF360C',
                    700: '#E64A19',
                    800: '#D32F2F',
                    900: '#C2185B',
                    DEFAULT:'#FF5722'
                }, */
                accent: {
                    100: '#FF8A50',
                    200: '#FF7043',
                    300: '#FF5722', // Para o laranja como cor de destaque
                    400: '#F4511E',
                    500: '#D84315',
                    600: '#BF360C',
                    700: '#E64A19',
                    800: '#D32F2F',
                    900: '#C2185B',
                    DEFAULT:'#FF5722'
                },
            },
        },
    },

    plugins: [forms, typography],
};
