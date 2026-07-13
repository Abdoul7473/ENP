<template>
    <v-menu
        ref="menu"
        v-model="datePicker"
        :nudge-right="40"
        transition="scale-transition"
        min-width="200px"
        :close-on-content-click="false"
        :return-value="innerValue"
    >
        <template v-slot:activator="{ on, attrs }">
            <ValidationProvider :name="$attrs.name" :rules="rules" v-slot="{ errors, valid }">
                <v-text-field
                    v-model="computedDate"
                    append-icon="mdi-calendar"
                    :label="label"
                    readonly
                    outlined
                    v-bind="$attrs"
                    v-on="$listeners"
                    :error-messages="errors"
                    @click="datePicker = true"
            >
                <template v-if="required" #label>
                    <span id="required-field">{{ label }}</span>
                </template>
                <template v-else #label> {{ label }} </template>
            </v-text-field>
            </ValidationProvider>
        </template>
        <v-date-picker color="secondary" header-color="primary" v-on="$listeners"  v-bind="$attrs" :locale="'fr'" v-model="innerValue">

        </v-date-picker>
    </v-menu>
</template>

<script>
import { ValidationProvider } from "vee-validate";

export default {
    data()  {
        return {
            datePicker: false,
            innerValue: '',

        }
    },
    components: {ValidationProvider},
    props: {
        value: {
            type: null
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

    computed: {
        computedDate() {``
            if (!this.innerValue) return null
            if(this.innerValue instanceof Array) {
                const [year, month, day] = this.innerValue[1].split('-')
                const begin =  `${day}/${month}/${year}`
                let end = ' '
                if(this.innerValue[0]) {
                    const [a, b, c] = this.innerValue[0].split('-')
                    end = `${c}/${b}/${a}`
                }

                return begin+ ' au '+end
            }

            if(this.$attrs.type==='month') {
                const [year, month] = this.innerValue.split('-')
                return `${month}/${year}`
            }

            const [year, month, day] = this.innerValue.split('-')
            return `${day}/${month}/${year}`
        }
    },

    watch: {
        // Handles internal model changes.
        innerValue(newVal) {
            this.datePicker = false
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


