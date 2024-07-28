import axios from "axios";
import Alpine from "alpinejs";

// window.addEventListener("DOMContentLoaded", loaderFunc);

// function loaderFunc() {
//     document.getElementById("loader").style.display = "block";
//     setTimeout(() => {
//         document.getElementById("loader").style.display = "none";
//     }, 100);
// }

window.axios = axios;
window.Alpine = Alpine;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

Alpine.data("global", () => ({
    sites: {
        show_sidebar: true,
    },
    toggleSidebar: function () {
        this.sites.show_sidebar = !this.sites.show_sidebar;
        const main = document.getElementById("main");

        if (this.sites.show_sidebar) {
            main.classList.remove("lg:ml-0");
            main.classList.add("lg:ml-64");

            return;
        }

        main.classList.remove("lg:ml-64");
        main.classList.add("lg:ml-0");
    },
}));

Alpine.start();
