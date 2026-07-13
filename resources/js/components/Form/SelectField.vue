<template>
    <ValidationProvider :name="$attrs.name" :rules="rules" v-slot="{ errors, valid }">
        <v-autocomplete
            v-model="innerValue"
            outlined
            dense
            :multiple="multiple"
            :label="label"
            :error-messages="errors"
            v-bind="$attrs"
            v-on="$listeners"
        >
            <template v-for="(index, name) in $slots" v-slot:[name]>
                <slot :name="name"></slot>
            </template>

            <template v-for="(index, name) in $scopedSlots" v-slot:[name]="data">
                <slot :name="name" v-bind="data"></slot>
            </template>
            <template v-if="required" #label>
                <span id="required-field">{{ label }}</span>
            </template>
            <template v-else #label> {{ label }} </template>
        </v-autocomplete>
    </ValidationProvider>
</template>

<script>
import { ValidationProvider } from "vee-validate";

export default {
    data() {
        return {
            innerValue: ''
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
        value: {
            type: null
        },
        required: { type: Boolean, default: false },
        multiple: { type: Boolean, default: false },
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
    created() {
        if (this.value) {
            this.innerValue = this.value;
        }
    }
}
</script>
