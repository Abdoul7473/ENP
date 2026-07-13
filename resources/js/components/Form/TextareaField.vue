<template>
    <ValidationProvider :name="$attrs.name" :rules="rules" v-slot="{ errors, valid }">
        <v-textarea
            v-model="innerValue"
            :label="label"
            outlined
            :error-messages="errors"
            v-bind="$attrs"
            v-on="$listeners"
        >
            <template v-if="required" #label>
                <span id="required-field">{{ label }}</span>
            </template>
            <template v-else #label> {{ label }} </template>
        </v-textarea>
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
        // must be included in props
        value: {
            type: null
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