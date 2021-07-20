<template>

  <q-layout view="hHh lpR fFf">
    
    <q-page-container class="bg-primary window-height window-width row justify-center items-center"> 
      
      <div class="column ">
          
        <div class="row " >
            <h5 class="text-h5 text-white q-my-md">Regístrate</h5>
        </div>
        <div class="row  " >
          
            <q-card square bordered class="q-pa-lg  shadow-1" style="max-width: 1500px;width:400px;">
            <q-card-section>
                <q-form class="q-gutter-md ">
                  <q-form
                    
                    class="q-gutter-md "
                  >
                    <q-input
                      filled
                      v-model="nombre_user"
                      hint="Tu nombre de pila"
                      lazy-rules
                      autofocus
                      :rules="[ val => val && val.length > 0 || 'Por favor, ingresa un nombre']"
                    />
                    <q-input
                      filled
                      v-model="email_user"
                      hint="El em@il que utilices"
                      lazy-rules
                      :rules="[ val => val && val.length > 0 || 'Por favor, ingresa un email']"
                    />
                    <q-input v-model="password_user" square filled clearable type="password"  hint="Contraseña"  lazy-rules 
                      :rules="[ val => val && val.length > 0 || 'Por favor, ingresa una contraseña']" />
                    <q-input v-model="check_password_user" square filled clearable type="password" hint="Vuelve a escribir la contraseña"  lazy-rules
                      :rules="[ val => val && val.length > 0 || 'Por favor, ingresa la contraseña']"/>
                    
                    <q-separator></q-separator>

                    
                  </q-form>
                </q-form>
            </q-card-section>
            <q-card-actions class="q-px-md">
                <q-btn @click="intentar_registro" unelevated color="secondary" size="lg" class="full-width" label="Registrarme" />
                <q-btn @click="ir_iniciar_sesion" unelevated color="primary" icon="arrow_left" size="lg" class="full-width" label="Iniciar sesión" />
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
              style="color:#ffffff">@jmphul @matiasjrios @lucasale @jmpoio</a>
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
      //url_base: "http://192.168.0.16/php/v1/Api.php?apicall=",
      password_user: null,
      check_password_user: null,
      email_user: null,
      bandera_registro: false,
      nombre_user: null,
      url_base: "https://matiasjrb.com.ar/php_bullmetal/v1/Api.php?apicall=",
      is_admin: false,
      formData: {email: 'mjrcal95@hotmail.com.ar', password: 'Matiasjrb95!'},
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
      console.log("register");
    }
    ,
    methods: { 
      ir_iniciar_sesion()
      {
        this.$router.push({ path: '/' });
      }, 
      validar_datos_registro()
      {
        //verifico los datos ingresados por el usuario
        // tambien se encarga de mostrar por pantalla que dato seria el incorrecto
        return true;
      },
      async registrar_usuario()
      {
        /*
        
        @mjr= deberia enviar el email de verificacion pero no me sale :(

        */
        console.log("submiteo el registro "+this.email_user);
        var actionCodeSettings = {
          // URL you want to redirect back to. The domain (www.example.com) for this
          // URL must be in the authorized domains list in the Firebase Console.
          url: 'google.com',
          // This must be true.
          handleCodeInApp: true,
          iOS: {
            bundleId: 'com.example.ios'
          },
          android: {
            packageName: 'com.example.android',
            installApp: true,
            minimumVersion: '12'
          }
        };
         await firebase.auth().createUserWithEmailAndPassword(this.email_user, this.password_user)
            .then(function (firebaseUser) {
                console.log(firebaseUser.user);
                alert("usuario registrado con exito. habilitado");
            })
            .catch(function (error) {
                console.log(error);
            });
          firebase.auth().sendSignInLinkToEmail(this.email_user, actionCodeSettings)
                .then(() => {
                  // The link was successfully sent. Inform the user.
                  // Save the email locally so you don't need to ask the user for it again
                  // if they open the link on the same device.
                  window.localStorage.setItem('emailForSignIn', this.email_user);
                  Console.log("email enviado");
                  // ...
                })
                .catch((error) => {
                  var errorCode = error.code;
                  var errorMessage = error.message;
                  console.log(errorMessage);
                  alert("no te puedo enviar el email de verificacion")
                  // ...
                });
          
        
      },
      iniciar_ventana_registro()
      {
        //alert("Sesión iniciada correctamente");
        this.$router.push({ path: 'register' });
      },
      async iniciar_sesion()
      {
        const val= await firebase.auth().signInWithEmailAndPassword(this.formData.email,this.formData.password);
        console.log(val);
        const is_admin = await this.es_admin(this.formData.email);

        //alert("Sesión iniciada correctamente");
        this.$router.push({ path: 'main' });
      },
      async intentar_registro()
      {
        /*

        @mjr= aca deberia preguntar si se desea registrar con ese email
        
        */
        try
        {
          if (this.validar_datos_registro())
          {
            await this.registrar_usuario();
            this.$router.push({ path: '/' });      
          }
        }
        catch (err)
        {
          console.log(err);
          alert("Revisa tu email y contraseña");
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