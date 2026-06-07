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
                display: ['"Plus Jakarta Sans"', 'Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Corporate navy/blue palette
                'navy': {
                    50: '#F0F4FA',
                    100: '#E1E9F5',
                    200: '#C3D2EA',
                    300: '#92B0D8',
                    400: '#5C82BB',
                    500: '#3B5F9C',
                    600: '#2A4980',
                    700: '#1E3A66',
                    800: '#0B2447',
                    900: '#061732',
                    950: '#030D1F',
                },
                'brand': {
                    50: '#EFF6FF',
                    100: '#DBEAFE',
                    200: '#BFDBFE',
                    300: '#93C5FD',
                    400: '#60A5FA',
                    500: '#3B82F6',
                    600: '#2563EB',
                    700: '#1D4ED8',
                    800: '#1E40AF',
                    900: '#1E3A8A',
                },
                'slate': {
                    50: '#F8FAFC',
                    100: '#F1F5F9',
                    200: '#E2E8F0',
                    300: '#CBD5E1',
                    400: '#94A3B8',
                    500: '#64748B',
                    600: '#475569',
                    700: '#334155',
                    800: '#1E293B',
                    900: '#0F172A',
                },
                'accent': {
                    50: '#FFF7ED',
                    100: '#FFEDD5',
                    200: '#FED7AA',
                    300: '#FDBA74',
                    400: '#FB923C',
                    500: '#F97316',
                    600: '#EA580C',
                    700: '#C2410C',
                    800: '#9A3412',
                    900: '#7C2D12',
                },
                'success': {
                    50: '#F0FDF4',
                    500: '#10B981',
                    600: '#059669',
                    700: '#047857',
                },
                'danger': {
                    50: '#FEF2F2',
                    500: '#EF4444',
                    600: '#DC2626',
                    700: '#B91C1C',
                },
            },
            backgroundImage: {
                'hero-gradient': 'linear-gradient(135deg, #0B2447 0%, #1E40AF 100%)',
                'navy-gradient': 'linear-gradient(180deg, #0B2447 0%, #061732 100%)',
                'subtle-gradient': 'linear-gradient(180deg, #F8FAFC 0%, #F1F5F9 100%)',
                'card-gradient': 'linear-gradient(135deg, #FFFFFF 0%, #F8FAFC 100%)',
                'mesh-gradient': 'radial-gradient(at 0% 0%, rgba(59, 130, 246, 0.15) 0px, transparent 50%), radial-gradient(at 100% 100%, rgba(30, 64, 175, 0.10) 0px, transparent 50%)',
            },
            boxShadow: {
                'soft': '0 2px 8px 0 rgb(15 23 42 / 0.04), 0 1px 2px -1px rgb(15 23 42 / 0.04)',
                'card': '0 1px 3px 0 rgb(15 23 42 / 0.06), 0 1px 2px -1px rgb(15 23 42 / 0.04)',
                'card-hover': '0 10px 25px -5px rgb(15 23 42 / 0.10), 0 8px 10px -6px rgb(15 23 42 / 0.04)',
                'navy': '0 10px 30px -10px rgba(11, 36, 71, 0.3)',
                'inner-border': 'inset 0 0 0 1px rgb(15 23 42 / 0.05)',
            },
            borderRadius: {
                'card': '14px',
                'pill': '9999px',
            },
            fontSize: {
                'display-2xl': ['4.5rem', { lineHeight: '1.05', letterSpacing: '-0.03em', fontWeight: '700' }],
                'display-xl': ['3.75rem', { lineHeight: '1.1', letterSpacing: '-0.025em', fontWeight: '700' }],
                'display-lg': ['3rem', { lineHeight: '1.15', letterSpacing: '-0.02em', fontWeight: '700' }],
                'display': ['2.25rem', { lineHeight: '1.2', letterSpacing: '-0.015em', fontWeight: '600' }],
            },
        },
    },

    plugins: [forms],
};
