import Vue from 'vue'
import VueRouter from 'vue-router'
import Principal from '../views/Home.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'principal',
    component: Principal
  },
  {
    path: '/registro',
    name: 'Registro',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "Registro"*/ '../views/Registro.vue')
  },
  {
    path: '/confirmar/:token',
    name: 'Confirmar',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "Confirmar"*/ '../views/Confirmar.vue')
  },
  {
    path: '/contrasena',
    name: 'Contrasena',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "Contrasena"*/ '../views/Contrasena.vue')
  },
  {
    path: '/recuperar/:token',
    name: 'Recuperar',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "Recuperar"*/ '../views/Recuperar.vue')
  },
  {
    path: '/estadisticas',
    name: 'Estadisticas',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "Estadisticas"*/ '../views/Estadisticas.vue')
  },
  {
    path: '/inicio',
    name: 'Inicio',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "Inicio"*/ '../views/Inicio.vue')
  },
  {
    path: '/inicio/resultados',
    name: 'Resultados',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "Resultados"*/ '../views/Resultados.vue')
  },
  {
    path: '/inicio/nuevoResultado',
    name: 'RegistrarResultados',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "RegistrarResultados"*/ '../views/RegistrarResultados.vue')
  },
  {
    path: '/inicio/modificarResultado/:id',
    name: 'ModificarResultados',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "ModificarResultados"*/ '../views/ModificarResultados.vue')
  },
  {
    path: '/inicio/validacion/:id',
    name: 'Validacion',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "Validacion"*/ '../views/Validacion.vue')
  },
  {
    path: '/inicio/valoracion/:id',
    name: 'Valoracion',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "Valoracion"*/ '../views/Valoracion.vue')
  },
  {
    path: '/inicio/usuario',
    name: 'usuario',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "Usuario"*/ '../views/Usuario.vue')
  },
  { path: '*', redirect: '/'}

]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
