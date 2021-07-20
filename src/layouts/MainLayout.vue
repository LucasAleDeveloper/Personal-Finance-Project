<template >
  <div class="q-pa-xs " >
    <q-layout c view="lHh Lpr lff" class="shadow-2 rounded-borders " >
      <q-header elevated class="primary" >
        <q-toolbar  ><!-- style="color: transparent" -->
          <q-btn class="left" flat @click="drawer = !drawer" round dense icon="menu" />
          
          <q-toolbar-title class="text-center">Personal Finance</q-toolbar-title>
          <q-btn class="right" flat @click="click_en_noti" round dense icon="notifications" />
        </q-toolbar>
      </q-header>
          <q-dialog  v-model="mostrar_notificaciones" class="bg-transparent"  :position="position_notifications">
            <q-card style="width: 350px">
              <!--  Esta linea de aca abajo es como un contenedor que va a meter todo lo que haya en notificaciones aca -->
              <!--component class="bg-grey-8" v-for="notificacion in notificaciones" ref="notificacion" v-bind:is="notificacion.type" :key="notificacion.id"></component-->
                
                  <component :is="'Notificacion'" v-for="notificacion in notificaciones" ref="notificacion" v-bind="infonotificaciones" :key="notificacion.id">
                  
                  </component> 
            </q-card>
          </q-dialog>
      <q-drawer
        v-model="drawer"
        show-if-above
        :width="180"
        :breakpoint="500"
      >
        <q-scroll-area   style="height: calc(100% - 150px); margin-top: 150px; border-right: 1px solid #ddd">
          <q-list padding>
            <q-item clickable v-ripple>
              <q-item-section avatar>
                <q-icon name="home"/>
              </q-item-section>

              <q-item-section>
                Inicio
              </q-item-section>
            </q-item>

            <q-item clickable v-ripple>
              <q-item-section avatar>
                <q-icon name="list" />
              </q-item-section>

              <q-item-section>
                Movimientos
              </q-item-section>
            </q-item>
        
            <q-item  @click="open_config" clickable v-ripple>
              <q-item-section avatar>
                <q-icon name="settings" />
              </q-item-section>

              <q-item-section>
                Configuración
              </q-item-section>
            </q-item>

            <q-item clickable v-ripple>
              <q-item-section avatar>
                <q-icon name="help" />
              </q-item-section>

              <q-item-section>
                Ayuda
              </q-item-section>
            </q-item>
            <q-item  @click="open_about"  clickable v-ripple>
              <q-item-section avatar>
                <q-icon name="info" />
              </q-item-section>

              <q-item-section to="/acercaDe.vue">
                Acerca de
              </q-item-section>
            </q-item>
            <q-separator />
            <q-item 
            @click="cerrar_sesion" clickable v-ripple>
              <q-item-section avatar>
                <q-icon name="logout" />
              </q-item-section>

              <q-item-section>
                Cerrar sesión
              </q-item-section>
            </q-item>
          </q-list>
        </q-scroll-area>
        <TarjetaUsuario v-bind="usuario"></TarjetaUsuario>
      </q-drawer>

      <q-page-container class="bg-grey-3">
       
        <keep-alive>

      <router-view />
        </keep-alive>
          <!-- lo cambie por este para poder ir agregando mas funcionalidades rapidas -->
          <q-page-sticky style="z-index: 5000"  :offset="[18, 18]">
             <div class="q-px-sm q-py-lg">
              <div class="column items-center"  position="bottom-rigth">
                <q-fab color="primary" icon="keyboard_arrow_up" direction="up">
                  <q-fab-action color="blue-5" @click="enviar_iniciar_nuevo_movimiento" icon="add" />
                </q-fab>
              </div>
            </div>
            <!--q-btn @click="enviar_iniciar_nuevo_movimiento" fab icon="add" color="primary" /-->
          </q-page-sticky>
          
      </q-page-container>
      
    </q-layout>
    
  </div>
  
</template>

<script>

import Vue from 'vue'; // es6 syntax
/*este es un componente ejemplo de como hay que pensar las cosas. si algo se va a repetir mucho, se hace un componente de un ejemplo 
  no hace falta en la tabla de la main page por que internamente ya lo hace.
*/

import ModuloFuncionesVue from 'src/modules/ModuloFunciones.vue';
import Notificacion from 'components/Notificacion.vue'
import EssentialLink from 'components/EssentialLink.vue'
import TarjetaUsuario from  'components/TarjetaUsuario.vue'
import firebase from 'firebase/app';
const linksData = [
  {
    title: 'Docs',
    caption: 'quasar.dev',
    icon: 'school',
    link: 'https://quasar.dev'
  },
  {
    title: 'Github',
    caption: 'github.com/quasarframework',
    icon: 'code',
    link: 'https://github.com/quasarframework'
  },
  {
    title: 'Discord Chat Channel',
    caption: 'chat.quasar.dev',
    icon: 'chat',
    link: 'https://chat.quasar.dev'
  },
  {
    title: 'Forum',
    caption: 'forum.quasar.dev',
    icon: 'record_voice_over',
    link: 'https://forum.quasar.dev'
  },
  {
    title: 'Twitter',
    caption: '@quasarframework',
    icon: 'rss_feed',
    link: 'https://twitter.quasar.dev'
  },
  {
    title: 'Facebook',
    caption: '@QuasarFramework',
    icon: 'public',
    link: 'https://facebook.quasar.dev'
  },
  {
    title: 'Quasar Awesome',
    caption: 'Community Quasar projects',
    icon: 'favorite',
    link: 'https://awesome.quasar.dev'
  }
];

export default {
  
  name: 'MainLayout',
  components: { EssentialLink },
  data () {
    return {
      infonotificaciones: [],
      trueaux: true,
      backupnotificacionref: null,
      funciones: null,
      mostrar_notificaciones:false,      
      notificaciones: [],
      position_notifications: 'right',
      nombre_user: "Matias",
      usuario: null,
      usuarios: [],
      drawer: false
    }
  },
  components: {Notificacion,TarjetaUsuario},
  created()
  {
    var i=0;
    for (i=0;i<4;i++)
    {
      this.infonotificaciones.push(
        {
          titulo: (Math.random()%100).toString(),
          id: Math.random()%100
        }
      )
    }

    
    console.log(this.infonotificaciones);
    this.funciones= new Vue(ModuloFuncionesVue);
    this.config_inicial();
  },
  mounted()
  {
    console.log("estoy en el mounted");
    console.log(this.notificaciones);
    console.log(this.$refs);
                //this.mostrar_notificaciones=false;
    //this.mostrar_notificaciones=false;
  },
  methods:
  {
    add_notification()
    {
      
        new Vue({
          el: '#notificacion',
          
          components: {
            Notificacion
          }
        });
    },
    renderizar(id,h,parent)
    {

    },
    cargar_notificaciones()
    {
      var i;
      var colorkey;
      var color;
      var class_card;      
      for (i=0;i<this.notificaciones.length;i++)
      {
        console.log(this.$refs.notificacion);
        colorkey="notification-"+((i)%4).toString();
        color=this.funciones.obtener_colores().get(colorkey);
        class_card="bg-"+color+" text-white";
        this.$refs.notificacion[i].class_card=class_card;
        this.$refs.notificacion[i].titulo=class_card;
        //usar el id comotipo de notificacion????
        this.$refs.notificacion[i].id=i%4;
      }

    },
    click_en_noti()
    {
      this.trueaux=true;
      this.mostrar_notificaciones=!this.mostrar_notificaciones;
      console.log("alterno noti: "+ this.mostrar_notificaciones);
      this.$nextTick(() => {
        console.log(this.$refs);
        this.cargar_notificaciones();
      });
        
      
    },
    config_inicial()
    {
      //tengo que pedir las notificaciones que corresponden a este usuario
      var i;
      for (i=0;i<4;i++)
      {
        // mando a renderizar las notificaciones que correspondan
        this.añadir_notificacion('Notificacion');
      };
      this.$nextTick(() => {
        console.log(this.$refs);   
        // uno pa iniciarlo y el otro pa ocultarlo     
        this.click_en_noti();
        this.click_en_noti();
      });
      //conseguir los valores del usuario y modificar las variables
      this.usuario=
      {
        nombre_user: "Matias",
        apodo_user: "Segunda línea",
        imagen_size: "56px"
      }
      this.usuario.nombre_user="Primera_linea";
    },
    añadir_notificacion: function(notificacion)
    {
      this.notificaciones.push({
        'type': notificacion,
        id: this.notificaciones.length
      });
      return this.notificaciones.length;
    },
    async cerrar_sesion()
    { 

      /*
      tengo que agregar un esta seguro?
      */
      try
      {
          const data= await firebase.auth().signOut();
          alert("sesion cerrada joya");
          this.$router.push({ path: '/' });
      }     
      catch (err)
      {
        alert("error cerrando sesion");
      }
    },
    enviar_iniciar_nuevo_movimiento()
    {
      console.log("envio movimiento");
      this.$root.$emit('iniciar_nuevo_movimiento');
    },
    open_config()
    {
      this.$router.push({path:'/config'});
    },
    open_about()
    {
      this.$router.push({path:'/acercaDe'});
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
