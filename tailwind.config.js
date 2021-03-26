/*
 * After modifying this run `sail npm run dev`
 */
const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

module.exports = {
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                green: colors.lime,
                primary: colors.lime,
                secondary: colors.orange,
                accent1: colors.teal,
                accent2: colors.pink,
            },
            listStyleType: {
                none: 'none',
                disc: 'disc',
                square: 'square',
                decimal: 'decimal',
                alpha: 'upper-alpha',
                roman: 'upper-roman',
            },
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [require('@tailwindcss/forms')],
};

