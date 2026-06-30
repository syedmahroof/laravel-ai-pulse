import { defineConfig } from 'vite';

export default defineConfig({
    build: {
        rollupOptions: {
            input: 'resources/css/pulse.css',
            output: {
                assetFileNames: 'css/pulse[extname]',
            },
        },
        outDir: 'dist',
        emptyOutDir: false,
        manifest: false,
    },
});
