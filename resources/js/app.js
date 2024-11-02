import _ from "lodash";
window._ = _;

import axios from "axios";
window.axios = axios;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

import Tooltip from "@ryangjchandler/alpine-tooltip";
import {
    Livewire,
    Alpine,
} from "../../vendor/livewire/livewire/dist/livewire.esm";
import intersect from "@alpinejs/intersect";
import Clipboard from "@ryangjchandler/alpine-clipboard";

Alpine.store("darkMode", {
    state: JSON.parse(localStorage.getItem("darkMode")),

    toggle() {
        this.state = !this.state;

        if (localStorage.getItem("darkMode") === "false") {
            this.state = true;
            document.documentElement.classList.add("dark");
            localStorage.setItem("darkMode", this.state);
        } else {
            this.state = false;
            document.documentElement.classList.remove("dark");
            localStorage.setItem("darkMode", this.state);
        }
    },
});

Alpine.plugin(Tooltip);
Alpine.plugin(Clipboard);
Alpine.plugin(intersect);
window.Alpine = Alpine;

Livewire.start();
