<template>
    <div>
        <v-layout row style="margin-bottom: 20px">
            <v-flex xs10>
                <h1>{{date}} {{year}} {{make}} {{model}} {{miles}}</h1>
            </v-flex>
            <v-flex xs2 style="text-align: right">
                <v-btn class="error" @click="deleteSelected">Delete</v-btn>
            </v-flex>
        </v-layout>
        <v-layout row>
            <v-flex xs3>
                <h3>Number of Miles</h3>
            </v-flex>
            <v-flex xs9>
                <h3>{{miles}}</h3>
            </v-flex>
        </v-layout>
        <v-layout row>
            <v-flex xs3>
                <h3>Total Miles</h3>
            </v-flex>
            <v-flex xs9>
                <h3>{{total}}</h3>
            </v-flex>
        </v-layout>

    </div>
</template>

<script>
    import {traxAPI} from "../../traxAPI";
    export default {
        props: [],
        mounted() {
            console.log('Component TripView mounted.')
            this.fetch();
        },
        created() {
            console.log('Component TripView created.')
        },
        data() {
            return {
                date: null,
                miles: null,
                total: null,
                year: null,
                make: null,
                model: null,
            }
        },
        watch: {},
        computed: {},
        methods: {
            fetch() {
                axios.get(traxAPI.tripsEndpoint(this.$route.params.id))
                    .then(response => {
                        this.date = response.data.data.date;
                        this.miles = response.data.data.miles;
                        this.total = response.data.data.total;
                        this.year = response.data.data.car.year;
                        this.make = response.data.data.car.make;
                        this.model = response.data.data.car.model;
                    }).catch(e => {
                    console.log(e);
                });
            },
            deleteSelected() {
                axios.delete(traxAPI.tripsEndpoint(this.$route.params.id))
                    .then(response => {
                        console.log(response)
                        this.$router.push('/trips');
                    }).catch(e => {
                        alert('Failed To Delete')
                });
            }
        },
        components: {}
    }
</script>

<style scoped lang="scss">

</style>
