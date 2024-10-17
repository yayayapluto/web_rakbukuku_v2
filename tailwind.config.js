/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./resources/css/tailadmin/**/*.js", // Adjust the path based on where you placed TailAdmin
    ],
    theme: {
        extend: {},
    },
    plugins: [],
};

