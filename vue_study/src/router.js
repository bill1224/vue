import Vue from "vue";
import VueRouter from "vue-router";
// import Home from "./views/Home";
import About from "./views/About";
import Read from "./components/Read";
import Create from "./components/Create";

Vue.use(VueRouter);

const router = new VueRouter({
    mode: "history",
    routes: [
        // { 
        //     path:"/",
        //     component: Home
        // },
        {
            path:"/about",
            component: About
        },
        {
            path: "/",
            name: "Read",
            component: Read
        },
        {
            path: "/create",
            name: "Create",
            component: Create
        },
    ]

});

export default router;