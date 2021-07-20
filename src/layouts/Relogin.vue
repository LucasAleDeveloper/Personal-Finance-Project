<template>

  <q-layout view="hHh lpR fFf">
    
    <q-page-container class="bg-primary window-height window-width row justify-center items-center"> 
      <q-dialog v-model="persistent" persistent transition-show="scale" transition-hide="scale">
        <q-card class="bg-red-5 text-white" style="width: 300px">
          <q-card-section>
            <div class="text-h6">Lo sentimos. Debes volver a iniciar sesión</div>
          </q-card-section>

          <q-card-section class="q-pt-none">
          </q-card-section>

          <q-card-actions align="right" class="bg-white text-teal">
            <q-btn flat label="Aceptar" v-close-popup />
          </q-card-actions>
        </q-card>
      </q-dialog>
      <div class="column" >
          
        <div class="row">
            <h5 class="text-h5 text-white q-my-md">Geome7ric Weasel</h5>
        </div>
        <div class="row">
            <q-card square bordered class="q-pa-lg shadow-1">
            <q-card-section>
                <q-form class="q-gutter-md">
                <q-input v-model="formData.email" square filled clearable type="email" label="email" />
                <q-input v-model="formData.password" square filled clearable type="password" label="contraseña" />
                </q-form>
            </q-card-section>
            <q-card-actions class="q-px-md justify-center items-center">
                 <q-img 
                  @click="intentar_iniciar_sesion_google"
                  class="justify-center items-center q-my-md"
                  src="https://res.cloudinary.com/geome7ric-weasel/image/upload/v1618704516/google.png"
                  spinner-color="white"
                  style="height: 60px; max-width: 60px"
                />
                <q-img
                 @click="intentar_iniciar_sesion_facebook"
                  class="justify-center items-center q-my-md"
                  src="https://res.cloudinary.com/geome7ric-weasel/image/upload/v1618704912/facebook_icon-icons.com_59205_z8tilv.png"
                  spinner-color="white"
                  style="height: 60px; max-width: 60px"
                />
                <q-btn @click="intentar_iniciar_sesion" unelevated color="secondary" size="lg" class="full-width" label="Iniciar sesión" />
                <q-btn @click="iniciar_ventana_registro" unelevated color="primary" size="lg" class="full-width" label="Regístrate" />
            </q-card-actions>

            </q-card>
        </div>
    </div>
    </q-page-container>

    <q-footer reveal elevated class="bg-primary text-white">
      <q-toolbar>
        <q-toolbar-title >
          <q-avatar>
            <img src="https://res.cloudinary.com/geome7ric-weasel/image/upload/w_1000,c_fill,ar_1:1,g_auto,r_max,bo_5px_solid_red,b_rgb:262c35/v1618342251/recursos/Sin_t%C3%ADtulo_pefn6q.jpg">
          </q-avatar>
        Powered by 
              <a href="https://geome7ricweasel.com.ar" 
              style="color:#ffffff">@jmpuhl @matiasjrios @lucasale @jmpoio</a>
        </q-toolbar-title>
      </q-toolbar>
    </q-footer>
    <q-dialog v-model="hay_error" v-if="hay_error">
      <q-card>
        <q-card-section>
          <div class="text-h6">Atención</div>
        </q-card-section>

        <q-card-section class="q-pt-none">
         {{ mensaje_error }}
        </q-card-section>

        <q-card-actions align="right">
          <q-btn flat label="OK" color="primary" v-close-popup />
        </q-card-actions>
      </q-card>
    </q-dialog>

  </q-layout>
  
</template>

<script>
import MainLayout from 'layouts/MainLayout.vue';

import { mapActions, mapState } from "vuex";
import firebase from 'firebase/app';

export default {
  
   
  data () {    
    return {
      persistent: true,
      //url_base: "http://192.168.0.16/php/v1/Api.php?apicall=",
      url_base: "https://matiasjrb.com.ar/php_bullmetal/v1/Api.php?apicall=",
      is_admin: false,
      formData: {email: 'matiasjriosb@gmail.com', password: 'Matiasjrb95!'},
      email: '',
      passwd: '',
      mensaje_error: '',
      hay_error: false
    }
  },
   computed: {
    ...mapState('auth', ['loggedIn'])
  },
  created()
  {
    
    console.log("estoy en login");
  }  ,
    methods: {  
      intentar_iniciar_sesion_google()
      {
        console.log("iniciar sesion con google");
        var provider = new firebase.auth.GoogleAuthProvider();
        firebase.auth()
          .signInWithPopup(provider)
          .then((result) => {
            /** @type {firebase.auth.OAuthCredential} */
            var credential = result.credential;

            // This gives you a Google Access Token. You can use it to access the Google API.
            var token = credential.accessToken;
            // The signed-in user info.
            var user = result.user;
            console.log(user);
            this.$router.push({ path: 'main' });
            // ...
          }).catch((error) => {
            // Handle Errors here.
            var errorCode = error.code;
            var errorMessage = error.message;
            // The email of the user's account used.
            var email = error.email;
            // The firebase.auth.AuthCredential type that was used.
            var credential = error.credential;
            // ...
          });
      },
      intentar_iniciar_sesion_facebook()
      {
        console.log("iniciar sesion con facebook");
        var provider = new firebase.auth.FacebookAuthProvider();
        firebase
          .auth()
          .signInWithPopup(provider)
          .then((result) => {
            /** @type {firebase.auth.OAuthCredential} */
            var credential = result.credential;

            // The signed-in user info.
            var user = result.user;

            // This gives you a Facebook Access Token. You can use it to access the Facebook API.
            var accessToken = credential.accessToken;
            
            console.log(user);
            this.$router.push({ path: 'main' });

            // ...
          })
          .catch((error) => {
            // Handle Errors here.
            var errorCode = error.code;
            var errorMessage = error.message;
            // The email of the user's account used.
            var email = error.email;
            // The firebase.auth.AuthCredential type that was used.
            var credential = error.credential;

            // ...
          });
      },
      iniciar_ventana_registro()
      {
        console.log("meto register");
        this.$router.push({ path: 'register' });
      },
      async intentar_iniciar_sesion()
      {
        
        
        
        try
        {
          const val= await firebase.auth().signInWithEmailAndPassword(this.formData.email,this.formData.password);
          console.log(val);
          const is_admin = await this.es_admin(this.formData.email);

          //alert("Sesión iniciada correctamente");
          this.$router.push({ path: 'main' });
        }
        catch (err)
        {
          console.log(err);
          alert("Revisa tu email y contraseña!");
        }
      },
      emitir_valor_is_admin()
      {
        console.log("recibi enviar el is admin");
        if (!this.is_admin)
        {
          this.$root.$emit('ocultar_no_admin');
        }
      },
      es_admin(email)
      {
        var result = new Array();
        var url=this.url_base+"esAdmin&email=";
        url+=email;
        console.log(url);
        fetch(url)
          .then(res=> res.json())
          .then(data=> 
          {        
              var admins=data.admin;              
              console.log(" a ver que hay en admins");  
              console.log(admins);
              if (admins.length==0)
              {
                console.log("emito lo de admin");
                this.is_admin=false;
              }
              else
              {
                this.is_admin=true;
              }
              
          }
          )
          .catch(error => console.log('ERROR mirando si es admin'));
      },
      ...mapActions('auth', ['loginUser','logoutUser']),
    submitForm(){
      console.log('funciona form');
      this.loginUser(this.formData)
    },
      click_iniciar_sesion() {
        console.log('funciona form');
        //this.loginUser(this.formData);
        /*
        this.mensaje_error=''
        this.mensaje_error=''
        this.hay_error=false;
        var email= this.email
        var paswd= this.passwd
        if (this.email && this.passwd)
        {
          if (true)//email == "jorger6013@hotmail.com" && paswd == "Eduar6013")
          {
            console.log("Paso a la ventana principal");
            //this.$router.push('main')
            this.$router.push({ path: 'main' })



          }
          else
          {
            this.hay_error=true;
            this.mensaje_error= 'Email y/o contraseña incorrectos';
          }
        }
        else
        {
            this.hay_error=true;
            this.mensaje_error = 'Debes introducir email y contraseña';
        }*/
        
      }
    }
  };
</script>