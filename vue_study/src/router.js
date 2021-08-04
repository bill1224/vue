import Vue from "vue";
import VueRouter from "vue-router";
// import Home from "./views/Home";
import About from "./views/About";
import Read from "./components/Read";
import Create from "./components/Create";
// import Update from "./components/Update";
import Detail from "./components/Detail";

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
            // params뒤에 ?를 붙혀주지 않으면,
            // 수정하는 경우가 아닐때엔 contentId가 없기 때문에 컴포넌트를 불러오지 못한다.
            // 하지만 ?를 붙힘으로써 파라미터가 없어도 불러올 수 있게 된다. 
            path: "/create/:contentId?",
            name: "Create",
            component: Create
        },
        {
            path: "/detail/:contentId",
            name: "Detail",
            component: Detail
        },

    ]

});

export default router;