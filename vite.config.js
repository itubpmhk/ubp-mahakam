import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/site.css',
        'resources/js/site.js',
        'resources/css/admin.css',
        'resources/js/admin.js',
      ],
      refresh: true,
    }),
  ],
  build: {
    sourcemap: false,            // never ship the original source
    target: 'es2018',
    chunkSizeWarningLimit: 800,
    rollupOptions: {
      output: {
        // third-party code in separate cached "vendor" chunks; our own code is obfuscated after the build
        manualChunks(id) {
          if (id.includes('node_modules/three')) return 'vendor-three';
          if (id.includes('node_modules')) return 'vendor';
        },
      },
    },
  },
  esbuild: {
    drop: ['console', 'debugger'],
    legalComments: 'eof',
  },
});
