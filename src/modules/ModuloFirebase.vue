<template>
    
</template>

<script>
import EssentialLink from 'components/EssentialLink.vue'

import firebase from 'firebase/app';
import Vue from 'vue'; // es6 syntax
import ModuloFuncionesVue from 'src/modules/ModuloFunciones.vue';

export default {  
  data () {
    return {  
      log_user: null,
      log_email_user: null,
    }
  },
  created()
  {
    this.funciones= new Vue(ModuloFuncionesVue);
    setInterval(this.actualizar_usuario_logueado,1000);
  },
  methods:
  {
    async actualizar_usuario_logueado()
    {
      const val=  firebase.auth().onAuthStateChanged((user) => {        
        if (user) 
        {
          
          var uid = user.uid;
          this.log_user=user;
          this.log_email_user=this.log_user.email;
        } 
        else 
        {
          // User is signed out
          // ...
          this.log_email_user="error";
          
          
        }
      });
      if (this.log_email_user=="error")
      {
        //si tengo error directamente corto la sesion y mando a la ruta main
        // no se por que no anda
        //this.$router.push({ path: '/' });
      }
    },
    obtener_email_usuario_logueado()
    {
      if (this.log_email_user!=null)
        return this.log_email_user;
      else
        return "error";
    }
  }
}


</script>

<style lang="sass">
.my-sticky-header-table
  /* height or max-height is important */
  height: 310px

  .q-table__top,
  .q-table__bottom,
  thead tr:first-child th
    /* bg color is important for th; just specify one */
    background-color: #c1f4cd

  thead tr th
    position: sticky
    z-index: 1
  thead tr:first-child th
    top: 0

  /* this is when the loading indicator appears */
  &.q-table--loading thead tr:last-child th
    /* height of all previous header rows */
    top: 48px
</style>


