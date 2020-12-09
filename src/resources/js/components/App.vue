<template>
    <v-app>
        <v-navigation-drawer
            v-model="drawer"
            app
        >
            <Drawer v-if="logged" />
            <v-btn
                v-else
                href="/api/v1/auth"
                color="primary"
                class="mt-4 ml-4 mr-4 d-flex"
            >
                Login
            </v-btn>
        </v-navigation-drawer>

        <v-app-bar app>
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

            <v-toolbar-title>Application</v-toolbar-title>
        </v-app-bar>

        <router-view></router-view>

        <Footer />
    </v-app>
</template>

<script>
import Footer from "./Footer";
import Drawer from "./Drawer";

export default {
    components: {
        Footer,
        Drawer
    },
    data: () => ({ drawer: false }),
    computed: {
        logged: function () {
            return localStorage.getItem('bearer');
        }
    },
    methods: {

    },
    mounted(){
        if (!this.logged) {
            let url = new URL(window.location.href);
            let jwt = url.searchParams.get("jwt");
            if (jwt !== null) {
                localStorage.setItem('bearer', jwt);
                window.location = window.location.href.split("?")[0];
                axios.defaults.headers.common['Authorization'] = `Bearer ${jwt}`;
            }
        }
    }
}
</script>
