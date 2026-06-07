import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Minimalist color palette
                'stone': {
                    50: '#FAFAF9',
                    100: '#F5F5F4',
                    150: '#F0EFED',
                    200: '#E7E5E4',
                    300: '#D6D3D1',
                    400: '#A8A29E',
                    500: '#78716C',
                    600: '#57534E',
                    700: '#44403C',
                    800: '#292524',
                    900: '#1C1917',
                },
                'slate': {
                    50: '#F8FAFC',
                    100: '#F1F5F9',
                    150: '#E8EDF3',
                    200: '#CBD5E1',
                    300: '#94A3B8',
                    400: '#64748B',
                    500: '#475569',
                    600: '#334155',
                    700: '#1E293B',
                    800: '#0F172A',
                    900: '#020617',
                },
                // Accent colors for minimalist design
                'ink': '#1A1A1A',
                'graphite': '#374151',
                'silver': '#6B7280',
                'mist': '#9CA3AF',
                'pearl': '#E5E7EB',
                'cloud': '#F3F4F6',
                'snow': '#F9FAFB',
                'accent': {
                    50: '#F0FDF4',
                    100: '#DCFCE7',
                    200: '#BBF7D0',
                    300: '#86EFAC',
                  400: '#4ADE80',
                  500: '#22C55E',
                  600: '#16A34A',
                  700: '#15803D',
                  800: '#166534',
                  900: '#14532D',
                },
            },
            backgroundImage: {
                'minimal-gradient': 'linear-gradient(135deg, #1A1A1A 0%, #374151 100%)',
                'subtle-gradient': 'linear-gradient(135deg, #F9FAFB 0%, #F3F4F6 100%)',
            },
            boxShadow: {
                'minimal': '0 1px 3px 0 rgb(0 0 0 / 0.05), 0 1px 2px -1px rgb(0 0 0 / 0.05)',
                'minimal-lg': '0 4px 6px -1px rgb(0 0 0 / 0.05), 0 2px 4px -2px rgb(0 0 0 / 0.05)',
                'minimal-xl': '0 10px 15px -3px rgb(0 0 0 / 0.05), 0 4px 6px -4px rgb(0 0 0 / 0.05)',
                'card': '0 0 0 1px rgba(0, 0, 0, 0.03), 0 2px 4px rgba(0, 0, 0, 0.05)',
                'card-hover': '0 0 0 1px rgba(0, 0, 0, 0.06), 0 4px 8px rgba(0, 0, 0, 0.08)',
            },
            borderRadius: {
                'minimal': '8px',
                'card': '12px',
            },
        },
    },

    plugins: [forms],
};