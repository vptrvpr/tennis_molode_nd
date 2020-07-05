<template>
    <div class="general__preloader">
        <v-overlay :value="preloaders.length !== 0" z-index="9900" opacity=".65">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-center">
                    <v-progress-circular
                        :size="120"
                        width="6"
                        :color="$blue"
                        indeterminate
                    />
                </div>
                <div class="col-md-12 text-center">
                    <h4 style="font-weight: 700;font-size: 1.5rem;">Пожалуйста, подождите...</h4>
                </div>
            </div>
        </v-overlay>
    </div>
</template>

<script>
    import { mapGetters } from "vuex";

    export default {
        name: "Preloader",
        computed: mapGetters( {
            preloaders: 'preloader/preloaders'
        } ),
    }
</script>

<style scoped>

</style>
