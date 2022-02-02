/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';


// start the Stimulus application
// import 'bootstrap';
// import './bootstrap';


import Vue from 'vue'
import App from './vue/App'
// import axios from 'axios';
import router from './vue/router';
import store from './vue/store/store';


// // Attribution d'axios à $http
// Vue.prototype.$http = axios;

// axios.defaults.baseURL = 'https://127.0.0.1:8001/api';


// App 
new Vue({ 
  store,
  router,
  render: h => h( App ) 
}).$mount('#app')
