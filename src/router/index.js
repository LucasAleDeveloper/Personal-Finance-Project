import Vue from 'vue'
import VueRouter from 'vue-router'

import routes from './routes'

import firebase from 'firebase/app';
Vue.use(VueRouter)

/*
 * If not building with SSR mode, you can
 * directly export the Router instantiation;
 *
 * The function below can be async too; either use
 * async/await or return a Promise which resolves
 * with the Router instance.
 */

export default function (/* { store, ssrContext } */) {
  const Router = new VueRouter({
    scrollBehavior: () => ({ x: 0, y: 0 }),
    routes,

    // Leave these as they are and change in quasar.conf.js instead!
    // quasar.conf.js -> build -> vueRouterMode
    // quasar.conf.js -> build -> publicPath
    mode: process.env.VUE_ROUTER_MODE,
    base: process.env.VUE_ROUTER_BASE
  })

  Router.beforeEach((to,from,next)=> 
  {
    const requiresAuth = to.matched.some(record=> record.meta.requiresAuth);
    const isAuthenticated= firebase.auth().currentUser;
    if (requiresAuth && !isAuthenticated)
    {
      next();
      

      /*
      descomentando next("/relogin"); y comentando el next() de arriba  te obliga estar con la sesion iniciada para acceder a otra ubicacion 
      tengo que diferenciar de la pagina register y re login register
      */
      console.log("router say: ");
      console.log(to.path);
      var go_to= to.path;
      if (go_to =="/register" || go_to == "/relogin")
        next();
      else
        next();
      //
      
    }
    else
    {
      next();
    }

  })

  return Router
}
