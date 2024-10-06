require("./bootstrap");

import Alpine from "alpinejs";
import "@fortawesome/fontawesome-free/js/all.js";
import { createApp } from "vue";

window.Alpine = Alpine;
Alpine.start();

// Create a Vue app
const app = createApp({});

// Register your Post component globally
app.component("post", require("./components/Post.vue").default);

// Mount the Vue app
app.mount("#app");
