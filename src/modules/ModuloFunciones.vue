<template>
    
</template>

<script>
import EssentialLink from 'components/EssentialLink.vue'

import firebase from 'firebase/app';

/*

voy a definir un map colores para pedirle a este los que estemos usando
*/

export default {  
  data () {
    return {  
      colores: new Map()
    }
  },
  created()
  {   
    this.configurar_colores();
  },
  methods:
  {
    configurar_colores()
    {
      this.colores.set("primary","primary");
      this.colores.set("secondary","secondary");
      this.colores.set("notification-0","red-5");
      this.colores.set("notification-1","blue-5");
      this.colores.set("notification-2","light-green-5");
      this.colores.set("notification-3","deep-orange-5");      
    },
    obtener_colores()
    {
      return this.colores;
    },
    alerta_positiva_default(msg)
    {
      this.$q.notify({
                        color: 'green-4',
                        textColor: 'white',
                        icon: 'done',
                        message: msg
                      })
    },
    alerta_positiva_nube(msg)
    {
      this.$q.notify({
                        color: 'green-4',
                        textColor: 'white',
                        icon: 'cloud_done',
                        message: msg
                      })
    },
    alerta_positiva_home(msg)
    {
      this.$q.notify({
                        color: 'green-4',
                        textColor: 'white',
                        icon: 'home',
                        message: msg
                      })
    },
    alerta_negativa_default(msg)
    {
        this.$q.notify({
                        color: 'red-4',
                        textColor: 'white',
                        icon: 'warning',
                        message: msg
                      })
    },
    alerta_negativa_error(msg)
    {
        this.$q.notify({
                        color: 'red-5',
                        textColor: 'white',
                        icon: 'error',
                        message: msg
                      })
    },
    hoy()
    {
      var hoy = new Date();
      var dd = String(hoy.getDate()).padStart(2, '0');
      var MM = String(hoy.getMonth() + 1).padStart(2, '0'); //January is 0!
      var yyyy = hoy.getFullYear();      
      hoy = yyyy + '-' + MM + '-' + dd;
      return hoy;
    },
    mostrar_cargando(msg) {
      this.$q.loading.show({
        message: msg
      })      
    },
    ocultar_cargando()
    {
      this.$q.loading.hide();
    },
  }
}

function alert(msg)
{
  alert(msg);
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


