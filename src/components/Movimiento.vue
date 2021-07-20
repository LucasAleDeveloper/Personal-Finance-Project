<template>
    <q-card flat bordered v-ripple
    :class="class_movimiento"
    @click="toco_movimiento" 
    >
      <q-card-section class="movimiento" >
        <div class="text-h6" >{{nombre}}</div>
        <div class="text-subtitle1">{{categoria}}</div>
        <div class="text-subtitle1">{{tipo_movimiento}}</div>
        <div class="text-subtitle2">{{monto}}</div>
      </q-card-section>
    </q-card>
</template>

<script>
import EssentialLink from 'components/EssentialLink.vue'

import firebase from 'firebase/app';
import Vue from 'vue'; // es6 syntax
import ModuloFuncionesVue from 'src/modules/ModuloFunciones.vue';


export default {   
  props: {
    tipo_movimiento:
    {
      type: String,
      default: "Tipo de movimiento sin asignar"
    },
    categoria:
    {
      type: String,
      default: "Categoría sin asignar"
    },
    nombre: 
    {
      type: String,
      default: "Nombre del movimiento sin asignar"
    },
    monto: 
    {
      type: String,
      default: "Monto del movimiento sin asignar"
    },
    id:
    {
      type: String,
      default: 0
    },
    class_movimiento:
    {
      type: String,
      default: "bg-blue-3 text-white cursor-pointer relative-position q-hoverable"
    },
    style_movimiento:
    {
      type: String,
      default: "bg-red &:hover bg-yellow"
    }
  },
  data () {
    return {  
      contenido: 'Contenido de notificación',
      boton_1: 'Es el boton 1',
      boton_2: 'Es el boton 2',
      class_card: 'bg-transparent text-white',
      type: 'Notificacion'
    }
  },
  created()
  {
    
  },
  methods:
  {
    toco_movimiento(evt)
    {
      var data=
      {
        id: this.id,
        function: "movimiento"
      };
      this.$root.$emit('listener_pagina_principal',data);
    } 
  }
}


</script>

<style>
  .movimiento:hover{
    background-color: var(--q-color-primary);
    }
</style>

