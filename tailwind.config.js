const defaultTheme = require("tailwindcss/defaultTheme");
const plugin = require("tailwindcss/plugin");
const colors = require("tailwindcss/colors");
import preset from "./vendor/filament/support/tailwind.config.preset";
module.exports = {
    darkMode: "class",
    // presets: [preset],
    corePlugins: {
        preflight: false,
    },
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./vendor/wireui/wireui/resources/**/*.blade.php",
        "./vendor/wireui/wireui/ts/**/*.ts",
        "./vendor/wireui/wireui/src/View/**/*.php",
        // "./app/Filament/**/*.php",
        // "./resources/views/filament/**/*.blade.php",
        // "./vendor/filament/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Nunito", ...defaultTheme.fontFamily.sans],
            },
            fontSize: {
                title: ["22px", "30px"],
                title2: ["32px", "40px"],
            },
            colors: {
                primary: colors.yellow,
                primary_light: "#fff2e0",
                primary_darker: "#f2e8d6",
                unfollow: "#f4212f",
                primary_black: "#14191f",
                secondary: colors.slate,
                gray: colors.slate,
                orange: colors.orange,
                positive: colors.emerald,
                warning: colors.amber,
                negative: colors.red,
                info: colors.sky,
            },
            height: {
                128: "32rem",
            },
            boxShadow: {
                card: "4px 4px 15px 0 rgba(36,37,38, 0.08)",
                dialog: "0px 4px 22px rgba(0, 0, 0, 6%)",
                popup: "0px 5px 15px 0px rgba(0, 0, 0, 0.15)",
            },
            width: {
                640: "40rem",
            },
            maxHeight: {
                450: "28rem",
                600: "37.5rem",
            },
            maxWidth: {
                "8xl": "88rem",
                theme: "60rem",
            },
            screens: {
                xs: "475px",
                md2: "859px",
            },
            gridTemplateColumns: {
                header: "240px minmax(0, 660px) minmax(140px, 323px)",
                main: "240px 2fr 1fr",
                "main-md": "2fr 5fr",
            },
        },
    },

    plugins: [
        // eslint-disable-next-line global-require
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
        require("@tailwindcss/aspect-ratio"),
        // add custom variant for expanding sidebar
        plugin(({ addVariant, e }) => {
            addVariant("sidebar-expanded", ({ modifySelectors, separator }) => {
                modifySelectors(
                    ({ className }) =>
                        `.sidebar-expanded .${e(
                            `sidebar-expanded${separator}${className}`
                        )}`
                );
            });
        }),
    ],
};
