import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/login.css',
        'resources/js/login.js',
        'resources/css/app.css',
        'resources/css/permissionError.css',
        'resources/js/owner.js',
        'resources/js/addApartment.js',
        'resources/css/ownerImage.css',
        'resources/css/apartmentImage.css',
        'resources/js/apartmentDetail.js',
        'resources/css/apartmentDetail.css',
        'resources/js/contractExtension.js',
        'resources/js/customer.js',
        'resources/js/addCustomer.js',
        'resources/css/customer.css',
      ],
      refresh: true,
    }),
    tailwindcss(),
  ],
});
