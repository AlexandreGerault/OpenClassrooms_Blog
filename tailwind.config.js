module.exports = {
    purge: [
        './resources/**/*.html.twig',
        './resources/**/*.js'
    ],
    darkMode: false,
    theme: {
        extend: {},
    },
    variants: {
        extend: {},
    },
    plugins: [
        require('@tailwindcss/typography'),
        require('@tailwindcss/forms')
    ],
}
