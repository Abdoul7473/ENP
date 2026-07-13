<template>
    <admin-layout>
        <Toolbar icon="mdi-database-outline" Title="Générateur de requêtes" :breadcrumbs="breadcrumbs">
        </Toolbar>
        <v-card>
            <!-- <QueryB :tables="tables"/> -->
            <QueryBuilder :tables="tables"/>
            <SelectField
                v-model="peopleSelected"
                :items="people"
                filled
                chips
                color="blue-grey lighten-2"
                label="Select"
                item-text="name"
                item-value="name"
                multiple
            >
                <!-- Template for render selected data -->
                <template
                slot="selection"
                slot-scope="data"
                >
                <v-chip
                    :input-value="data.selected"
                    close
                    class="chip--select-multi"
                    @input="remove(data.item)"
                >
                    {{ data.item.name }}
                </v-chip>
                </template>
                <!-- Template for render data when the select is expanded -->
                <template
                slot="item"
                slot-scope="data"
                >
                <!-- Divider and Header-->
                <template v-if="typeof data.item !== 'object'">
                    <v-list-item-content>
                        <v-list-item-title>{{data.item}}</v-list-item-title>
                    </v-list-item-content>
                </template>
                <template v-else>
                    <v-list-item-content>
                        <v-list-item-title>{{ data.item.name }}</v-list-item-title>
                        <v-list-item-subtitle>{{ data.item.group }}</v-list-item-subtitle>
                    </v-list-item-content>
                </template>
                </template>
            </SelectField>
            <SelectFiled/>
            <QueryB/>
        </v-card>
    </admin-layout>
    </template>
    
    <script>
    import AdminLayout from "../../layouts/AdminLayout.vue"
    export default {
        components: {
            AdminLayout
        },
        props: ["tables"],
        data() {
            return {
                breadcrumbs: [
                    {
                        text: "Tableau de bord",
                        disabled: false,
                        href: "/home",
                    },
                    {
                        text: "Générateur de requêtes",
                        disabled: true,
                        href: "/query",
                    },
                ],
                peopleSelected:[],
                people: [
                    { header: 'Group 1' },
                    { name: 'Sandra Adams', group: 'Group 1' },
                    { name: 'Ali Connors', group: 'Group 1' },
                    { name: 'Trevor Hansen', group: 'Group 1' },
                    { name: 'Tucker Smith', group: 'Group 1'},
                    { divider: true },
                    { header: 'Group 2' },
                    { name: 'Britta Holt', group: 'Group 2'},
                    { name: 'Jane Smith ', group: 'Group 2'},
                    { name: 'John Smith', group: 'Group 2' },
                    { name: 'Sandra Williams', group: 'Group 2' }
                ]
            }
        },
        methods: {
            // active(item) {
            //     this.form.id = item.id
            //     this.$alert.confirm('Etes-vous sûr ?', "Vous allez activer ce compte postulant", () => {
            //         this.form.post(route("user.active"), {
            //             onFinish: () => {
            //                 // console.log(this.$page.props.flash)
            //                 // this.$alert.success(this.$page.props.flash.message)
            //                 if (this.$page.props.flash.success) {
            //                     this.$alert.success(this.$page.props.flash.success)
            //                 }
            //                 if (this.$page.props.flash.error) {
            //                     this.$alert.error(this.$page.props.flash.error)
            //                 }
    
            //             },
            //             onError: this.$alert.messages
            //         });
            //     })
            // },
        }
    }
    </script>
    