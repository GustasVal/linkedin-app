<template>
    <v-app>
        <v-navigation-drawer
            v-model="drawer"
            app
        >
            <Drawer />
        </v-navigation-drawer>

        <v-app-bar app>
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

            <v-toolbar-title>Application</v-toolbar-title>
        </v-app-bar>

        <v-main>
            <!--  -->
        </v-main>

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
}
</script>
