<template>
    <div class="mb-4">
        <v-data-table
            dense
            calculate-widths
            disable-pagination
            v-bind="$attrs"
            v-on="$listeners"
            :headers="headers"
            class="my-3 pt-3"
            style="border: 1px solid rgb(245, 134, 52)"
            hide-default-footer
        >
            <template v-for="(index, name) in $slots" v-slot:[name]>
                <slot :name="name"></slot>
            </template>

            <template v-for="(index, name) in $scopedSlots" v-slot:[name]="data">
                <slot :name="name" v-bind="data"></slot>
            </template>

        </v-data-table>
    </div>
</template>

<script>

export default {
    props: ['headers'],
    data() {
        return {

        }
    },
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
    }
}
</script>
