const colors = require('tailwindcss/colors')
import defaultTheme from 'tailwindcss/defaultTheme'


module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js"
    ],
    theme: {
        extend: {
            colors: {
                primary: colors.slate
                // primary: {
                //     '50': '#f7f7f7',
                //     '100': '#e6e6e6',
                //     '200': '#dfdfdf',
                //     '300': '#c8c8c8',
                //     '400': '#adadad',
                //     '500': '#999999',
                //     '600': '#888888',
                //     '700': '#7b7b7b',
                //     '800': '#676767',
                //     '900': '#545454',
                //     '950': '#363636',
                // },
            },
            fontFamily: {
                'sans': ['"Nunito"', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [
        require('flowbite/plugin')
    ],
}