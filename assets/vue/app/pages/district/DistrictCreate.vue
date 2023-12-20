<script>
export default {
    name: "DistrictCreate",
    data() {
        return {
            citiesAreLoaded: false,
            district: {
                cityId: null,
                name: '',
                area: null,
                population: null
            },
        };
    },
    computed: {
        districts() {
            return this.$store.getters['cities/cities']
        },
    },
    methods: {
        async loadCities() {
            try {
                await this.$store.dispatch('cities/loadCities', {
                })
            } catch (error) {
            }
            this.citiesAreLoaded = true;
        },
        async createDistrict() {
            try {
                await this.$store.dispatch('districts/createDistrict', {
                    district: this.district,
                })
            } catch (error) {
            }
            this.districtIsLoaded = true;
        },
    },

    created() {
        this.loadCities();
    }
}
</script>

<template>

    <div>
        <div>
            <label>Miasto:</label>
            <select v-model="district.cityId">
                <option v-for="city in districts" :key="city.id" :value="city.id">{{ city.name }}</option>
            </select>
        </div>

        <div>
            <label>Nazwa:</label>
            <input v-model="district.name" />
        </div>
        <div>
            <label>Powierzchnia (w kilometrach):</label>
            <input v-model="district.area" type="number"/>
        </div>
        <div>
            <label>Liczba ludności:</label>
            <input v-model="district.population" type="number"/>
        </div>

        <button @click="createDistrict">Stwórz dzielnicę</button>
    </div>
</template>

<style scoped>

</style>
