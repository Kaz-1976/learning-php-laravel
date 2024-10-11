import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    server: {
        host: true,
        hmr: {
            host: "localhost",
        },
    },
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/sass/app.scss",
                "resources/js/app.js",
            ],
            refresh: true,
        }),
    ],
});
