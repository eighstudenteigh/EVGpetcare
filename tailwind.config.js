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
            colors: {
             
               
               
                pantone3115: '#00A3E0', // Bright Teal
                pantone7541: '#D6D6D6', // Soft Gray
                pantone419: '#101820', // Deep Black
                orange500: '#E67700',  // Custom Orange (Header)
                gray700: '#4B5563',    // Dark Gray for cards
                gray600: '#6B7280',    // Medium Gray for appointment history
                gray500: '#9CA3AF',    // Soft Gray for pets section
              
                 primary: '#E67E22', // Pantone 1585 C (Warm Orange) use as button
                 secondary: '#F4A261', // Pantone 144 C (Lighter Orange)
                 
                 
   
                 darkGray: '#333333', // Pantone 419 C (Dark Gray for text)
                 softGray: '#E5E5E5', // Pantone 7541 C (Soft Gray for backgrounds)
                 mediumGray: '#B1B1B1', // Pantone Cool Gray 7 C (Medium Gray)
                 lightGray: '#D6D6D6', // Pantone Cool Gray 3 C (Light Gray)
                 footerGray: '#F2F2F2', // Footer background
 
         
                 white: '#FFFFFF', // For clean spacing
                 warmGray: '#ECE8E1',  // Light Warm Gray (Main BG)
                 lightBeige: '#F8F3EC', // Soft Beige Alternative
                 darkGray: '#3F4A5A',   // Dark Gray for Cards
            },
            fontFamily: {
                heading: ['Poppins', 'sans-serif'],
                body: ['Open Sans', 'sans-serif'],
            },
        },
    },

    plugins: [forms],
};
