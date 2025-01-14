//import vue router
import { createRouter, createWebHistory } from "vue-router";

//define a routes
const routes = [
  {
    path: "/",
    name: "home",
    component: () => import(/* webpackChunkName: "home" */ "../views/home.vue"),
  },
  {
    path: "/admins",
    name: "admins.index",
    component: () => import(/* webpackChunkName: "index" */ "../views/admins/index.vue"),
  },
  {
    path: "/admins/package",
    name: "admins.package",
    component: () => import(/* webpackChunkName: "create" */ "../views/admins/package.vue"),
  },
  {
    path: "/reservations/packagedetail/:id",
    name: "reservations.packagedetail",
    component: () => import("../views/reservations/packagedetail.vue"),
  },
  {
    path: "/admins/reservation",
    name: "admins.reservation",
    component: () => import( "../views/admins/reservation.vue"),
  },
];
//create router
const router = createRouter({
  history: createWebHistory(),
  routes, // <-- routes,
});
export default router;