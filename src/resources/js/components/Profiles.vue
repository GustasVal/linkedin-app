<template>
    <v-main class="container mt-8 px-1">
        <h2 class="font-weight-light mb-2">
            Profiles
        </h2>
        <v-card>
            <v-data-table
                :headers="headers"
                :items="items">
                <template v-slot:item.actions="{ item }">
                    <div class="text-truncate">
                        <v-icon
                            class="mr-2"
                            @click="showEditDialog(item)"
                            color="primary"
                        >
                            mdi-pencil
                        </v-icon>
                        <v-icon
                            @click="deleteItem(item)"
                            color="pink"
                        >
                            mdi-delete
                        </v-icon>
                    </div>
                </template>
            </v-data-table>
            <!-- this dialog is used for both create and update -->
            <v-dialog v-model="dialog">
                <template v-slot:activator="{ on }">
                    <div class="d-flex">
                        <v-btn
                            color="primary"
                            dark v-on="on"
                            class="mb-4 ml-4"
                        >
                            New
                        </v-btn>
                    </div>
                </template>
                <v-card>
                    <v-card-title>
                        <span v-if="editedItem.id">Edit {{editedItem.id}}</span>
                        <span v-else>Create</span>
                    </v-card-title>
                    <v-card-text>
                        <v-row>
                            <v-col cols="12" sm="4">
                                <v-text-field v-model="editedItem.email" label="Email"></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="8">
                                <v-text-field v-model="editedItem.last_name" label="Lastname"></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" sm="4">
                                <v-text-field v-model="editedItem.address" label="Address"></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="8">
                                <v-text-field v-model="editedItem.number" label="Number"></v-text-field>
                            </v-col>
                        </v-row>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue" text @click="showEditDialog()">Cancel</v-btn>
                        <v-btn color="blue" text @click="saveItem(editedItem)">Save</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-card>
    </v-main>
</template>

<script>
export default {
    data () {
        return {
            headers: [
                { text: 'Id', value: 'id', width:"100" },
                { text: 'Email', value: 'email' },
                { text: 'Lastname', value: 'last_name' },
                { text: 'Address', value: 'address' },
                { text: 'Number', value: 'number' },
                { text: 'Actions', value: 'actions', sortable: false },
            ],
            items: [],
            dialog: false,
            editedItem: {}
        }
    },
    computed: {
        token: function () {
            return localStorage.getItem('bearer');
        },
        userId: function () {
            return JSON.parse(atob(this.token.split('.')[1])).userId;
        }
    },
    mounted() {
        this.loadItems()
    },
    methods: {
        showEditDialog(item) {
            this.editedItem = item||{}
            this.dialog = !this.dialog
        },
        loadItems() {
            this.items = []
            axios.get(`/api/v1/users/${this.userId}/profile`,
                { headers: { Authorization: "Bearer " + this.token }})
                .then((response) => {
                    // load the API response into items for datatable
                    this.items = response.data.data.map((item)=>{
                        return {
                            id: item.id,
                            email: item.email,
                            last_name: item.last_name,
                            address: item.address,
                            number: item.number
                        }
                    })
                }).catch((error) => {
                console.log(error)
            })
        },
        saveItem(item) {
            let method = "post"
            let url = `/api/v1/users/${this.userId}/profile`
            let id = item.id

            if (id) {
                // if the item has an id, we're updating an existing item
                method = "patch"
                url = `/api/v1/users/${this.userId}/profile/${id}`
            }

            axios[method](url,
                item,
                { headers: {
                        Authorization: "Bearer " + this.token,
                        "Content-Type": "application/json"
                    }
                }).then((response) => {
                if (response.data.id) {
                    if (!id) {
                        item.id = response.data.id;
                        this.items.push(item);
                    }
                    this.editedItem = {}
                }
                this.dialog = !this.dialog
            })
        },
        deleteItem(item) {
            let id = item.id
            let idx = this.items.findIndex(item => item.id===id)
            if (confirm('Are you sure you want to delete this?')) {
                axios.delete(`/api/v1/users/${this.userId}/profile/${id}`,
                    { headers: {
                            Authorization: "Bearer " + this.token,
                            "Content-Type": "application/json"
                        }
                    }).then((response) => {
                    this.items.splice(idx, 1)
                })
            }
        },
    }
}
</script>
