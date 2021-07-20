<template>
  <q-page padding class="flex flex-center">
    <div class="column window-width row justify-center fit">
      <div class="q-mb-xl q-mt-xl text-h2 text-weight-thin col-1 text-center " >
            Configuración
      </div>
      <div class="q-pa-md q-gutter-sm text-center">
        <q-btn color="white" text-color="black" label="Standard" />
        <q-btn color="primary" label="Primary" />
        <q-btn color="secondary" label="Secondary" />
        <q-btn color="amber" glossy label="Amber" />
        <q-btn color="brown-5" label="Brown 5" />
        <q-btn color="deep-orange" glossy label="Deep Orange" />
        <q-btn color="purple" label="Purple" />
        <q-btn color="black" label="Black" />
      </div>


      <div class="q-pa-md align-center">
        <div class="q-gutter-y-md" style="margin:0px">
          <q-card>
            <q-tabs
              v-model="tab"
              class="bg-purple text-white"
              align="justify"
              narrow-indicator
            >
              <q-tab name="user" label="Usuario" />
              <q-tab name="notification" label="Notificaciones" />
              <q-tab name="security" label="Seguridad" />
              <q-tab name="support" label="Soporte"/>
            </q-tabs>

            <q-separator />

            <q-tab-panels v-model="tab" animated class="bg-purple-1 text-center">
              <q-tab-panel name="user">
                <div class="text-h6">Usuario</div>
                <div class="q-pa-md" style="margin-left:200px;margin-right:200px">
                  <q-form
                    @submit="onSubmit"
                    @reset="onReset"
                    class="q-gutter-md"
                  >
                    <q-input
                      filled
                      v-model="name"
                      label="Tu nombre *"
                      hint="Nombre y apellido"
                      lazy-rules
                      :rules="[ val => val && val.length > 0 || 'Por favor escribe algo']"
                    />
                    <q-input
                      filled
                      v-model="email"
                      label="Tu email *"
                      hint="Email"
                      lazy-rules
                      :rules="[ val => val && val.length > 0 || 'Por favor escribe algo']"
                    />

                    <q-input v-model="fecha" filled type="date" hint="Fecha de nacimiento" />

                    <div>
                      <q-btn label="Submit" type="submit" color="primary"/>
                      <q-btn label="Reset" type="reset" color="primary" flat class="q-ml-sm" />
                    </div>
                  </q-form>

                </div>
              </q-tab-panel>

              <q-tab-panel name="notification" class="bg-purple-2">
                <div class="text-h6">Notificaciones</div>
                <div class="row">
                  <div class="col">
                    <p>Nuevas actualizaciones</p>
                  </div>
                  <div class="col">
                    <q-toggle
                      v-model="actualizaciones_notif_toggle"
                      color="green"
                    />
                  </div>
                </div>
                <div class="row">
                  <div class="col">
                    <p>
                      Recordatorios
                    </p> 
                  </div>
                  <div class="col">
                    <q-toggle
                      v-model="recordatorios_notif_toggle"
                      color="green"
                    />
                  </div>
                </div>
              </q-tab-panel>

              <q-tab-panel name="security">
                <div class="text-h6">Seguridad</div>
                Lorem ipsum dolor sit amet consectetur adipisicing elit.
              </q-tab-panel>
              <q-tab-panel name="support">
                <div class="text-h6">Soporte</div>
                Lorem ipsum dolor sit amet consectetur adipisicing elit.
              </q-tab-panel>
            </q-tab-panels>
          </q-card>
        </div>
      </div>

    </div> 

    
  </q-page>
</template>

<script>
export default { 
  data()
  {
    return{
      actualizaciones_notif_toggle:false,
      recordatorios_notif_toggle:false,
      fecha:'',
      name: null,
      email: null,
      accept: false,
      tab: 'user',
      selected: [],
      props: null,
      data_get: null,
      options_fetch: [],
      api_call: null,
      url_base: "https://geome7ric.matiasjrb.com.ar/php/v1/Api.php?apicall="
    }
  },  
  created()
  {
    this.obtener_movimientos();
    
    
  },
  methods: {
    
    edit(props)
    {
      console.log(props);
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
    ocultar_cargando (msg) {
      this.$q.loading.show({
        message: msg
      })      
    },
    mostrar_cargando()
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
        this.hideLoading();     
        
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
    },
    onSubmit () {
      console.log("Entre");
      this.$q.notify({
        color: 'green-4',
        textColor: 'white',
        icon: 'cloud_done',
        message: 'Todo correcto'
      });
      
    },

    onReset () {
      this.name = null
      this.age = null
      this.accept = false
    }
  }  
}
</script>

