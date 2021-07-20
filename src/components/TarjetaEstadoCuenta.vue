<template>
  <div :class="class_contenedor" :style="style_tarjeta">   
    <div :class="class_texto_nombre_user" >{{nombre_user}}</div>
      <div :class="class_contenedor_saldo">
        <div :class="class_saldo">
          ${{saldo}}
        </div>
        <div :class="class_centavos">
          {{centavos}}
        </div>
      </div>
    <div :class="class_texto_pie">Saldo geométrico</div>
  </div>
</template>

<script>
import EssentialLink from 'components/EssentialLink.vue'

import firebase from 'firebase/app';
import Vue from 'vue'; // es6 syntax
import ModuloFuncionesVue from 'src/modules/ModuloFunciones.vue';


export default {  
  //props: ['nombre_user','apodo_user','imagen_size','imagen_user','imagen_user'],
  props: {
    nombre_user: 
    {
      type: String,
      default: "Aún sin asignar"
    },
    saldo: 
    {
      type: String,
      default: "777"
    },
    centavos:
    {
      type: String,
      default: "00"
    },
    class_texto_pie:
    {
      type: String,
      default: "text-weight text-center"
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
    class_saldo:
    {
      type: String,
      default: " text-h2  text-weight-bold text-center"
    },
    class_contenedor_saldo:
    {
      type: String,
      default: "q-ma-xs row justify-center text-center"
    },
    class_centavos:
    {
      type: String,
      default: "text-h4  text-weight text-center"
    },
    class_div_tarjeta:
    {
      type: String,
      default: "absolute-bottom bg-transparent"
    },
    style_tarjeta:
    {
      type: String,
      default: "margin:10px;padding:0"
    },
    imagen_fondo:
    {
      type: String,
      default: "https://cdn.quasar.dev/img/material.png"
    },
    class_tarjeta:
    {
      type: String,
      default: "column row justify-center fit"
    },
    class_contenedor:
    {
      type: String,
      default: "q-mt-xl q-pa-xl column row justify-center fit"
    },
    class_texto_nombre_user:
    {
      type: String,
      default: "q-ma-xs text-weight-bold text-center"
    },
    style_div_tarjeta:
    {
      type: String,
      default: ''
    }
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



