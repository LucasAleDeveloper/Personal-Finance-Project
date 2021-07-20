<template>
    <div :class="class_contenedor" :style="style_contenedor">
      
      <q-scroll-area
        visible="false"
        style="height: 600px;"
      >
        <div v-for="n in 7" :key="n" class="q-py-xs">
          <Movimiento></Movimiento>
        </div>
      </q-scroll-area>
    </div>
</template>

<script>

import Movimiento from 'components/Movimiento.vue'
import EssentialLink from 'components/EssentialLink.vue'

import firebase from 'firebase/app';
import Vue from 'vue'; // es6 syntax
import ModuloFuncionesVue from 'src/modules/ModuloFunciones.vue';


export default {  
  //props: ['nombre_user','apodo_user','imagen_size','imagen_user','imagen_user'],
  props: {   
    
    style_contenedor:
    {
      type: String,
      default: "margin: 0; padding: 0"
    },
    class_contenedor:
    {
      type: String,
      default: "q-ma-xl q-pa-xs justify-center fit"
    },
    visible: 
    {
      type: Boolean,
      default: false
    },
    apodo_user:
    {
      type: String,
      default: "Aún sin asignar"
    },
    imagen_size:
    {
      type: String,
      default: "56px"
    },
    imagen_user:
    {
      type: String,
      default: "https://res.cloudinary.com/geome7ric-weasel/image/upload/w_1000,c_fill,ar_1:1,g_auto,r_max,bo_5px_solid_red,b_rgb:262c35/v1620819318/recursos/unnamed_xhkr0e.png"
    },
    class_avatar:
    {
      type: String,
      default: "q-mb-sm"
    },
    class_div_tarjeta:
    {
      type: String,
      default: "absolute-bottom bg-transparent"
    },
    style_tarjeta:
    {
      type: String,
      default: "height: 150px"
    },
    imagen_fondo:
    {
      type: String,
      default: "https://cdn.quasar.dev/img/material.png"
    },
    class_tarjeta:
    {
      type: String,
      default: "absolute-top"
    },
    class_texto_nombre_user:
    {
      type: String,
      default: "text-weight-bold"
    },
    style_div_tarjeta:
    {
      type: String,
      default: ''
    }
  },
  components:
  {
    Movimiento
  },
  computed:
  {
  },
  data () {
    return {  
    }
  },
  created()
  {
    
  },
  methods:
  {
  }
}


</script>



