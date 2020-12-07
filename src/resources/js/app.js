require('./bootstrap');

import App from './components/App';

window.Vue = require('vue');
window.Vuetify = require('vuetify');

Vue.use(Vuetify);

const app = new Vue({
    el: '#app',
    components: {
        App
    },
    vuetify: new Vuetify(),
});
