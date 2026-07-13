<template>
    <v-menu
        v-model="menu"
        :close-on-content-click="false"
        :nudge-right="40"
        transition="scale-transition"
        offset-y
        ref="menu"
        min-width="auto"
    >
        <template v-slot:activator="{ on, attrs }">
            <ValidationProvider :name="$attrs.name" :rules="rules" v-slot="{ errors, valid }">
            <v-text-field
                v-model="computedDate"
                :label="label"
                append-icon="mdi-calendar"
                readonly
                outlined
                v-bind="$attrs"
                v-on="$listeners"
                @click="menu = true"
                :error-messages="errors"
            >
                <template v-if="required == true" #label>
                    <span id="required-field">{{ label }}</span>
                </template>
                <template v-else #label> {{ label }} </template>
            </v-text-field>
            </ValidationProvider>
        </template>
        <v-date-picker
            color="secondary" 
            header-color="primary"
            v-bind="$attrs"
            v-on="$listeners"
            range
            v-model="innerValue"
            @input="innerValue.length === 2 ? $refs.menu.save(innerValue) : null"
            :locale="'fr'"
        ></v-date-picker>
    </v-menu>
</template>
<script>
import {ValidationProvider} from "vee-validate";

export default {
    data() {
        return {
            innerValue: [],
            menu: false
        }
    },
    props: {
        value: {
            type: Array,
            default: () => []
        },
        label: {
            type: String
        },
        rules: {
            type: [String, Array],
            default: ""
        },
        required: { type: Boolean, default: false },
    },
    components: {ValidationProvider},
    watch: {
        // Handles internal model changes.
        innerValue(newVal) {
            this.$emit("input", newVal);
        },
        // Handles external model changes.
        value(newVal) {
            this.innerValue = newVal;
        }
    },
    computed: {
        computedDate() {
            return this.innerValue.map(el => this.$formatDate(el, false)).join(' - ')
        }
    },
    created() {
        if (this.value) {
            this.innerValue = this.value;
        }
    }
}
</script>
