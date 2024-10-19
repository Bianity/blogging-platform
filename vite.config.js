import { defineConfig } from "vite";
import laravel, { refreshPaths } from "laravel-vite-plugin";
export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/css/tagify.css",
                "resources/js/app.js",
                "resources/js/cropper.js",
                "resources/js/editor.js",
                "resources/js/tagify.js",
                "resources/css/filament/cp/theme.css",
            ],
            refresh: [
                ...refreshPaths,
                "app/Http/Livewire/**",
                "app/Forms/Components/**",
                "app/Tables/Columns/**",
            ],
        }),
        {
            name: "blade",
            handleHotUpdate({ file, server }) {
                if (file.endsWith(".blade.php")) {
                    server.ws.send({
                        type: "full-reload",
                        path: "*",
                    });
                }
            },
        },
    ],
    resolve: {
        alias: {
            "@": "/resources/js",
        },
    },
    css: {
        postCss: {
            plugins: [
                require("tailwindcss")({
                    config: "tailwind.config.js",
                }),
                require("autoprefixer"),
            ],
        },
    },
});
