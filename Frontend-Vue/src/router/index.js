import { createRouter, createWebHistory } from "vue-router";
import Home from "../pages/Home.vue";

import { useAuthStore } from "../store/auth.store";
import LoginPage from "../pages/LoginPage.vue";
import RegisPage from "../pages/RegisPage.vue";
import ProfilePage from "../pages/ProfilePage.vue";

const routes = [
  { path: "/", name: "home", component: Home },
  { path: "/login", name: "login", component: LoginPage, meta: { guestOnly: true } },
  { path: "/register", name: "register", component: RegisPage, meta: { guestOnly: true } },
  { path: "/profile", name: "profile", component: ProfilePage, meta: { requiresAuth: true } },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// Guard
let bootstrapped = false;
router.beforeEach(async (to) => {
  const auth = useAuthStore();
  if (!bootstrapped) {
    await auth.init(); // coba restore session
    bootstrapped = true;
  }

  if (to.meta.requiresAuth && !auth.isAuthenticated) {
    return { name: "login", query: { redirect: to.fullPath } };
  }
  if (to.meta.guestOnly && auth.isAuthenticated) {
    return { name: "profile" };
  }
});

export default router;
