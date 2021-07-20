<template>
  <q-page padding class="flex flex-center">
    <div class="column window-width row justify-center fit">
      <!--div class="q-mb-xl q-mt-xl text-h2 text-weight-thin col-1 text-center " >
            Saldo:  ${{saldo}}
      </div-->
      <TarjetaEstadoCuenta 
        nombre_user="Matias"
        saldo="7777"
        centavos="77"
      >
      </TarjetaEstadoCuenta>

      
      <!-- con un v-bind, de un arreglo de movimientos, se pueden modificar los movimientos a mostrar-->
      <ContenedorMovimientos        
      ></ContenedorMovimientos> 
    </div>
    

    <div v-show="mostrar_nuevo_movimiento" class="q-pa-md q-gutter-md">      
      <q-dialog  v-model="mostrar_nuevo_movimiento" transition-show="rotate" transition-hide="rotate">
        <q-card>
          <q-card-section>
            <div class="text-h6">Agregar movimiento</div>
          </q-card-section>
          

           <div class="q-pa-md" style="width: 400px;max-width: 600px">

        <q-form
          @submit="submit_nuevo_movimiento"
          @reset="reset_movimiento"
          class="q-gutter-md"
        >
          <q-input
            filled
            v-model="nombre_movimiento"
            label="Nombre"
            hint="Nombre del nuevo movimiento"
            lazy-rules
            :rules="[ val => val && val.length > 0 || 'Por favor, ingresa un nombre válido']"
          />

          <q-input
            filled
            type="textarea"
            v-model="descripcion_movimiento"
            label="Descripción"
            hint="Descripción del nuevo movimiento"
            lazy-rules
            :rules="[ val => val && val.length > 0 || 'Por favor, ingresa una descripción válido']"
          />

          
          

          <q-select
              filled
              v-model="categoria_movimiento"
              use-input
              hide-selected
              fill-input
              input-debounce="0"
              label="¿A qué categoría corresponde?"
              :options="categorias_movimiento"
              @filter="filtro_categorias"
              hint="Comienza a escribir la categoría"
            >   <template v-slot:no-option>
                  <q-item>
                    <q-item-section class="text-grey">
                      Sin resultados
                    </q-item-section>
                  </q-item>
                </template>
          </q-select> 

          <q-checkbox dense v-model="pago_periodico" label="¿Es un gasto períodico?" color="teal" /> 
          <q-select v-show="pago_periodico" square outlined v-model="cantidad_cuotas" 
          :options="periodos" 
             label="Período"  />

          <q-input v-model="fecha_movimiento" filled type="date" hint="Fecha movimiento. Por defecto, el día de hoy" 
          :rules="[
            val => val !== null && val !== '' || 'Por favor, ingresa una fecha'
          ]"/>
        
         
          

          <q-checkbox dense v-model="pago_en_cuotas" label="¿Es un pago en cuotas?" color="teal" /> 


           <q-select
              filled
              v-show="pago_en_cuotas"
              v-model="tarjeta_credito_movimiento"
              use-input
              hide-selected
              fill-input
              input-debounce="0"
              label="¿Está asociada a una tarjeta de crédito?"
              :options="tarjetas_de_credito"
              @filter="filtro_tarjetas"
              hint="Comienza a escribir la tarjeta"
            >   <template v-slot:no-option>
                  <q-item>
                    <q-item-section class="text-grey">
                      Sin resultados
                    </q-item-section>
                  </q-item>
                </template>
          </q-select> 
         

          <q-select v-show="pago_en_cuotas" square outlined v-model="cantidad_cuotas" 
          :options="cantidad_de_cuotas" 
             label="Cantidad de cuotas nuevo movimiento"  />

          <q-input
            filled
            v-model="monto_movimiento"
            label="Monto"
            hint="Monto total del nuevo movimiento"
            lazy-rules
            :rules="[ val => val && val.length > 0 || 'Por favor, ingresa un monto válido']"
          />

          

          
          <q-toggle v-model="accept" label="He revisado los datos ingresados" />

          <div>
            <q-btn label="Agregar" type="subONmit" color="primary"/>
            <q-btn label="Limpiar" type="reset" color="primary" flat class="q-ml-sm" />
          </div>
        </q-form>

      </div>
        </q-card>
      </q-dialog>
      
    </div>

    
  </q-page>
</template>

<script>


import TarjetaUsuario from 'components/TarjetaUsuario.vue'
import TarjetaEstadoCuenta from 'components/TarjetaEstadoCuenta.vue'
import ContenedorMovimientos from 'components/ContenedorMovimientos.vue'

import ModuloFuncionesVue from 'src/modules/ModuloFunciones.vue';
import ModuloFirebaseVue from 'src/modules/ModuloFirebase.vue';
import ModuloNetworkVue from 'src/modules/ModuloNetwork.vue'
import Vue from 'vue'; // es6 syntax
import { firebaseAuth } from 'src/boot/firebase';

import firebase from 'firebase/app';

document.addEventListener('deviceready', () => {
  // it's only now that we are sure
  // the event has triggered
}, false);

export default { 
  data()
  {
    return{
      network: null,
      usuario: null,
      firebase: null,
      tarjetas_de_credito:[],
      tarjetas_de_credito_backup: [],
      tarjeta_credito_movimiento: "Ninguna",
      pago_periodico: false,
      periodos: [],
      batteryStatus: 'determining...',
      selected: [],
      funciones: null,
      props: null,
      data_get: null,
      options_fetch: [],
      api_call: null,
      url_base: "https://geome7ric.matiasjrb.com.ar/php/v1/Api.php?apicall=",
      cantidad_de_cuotas: [3,6,9,12,15,18],
      accept:false,
      fecha_movimiento: this.hoy(),
      mostrar_nuevo_movimiento: false,
      nombre_movimiento: null,
      categorias_movimiento: [],
      categorias_movimiento_backup: [],
      categoria_movimiento: null,
      monto_movimiento:null,
      pago_en_cuotas: false,
      cantidad_cuotas: null,
      descripcion_movimiento:null,
      saldo: 777.0,
      filter: '',
      name: 'PageIndex',
      my_columns: [
            {
              name: 'desc',
              required: true,
              label: 'Nombre',
              align: 'left',
              field: row => row.nombre,
              format: val => `${val}`,
              sortable: true
            },
            { name: 'calories', align: 'center', label: 'Monto total', field: 'monto', sortable: true },
            { name: 'fat', label: 'Descripción', field: 'descripcion', sortable: true },
            { name: 'fat2', label: 'Categoría', field: 'categoria', sortable: true },
            { name: 'carbs', label: 'Fecha de creación', field: 'fecha_creacion' },
            { name: 'actions', label: 'Actions', field: '', align:'center' }
          ],
      my_data: [
        {
          name: 'Frozen Yogurt',
          calories: 159,
          fat: 6.0,
          carbs: 24
        },
        {
          name: 'Ice cream sandwich',
          calories: 237,
          fat: 9.0,
          carbs: 37
        },
        {
          name: 'Eclair',
          calories: 262,
          fat: 16.0,
          carbs: 23
        },
        {
          name: 'Cupcake',
          calories: 305,
          fat: 3.7,
          carbs: 67
        },
        {
          name: 'Gingerbread',
          calories: 356,
          fat: 16.0,
          carbs: 49
        },
        {
          name: 'Jelly bean',
          calories: 375,
          fat: 0.0,
          carbs: 94
        },
        {
          name: 'Lollipop',
          calories: 392,
          fat: 0.2,
          carbs: 98
        },
        {
          name: 'Honeycomb',
          calories: 408,
          fat: 3.2,
          carbs: 87
        },
        {
          name: 'Donut',
          calories: 452,
          fat: 25.0,
          carbs: 51
        },
        {
          name: 'KitKat',
          calories: 518,
          fat: 26.0,
          carbs: 65
        }
      ]
    }
  },  
  components: {TarjetaUsuario,TarjetaEstadoCuenta,ContenedorMovimientos}, // Cuando vamos a instanciar por fuera de javascript como es este el caso, que me va a meter un componente html hace falta hacer esto
  created()
  {
    //this.network= new Vue(ModuloNetworkVue);
    //laravel test
    //this.laravel_test();
    //cada vez que emitan listener, ejecuto listener pagina principal y le paso el parametro. ver en methods
    this.$root.$on('listener_pagina_principal', (param) => this.listener(param));
    this.$root.$on('iniciar_nuevo_movimiento', () => this.iniciar_nuevo_movimiento());
    this.obtener_config();
    window.addEventListener('batterystatus', this.updateBatteryStatus, false)
    this.funciones= new Vue(ModuloFuncionesVue);
    this.funciones.mostrar_cargando("Un segundo..");
    this.funciones.alerta_positiva_home("Bienvenido");
    this.firebase= new Vue(ModuloFirebaseVue);
    this.obtener_movimientos();
    //alert("wtf");
  },
  beforeDestroy () {
    // we do some cleanup;
    // we need to remove the event listener
    window.removeEventListener('batterystatus', this.updateBatteryStatus, false)
  },
  mounted()
  {    
    this.funciones.ocultar_cargando();  
  },
  methods: {    
    laravel_test()
    {
      var estudiante=
      {
        id: "7",
        name: "mati",
        active: true
      };
      //this.network.post_laravel("estudiante/create",estudiante);
      this.network.get_laravel("estudiantes/");


    },    
    manejador_notificaciones(id)
    {
      console.log(id);
      switch (id)
      {
        case 0:
          alert("Se ejecuta lo correspondiente a la notificion de tipo 0, para el usuario logueado");
          break;
        default:
          alert("Esa notificacion no la conozco");
          break;
      }
    },

    manejador_movimientos(id)
    {
      console.log(id);
      switch (id)
      {
        case 0:
          this.funciones.alerta_positiva_default("Se ejecuta lo correspondiente al movimiento de tipo 0, para el usuario logueado");
          break;
        default:
          alert("Movimiento no conocido clickeado");
          break;
      }
    },

    listener(data)
    {
      // este metodo voy a ejecutar cada vez qwue envien algo a main page bajo el evento "listener", ver en creat3d() 
      // (uso mucho el cntrl f pa moverme por eso le cambio el nombre)
      var fun=data.function;
      switch(fun)
      {      
        case "notificacion":
          //desde algun lado me indicaron que tocaron en una notificacion.como se que es una notificacion, se que en el data me va a venir un .id
          this.manejador_notificaciones(data.id);
          break; 

        case "movimiento":
          this.manejador_movimientos(data.id);
          
          break;
        default:
          console.log("No esta contemplado este parametro en mainpage, methods, listener: \n"+data);
          break;
      }
    },
    obtener_config()
    {

      
      
      // tiene que traer los periodos, las categorias, todo lo que esta seteado por enn el backend, es para no tener que tocar frontend par manejar estas cosas
      this.periodos=["Diario","Semanal","Quincenal","Mensual","Anual"];
      this.categorias_movimiento=["Otros","Supermercados","Bares","Cuidado personal","Vestimenta",
      "Shopping","Restaurante","Servicios","Viajes","Entretenimiento","Cajeros","Transporte",
      "Familia","Mascotas","Delivery","Hobbies","Donaciones","Belleza","Auto","Hijos",
      "Educación","Boludeces","Deportes","Salidas","Trabajo","Tecnología","Hogar",
      "Suscripciones","Gaming"];
      this.categorias_movimiento_backup=this.categorias_movimiento;
      this.tarjetas_de_credito=["Visa 5436", "Visa 2356","Cabal 7777"];
      this.tarjetas_de_credito_backup=this.tarjetas_de_credito;

    },
    filtro_tarjetas(val, update, abort) {     
      setTimeout(() => {
        update(() => {
          if (val === '') {
            this.tarjetas_de_credito = this.tarjetas_de_credito_backup;
          }
          else {
            const needle = val.toLowerCase()
            this.tarjetas_de_credito = this.tarjetas_de_credito_backup.filter(v => v.toLowerCase().indexOf(needle) > -1)
          }
        })
      }, 50)
    },
    filtro_categorias(val, update, abort) {
     
      setTimeout(() => {
        update(() => {
          if (val === '') {
            this.categorias_movimiento = this.categorias_movimiento_backup;
          }
          else {
            const needle = val.toLowerCase()
            this.categorias_movimiento = this.categorias_movimiento_backup.filter(v => v.toLowerCase().indexOf(needle) > -1)
          }
        })
      }, 50)
    },
    updateBatteryStatus (status) {
      this.batteryStatus = `Level: ${status.level}, plugged: ${status.isPlugged}`
    },
    edit(props)
    {
      console.log(this.firebase.obtener_email_usuario_logueado());
      if (this.firebase.obtener_email_usuario_logueado=="matiasjrb@gmail.com")
      {
        alert("sirve asi");
      }
      alert(props.cols[1].value);
    },
    async insertar(apicall)
    {
      var res= await fetch(this.url_base+apicall,this.options_fetch).then(function (response) {
                                if (response.ok) {
                                  //var res=response.json();
                                  console.log(response);
                                  console.log("retorno 1");
                                  return 1;
                                  return response;
                                }
                                return Promise.reject(response);
                              }).then(function (data) {
                                return 2;
                                console.log(data);
                              }).catch(function (error) {
                                //this.alerta_negativa('Inténtalo de nuevo más tarde');  
                                return 3;                             
                                console.warn('Something went wrong.', error);
                              });  

    },
    async get(apicall,arreglo)
    {
      console.log("wtf1");
      await fetch(this.url_base+apicall)
        .then(res=> res.json())
        .then(data=> 
        {
          console.log(data);
          this.my_data=data[arreglo];
          console.log(this.my_data[arreglo]);
          console.log(this.my_data);
          return data;
        });
    },
    async obtener_movimientos()
    {
      var data_res=await  this.get("getmov","movimientos");
      //this.my_data=this.data_res;
      console.log(this.my_data);
    },    
    mostrar_cargando (msg) {
      this.$q.loading.show({
        message: msg
      })      
    },
    ocultar_cargando()
    {
      this.$q.loading.hide();
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
    verificar_datos_nuevo_movimiento()
    {
      return true;
    },
    async submit_nuevo_movimiento()
    {
      if (this.verificar_datos_nuevo_movimiento())
      {
        //modifico las options
        this.mostrar_cargando("Agregando..");
        var fd = new FormData();
        fd.append('nombre', this.nombre_movimiento); 
        fd.append('descripcion', this.descripcion_movimiento); 
        fd.append('user', "matiasjriosb@gmail.com");        
        fd.append('categoria',this.categoria_movimiento);
        var es_pago_en_cuotas="false";
        if (this.pago_en_cuotas)
          es_pago_en_cuotas="true";
        fd.append('es_pago_cuotas', es_pago_en_cuotas); 
        fd.append('fecha_creacion', this.fecha_movimiento); 
        if (this.pago_en_cuotas)
        {
          var monto_total= parseFloat(this.monto_movimiento);
          var cant_cuotas=this.cantidad_cuotas;          
          var monto_de_cuota= (monto_total/cant_cuotas).toString();
          fd.append('monto', this.monto_movimiento);
          fd.append('monto_cuota',monto_de_cuota);
          fd.append('cantidad_cuotas',this.cantidad_cuotas.toString());
          fd.append('cantidad_cuotas_pagas',"0");
        }
        else
        {
          fd.append('monto', this.monto_movimiento);
          fd.append('monto_cuota',"-1");
          fd.append('cantidad_cuotas',"-1");
          fd.append('cantidad_cuotas_pagas',"-1");
        }

        console.log(this.nombre_movimiento);
        console.log(this.descripcion_movimiento);
        console.log(this.monto_movimiento);
        console.log(this.categoria_movimiento);
        console.log(this.pago_en_cuotas.toString());
        console.log(this.cantidad_cuotas);


        
        this.options_fetch =
        {
          method: 'POST',
          body: fd
        };
        var res=await this.insertar(/*apical */"insertarmov");  
        this.popup_message("Movimiento agregado correctamente","green","done","white");
        this.reset_movimiento();
        this.ocultar_cargando();     
        
      }

    },
    reset_movimiento()
    {
      /*
      accept:false,
      fecha_movimiento: this.hoy()*/
      this.mostrar_nuevo_movimiento=false;/*
      nombre_movimiento: null,
      categorias_movimiento: [],
      categoria_movimiento: null,
      monto_movimiento:null,
      pago_en_cuotas: false,
      cantidad_cuotas: null,
      descripcion_movimiento:null,*/

    },
    popup_message(msg,color_msg,icon_msg,texto_color)
    {
      //alert("wtf2");
      this.$q.notify({
              color: color_msg,
              textColor: texto_color,
              icon: icon_msg,
              message: msg
            });
    },
    iniciar_nuevo_movimiento()
    {
      this.mostrar_nuevo_movimiento=true;
    }
  }  
}
</script>

