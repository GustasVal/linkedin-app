require('./bootstrap');
import Vuetify from 'vuetify';
import App from './components/App';
import Drawer from "./components/Drawer";
import Footer from './components/Footer';

window.Vue = require('vue');

Vue.use(Vuetify);

const app = new Vue({
    el: '#app',
    components: {
        App,
        Footer,
        Drawer,
    },
    vuetify: new Vuetify(),
});
