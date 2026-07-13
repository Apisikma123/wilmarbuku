import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    darkMode: "class",
    theme: {
        extend: {
            fontFamily: {
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
                headline: ["Poppins"],
                display: ["Poppins"],
                body: ["Poppins"],
                label: ["Poppins"],
            },
            colors: {
                "on-tertiary": "#ffffff", "tertiary-fixed-dim": "#69d9c0", "surface-bright": "#f8f9ff", 
                "outline-variant": "#c0c9be", "on-secondary-fixed": "#271900", "on-surface": "#121c29", 
                "surface-dim": "#d0dbed", primary: "#003215", "on-tertiary-fixed-variant": "#005143", 
                "tertiary-fixed": "#87f6dc", "on-primary-fixed-variant": "#0b5229", "inverse-surface": "#27313f", 
                "error-container": "#ffdad6", error: "#ba1a1a", "primary-fixed": "#aef2bb", surface: "#f8f9ff", 
                "on-surface-variant": "#404941", "on-secondary-container": "#715000", "surface-tint": "#2a6a3f", 
                "surface-container-low": "#eff4ff", "surface-container": "#e6eeff", outline: "#707970", 
                "tertiary-container": "#00493d", "secondary-container": "#fdc34d", "on-primary-container": "#79bb87", 
                "surface-container-highest": "#d9e3f6", "on-error": "#ffffff", "secondary-fixed-dim": "#f7bd48", 
                "on-background": "#121c29", "surface-container-high": "#dfe9fb", "surface-container-lowest": "#ffffff", 
                background: "#f8f9ff", secondary: "#7b5800", "on-primary-fixed": "#00210c", "surface-variant": "#d9e3f6", 
                "on-tertiary-container": "#4bbea5", "on-secondary-fixed-variant": "#5d4200", "primary-container": "#004b23", 
                "on-primary": "#ffffff", tertiary: "#003128", "primary-fixed-dim": "#93d6a0", "on-error-container": "#93000a", 
                "inverse-primary": "#93d6a0", "secondary-fixed": "#ffdea6", "on-secondary": "#ffffff", 
                "inverse-on-surface": "#eaf1ff", "on-tertiary-fixed": "#00201a"
            },
            borderRadius: {DEFAULT: "0.5rem", lg: "1rem", xl: "1.5rem", full: "9999px"},
        },
    },

    plugins: [forms, require('@tailwindcss/container-queries')],
};
