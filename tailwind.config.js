import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                "primary": {
                    default:"#FF6F61",
                    600:"#e15f53",
                    hover: "#E85C4F"
                },
                "secondary": "#A0E7E5",
                "support": "#FFF1E6",
                "successful": "#B8E986",

            }
        },
    },

    plugins: [forms],
};
