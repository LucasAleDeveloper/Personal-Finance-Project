
const routes = [
  {
    path: '/',
    component: () => import('layouts/Login.vue'),
    children: [
    ]
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '*',
    component: () => import('pages/Error404.vue')
  },
  {
    path: '/main',
    name: 'main',
    meta: {requiresAuth: true},
    component: () => import('layouts/MainLayout.vue'),
    children: [      
      { path: '/main', component: () => import('pages/MainPage.vue') },
      { path: '/config', component: () => import('pages/Config.vue')},
      { path: '/acercaDe', component: () => import('pages/acercaDe.vue') }
      //{ path: '/register', component: () => import('layouts/Register.vue') }
    ]
  },
  {
    path: '/register',
    name: 'register',
    meta: {requiresAuth: true},
    component: () => import('layouts/Register.vue'),
    children: [  
    ]
  },/*
  {
    path: '/paginasolita',
    name: 'paginasolita',
    meta: {requiresAuth: true},
    component: () => import('layouts/Paginasolita.vue'),
    children: [  
    ]
  },*/
  {
    path: '/relogin',
    name: 'relogin',
    meta: {requiresAuth: true},
    component: () => import('layouts/Relogin.vue'),
    children: [
    ]
  }
]

export default routes
