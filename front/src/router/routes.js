import indexPage from "pages/IndexPage";
import Login from "pages/Login";
import User from "pages/User";
import Predilecta from "pages/Predilecta";
import Votacion from "pages/Votacion";

const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '', component: indexPage ,meta: {requiresAuth: true}},
      { path: 'user', component: User ,meta: {requiresAuth: true}},
      { path: 'predilecta', component: Predilecta ,meta: {requiresAuth: true}},
      { path: 'votacion', component: Votacion ,meta: {requiresAuth: true}},
    ]
  },
  {
    path: '/login',
    component: Login
  },
  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue')
  }
]

export default routes
