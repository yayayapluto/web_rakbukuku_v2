/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./resources/css/tailadmin/**/*.js", // Adjust the path based on where you placed TailAdmin
    ],
    theme: {
        extend: {
            fontFamily: {
                'urbanist': ['Urbanist', 'sans-serif'],
            },
            colors: {
                textColor: '#2D3033',
                butonColor: '#0060AE'
            },
        },
    },
    plugins: [],
};

