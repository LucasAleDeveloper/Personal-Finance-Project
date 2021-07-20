
import firebase from 'firebase/app';

import "firebase/storage";
import "firebase/firestore"
import "firebase/auth"

import "firebase/analytics"

// Agregar configuración firebase:
var firebaseConfig = {
  apiKey: "AIzaSyBIQB7_dA1ntO-s_Vv_5hsY_K3FlTye_OM",
  authDomain: "geome7ric-weasel.firebaseapp.com",
  projectId: "geome7ric-weasel",
  storageBucket: "geome7ric-weasel.appspot.com",
  messagingSenderId: "560415720731",
  appId: "1:560415720731:web:9331dc52aa118452ae3fbe",
  measurementId: "G-CB1ZV2VNMB"
  };

let firebaseApp = firebase.initializeApp(firebaseConfig);
//let firebaseAnalytics =firebase.analytics();
let firebaseAuth = firebaseApp.auth()
let db = firebase.firestore();

export { firebaseAuth, db }