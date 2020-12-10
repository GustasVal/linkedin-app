require('./bootstrap');
import Vuetify from 'vuetify';
import App from './components/App';
import Drawer from "./components/Drawer";
import Footer from './components/Footer';
import VueRouter from 'vue-router';
import Profiles from './components/Profiles';
import Posts from './components/Posts';
import ProfileList from './components/ProfileList';
import Comments from './components/Comments';

window.Vue = require('vue');

Vue.use(Vuetify);
Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: App
        },
        {
            path: '/profiles',
            name: 'profiles',
            component: Profiles
        },
        {
            path: '/posts',
            name: 'posts',
            component: Posts
        },
        {
            path: '/profile-list',
            name: 'profile-list',
            component: ProfileList
        },
        {
            path: '/comments',
            name: 'comments',
            component: Comments
        }
    ]
})

const app = new Vue({
    el: '#app',
    components: {
        App,
        Footer,
        Drawer,
    },
    vuetify: new Vuetify(),
    router
});
