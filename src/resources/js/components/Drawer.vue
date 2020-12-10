<template>
    <div>
        <v-list-item>
            <v-list-item-avatar>
                <v-img src="https://randomuser.me/api/portraits/men/78.jpg"></v-img>
            </v-list-item-avatar>

            <v-list-item-content>
                <v-list-item-title>John Leider</v-list-item-title>
            </v-list-item-content>
        </v-list-item>

        <v-divider></v-divider>

        <v-list dense>
            <v-list-item
                v-for="item in items"
                :key="item.title"
                link
            >
                <v-list-item-icon>
                    <v-icon>{{ item.icon }}</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <router-link :to='item.to'>
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </router-link>
                </v-list-item-content>
            </v-list-item>
        </v-list>
    </div>
</template>

<script>
export default {
    data () {
        return {
            items: [
                { to: '/profiles', title: 'Profiles', icon: 'mdi-view-dashboard' },
                { to: '/posts', title: 'Posts', icon: 'mdi-forum' },
                { to: '/profile-list', title: 'Profile List', icon: 'mdi-forum' },
                { to: '/comments', title: 'Comments', icon: 'mdi-forum' },
            ],
        }
    },
}
</script>
