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
      ],
      refresh: true,
    }),
    tailwindcss(),
  ],
});
