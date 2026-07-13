<template>
    <div class="mb-4">
        <v-data-table disable-pagination calculate-widths v-bind="$attrs" v-on="$listeners" :headers="headers" :items="items" dense class="my-3 pt-3" style="border: 1px solid rgb(245, 134, 52)" hide-default-footer>
            <template v-slot:top>
                <v-toolbar rounded flat dense>
                    <slot name="addBtn"></slot>
                    <v-spacer></v-spacer>
                    <v-spacer></v-spacer>
                    <v-spacer></v-spacer>
                    <v-spacer></v-spacer>
                    <v-text-field v-model="search" @change="getItems" prepend-inner-icon="mdi-search-web" clearable single-line hide-details outlined dense placeholder="Recherche..."></v-text-field>
                </v-toolbar>
            </template>
            <template v-for="(index, name) in $slots" v-slot:[name]>
                <slot :name="name"></slot>
            </template>
    
            <template v-for="(index, name) in $scopedSlots" v-slot:[name]="data">
                <slot :name="name" v-bind="data"></slot>
            </template>
    
        </v-data-table>
        <div class="mx-3">
            <v-pagination :total-visible="7" circle @input="fetchPage" v-model="items.current_page" :length="items.last_page" prev-icon="mdi-menu-left" next-icon="mdi-menu-right">
            </v-pagination>
        </div>
    
    </div>
    </template>
    
    <script lang="js">
    export default {
        props: {
            items: {
                type: [Array, Object]
            },
            headers: {
                type: Array
            }
        },
        watch: {
            search: {
                handler() {
                    this.getItems()
                }
            },
        },
        methods: {
            getItems() {
                const obj = {}
                if (this.options.itemsPerPage) {
                    obj.per_page = this.options.itemsPerPage
                }
                this.$inertia.replace(this.$page.url, {
                    data: {
                        search: this.search,
                        ...obj
                    }
                })
            },
            fetchPage(page) {
                this.$inertia.replace(this.$page.url, {
                    data: {
                        page: page
                    }
                })
            },
        },
        data: () => ({
            search: '',
            options: {},
            total: 0,
            perPages: [{
                    value: 10,
                    text: 10
                },
                {
                    value: 30,
                    text: 30
                },
                {
                    value: 50,
                    text: 50
                },
                {
                    value: 100,
                    text: 100
                },
            ]
        }),
        created() {
            this.headers.forEach((item, i, items) => {
                if (i === 0) {
                    item.class = 'primary white--text rounded-l-xl'
                } else if (i === items.length - 1) {
                    item.class = 'primary white--text rounded-r-xl'
                } else {
                    item.class = 'primary white--text'
                }
                item.divider = true
            })
            this.$root.$on('reload', () => {
                this.getItems()
            })
        },
    }
    </script>