import { defineConfig } from 'vite';

export default defineConfig({
    build: {
        rollupOptions: {
            input: 'resources/css/analyzer.css',
            output: {
                assetFileNames: 'css/analyzer[extname]',
            },
        },
        outDir: 'dist',
        emptyOutDir: false,
        manifest: false,
    },
});
