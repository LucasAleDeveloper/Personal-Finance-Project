<template>
    <q-card flat bordered>
        <q-card :class="class_card">
          <q-card-section>
            <div class="text-h6">{{titulo}}</div>
            <div class="text-subtitle2">{{contenido}}</div>
          </q-card-section>

          <q-card-section>
          </q-card-section>

          <q-separator dark />

          <q-card-actions>
          <q-btn flat round @click="toco_notificacion">
            {{boton_1}}
          </q-btn>
          <q-btn flat  @click="toco_notificacion">
            {{boton_2}}
          </q-btn>
        </q-card-actions>
          
        </q-card>

        
      </q-card>
</template>

<script>
import EssentialLink from 'components/EssentialLink.vue'

import firebase from 'firebase/app';
import Vue from 'vue'; // es6 syntax
import ModuloFuncionesVue from 'src/modules/ModuloFunciones.vue';


export default {   
  props: {
    titulo: 
    {
      type: String,
      default: "Title"
    },
    id:
    {
      type: String,
      default: 0
    }
  },
  data () {
    return {  
      contenido: 'Contenido de notificación',
      boton_1: 'Es el boton 1',
      boton_2: 'Es el boton 2',
      class_card: 'bg-grey-10 text-white',
      type: 'Notificacion'
    }
  },
  created()
  {
    
  },
  methods:
  {
    toco_notificacion(evt)
    {
      var data=
      {
        id: this.id,
        function: "notificacion"
      };
      this.$root.$emit('listener_pagina_principal',data);
    }
  }
}


</script>



