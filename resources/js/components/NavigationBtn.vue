<template>
    <v-btn  v-bind="$attrs" v-on="$listeners">
        <Link style="text-decoration: none; color: inherit" v-bind="$attrs"
        v-on="$listeners">
            <slot></slot>
        </Link>
        </v-btn>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'

export default {
    name: 'sqsqs',
    components:{Link}
}
</script>
