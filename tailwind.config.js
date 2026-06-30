/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/views/**/*.blade.php',
    ],
    darkMode: 'class',
    theme: {
        extend: {
            colors: {
                // Brand "signal" palette (teal). Token kept as `orbit` for class compatibility.
                orbit: {
                    50: '#f0fdfa',
                    100: '#ccfbf1',
                    200: '#99f6e4',
                    300: '#5eead4',
                    400: '#2dd4bf',
                    500: '#14b8a6',
                    600: '#0d9488',
                    700: '#0f766e',
                    800: '#115e59',
                    900: '#134e4a',
                    950: '#042f2e',
                },
            },
            fontFamily: {
                sans: ['Inter', 'system-ui', 'sans-serif'],
                display: ['"Space Grotesk"', 'Inter', 'sans-serif'],
                mono: ['"JetBrains Mono"', 'ui-monospace', 'monospace'],
            },
            backgroundImage: {
                'orbit-gradient': 'linear-gradient(135deg, #14b8a6, #06b6d4)',
                'orbit-gradient-hover': 'linear-gradient(135deg, #0d9488, #0891b2)',
            },
            boxShadow: {
                'glass': '0 1px 3px rgba(0, 0, 0, 0.04)',
                'glass-dark': '0 1px 3px rgba(0, 0, 0, 0.2)',
                'glow-indigo': '0 0 20px rgba(20, 184, 166, 0.18)',
                'glow-emerald': '0 0 20px rgba(16, 185, 129, 0.15)',
                'glow-purple': '0 0 20px rgba(139, 92, 246, 0.15)',
                'glow-amber': '0 0 20px rgba(245, 158, 11, 0.15)',
            },
            backdropBlur: {
                'glass': '12px',
                'glass-lg': '20px',
            },
        },
    },
    plugins: [],
};
