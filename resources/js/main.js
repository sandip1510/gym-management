// resources/js/main.js
import "../css/app.css";
import { createApp } from "vue";
import { createPinia } from "pinia";
import router from "./router";
import App from "./App.vue";

const app = createApp(App);

// create Pinia and register it BEFORE using any stores or router
const pinia = createPinia();
app.use(pinia);

console.log('PINIA REGISTERED'); 

// register router after pinia
app.use(router);

app.mount("#app");
