<template>
    <v-tooltip color="secondary lighten-2" bottom>
        <template v-slot:activator="{ on, attrs }">
            <v-btn
                @mouseenter=""
                v-bind="$attrs"
                v-on="$listeners"
            >
                <v-icon v-bind="attrs" v-on="on">{{ DisplayIcon }}</v-icon>
            </v-btn>
        </template>
        <span>{{ title }}</span>
    </v-tooltip>
</template>

<script>
export default {
    props: {
        DisplayIcon: String,
        title: String
    }
}
</script>
