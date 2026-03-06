import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    safelist: [
        'bg-blue-50',   'text-blue-600',
        'bg-green-50',  'text-green-600',
        'bg-purple-50', 'text-purple-600',
        'bg-amber-50',  'text-amber-600',
        'bg-cyan-50',   'text-cyan-600',
        'bg-rose-50',   'text-rose-600',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                display: ['Sora', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};