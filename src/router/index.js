import { createRouter, createWebHashHistory } from "vue-router";

import Home from "../views/Home.vue";
import PhotoUploader from "../views/PhotoUploader.vue";
import Viewer from "../views/Viewer.vue";


const routes = [
    {
        path: "/",
        name: "Home",
        component: Home,
    }, {
        path: "/photo",
        name: "PhotoUploader",
        component: PhotoUploader,
    }, {
        path: "/viewer",
        name: "Viewer",
        component: Viewer,
    },

];

const router = createRouter({
    history: createWebHashHistory(),
    routes,
});


export default router;
