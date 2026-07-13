<template>
    <ValidationProvider :name="$attrs.name" :rules="rules" v-slot="{ errors, valid }">
        <v-currency-field
            autocomplete="off"
            :label="label"
            :min="0"
            v-if="currency"
            v-model="innerValue"
            outlined
            :error-messages="errors"
            v-bind="$attrs"
            v-on="$listeners"
        >
            <template v-if="required" #label>
                <span id="required-field">{{ label }}</span>
            </template>
            <template v-else #label> {{ label }} </template>
        </v-currency-field>
        <v-text-field
            v-else
            v-model="innerValue"
            outlined
            :label="label"
            dense
            :error-messages="errors"
            v-bind="$attrs"
            v-on="$listeners"
        >
            <template v-if="required" #label>
                <span id="required-field">{{ label }}</span>
            </template>
            <template v-else #label> {{ label }} </template>
        </v-text-field>
    </ValidationProvider>
</template>

<script>
import { ValidationProvider } from "vee-validate";

export default {

    data() {
        return {
            innerValue: "",
        }
    },
    components: {
        ValidationProvider
    },
    props: {
        label: {
            type: String
        },
        rules: {
            type: [Object, String],
            default: ""
        },
        // must be included in props
        value: {
            type: null
        },
        currency: {
            type: Boolean,
            default: false
        },
        withSymbol: {
            type: Boolean,
            default: false
        },
        precision: {
            type: Number,
            default: 0
        },
        required: { type: Boolean, default: false },
    },
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
        
    },

    created() {
        if (this.value) {
            this.innerValue = this.value;
        }
    }
};
</script>

<style>
.error-message {
  color: red;
}
#required-field::after {
  content: '*';
  color: red;
}
</style>