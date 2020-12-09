<template>
    <v-main class="container mt-8 px-1">
        <h2 class="font-weight-light mb-2">
            Posts
        </h2>
        <v-card>
            <v-data-table
                :headers="headers"
                :items="items">
            </v-data-table>
        </v-card>
    </v-main>
</template>

<script>
export default {
    data () {
        return {
            headers: [
                { text: 'Id', value: 'id' },
                { text: 'Name', value: 'Name' },
                { text: 'Details', value: 'details', sortable: false, width:"100" },
                { text: 'URL', value: 'url', name:'url', width:"180" },
                { text: 'Action', value: 'actions', sortable: false },
            ],
            items: [],
            dialog: false,
            editedItem: {}
        }
    },
    computed: {
        token: function () {
            return localStorage.getItem('bearer');
        }
    },
    mounted() {
        this.loadItems()
    },
    methods: {
        loadItems() {
            let jwt = JSON.parse(atob(this.token.split('.')[1]));
            this.items = []
            axios.get(`/api/v1/`,
                { headers: { Authorization: "Bearer " + apiToken }})
                .then((response) => {
                    // load the API response into items for datatable
                    this.items = response.data.records.map((item)=>{
                        return {
                            id: item.id,
                            ...item.fields
                        }
                    })
                }).catch((error) => {
                console.log(error)
            })
        }
    }
}
</script>
