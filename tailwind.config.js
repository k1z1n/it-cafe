/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            boxShadow: {
                custom: '0 4px 12px 0 rgba(13, 35, 67, 0.08)'
            }
        },
    },
    plugins: [],
}

