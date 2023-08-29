import colors from 'tailwindcss/colors'
import forms from '@tailwindcss/forms'
import typography from '@tailwindcss/typography'
import defaultTheme from 'tailwindcss/defaultTheme'

export default {
    content: [
        './resources/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Roboto', ...defaultTheme.fontFamily.sans],
                serif: ['Roboto', ...defaultTheme.fontFamily.serif],
                mono: ['Roboto', ...defaultTheme.fontFamily.mono],
            },
            colors: {
                danger: colors.rose,
                primary: colors.blue,
                success: colors.green,
                warning: colors.yellow,
            },
        },
    },
    plugins: [
        forms,
        typography
    ],
}
