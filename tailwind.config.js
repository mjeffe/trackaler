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
                // primary: defaultTheme.colors.green,
                primary: colors.lime,
                secondary: colors.orange,
                accent1: colors.pink,
                accent2: colors.teal,

                /* lightest:  https://coolors.co/fecbb8-c4ded2-e2b2b2-e8f2e5-dec3ce */
                /* light:  https://coolors.co/fd9f7d-92c3ac-ca7373-d4e7cf-c291a4 */
                /* DEFAULT: https://coolors.co/fb5012-498467-732c2c-b2d3a8-80475e */
                /* dark: https://coolors.co/a02c02-2b4f3e-451a1a-5d974c-4d2a38 */

                // red-orange-color-wheel
                accent1: {
                    lightest: '#fecbb8ff',
                    light: '#fd9f7dff',
                    DEFAULT: '#fb5012ff',
                    dark: '#a02c02ff',
                },
                // viridian
                primary: {
                    lightest: '#c4ded2ff',
                    light: '#92c3acff',
                    DEFAULT: '#498467ff',
                    dark: '#2b4f3eff',
                },
                // wine
                secondary: {
                    lightest: '#e2b2b2ff',
                    light: '#ca7373ff',
                    DEFAULT: '#732c2cff',
                    dark: '#451a1aff',
                },
                // celadon
                tertiary: {
                    lightest: '#e8f2e5ff',
                    light: '#d4e7cfff',
                    DEFAULT: '#b2d3a8ff',
                    dark: '#5d974cff',
                },
                // twilight-lavender
                accent2: {
                    lightest: '#dec3ceff',
                    light: '#c291a4ff',
                    DEFAULT: '#80475eff',
                    dark: '#4d2a38ff',
                },
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

