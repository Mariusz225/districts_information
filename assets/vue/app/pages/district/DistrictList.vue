<script>
export default {
    name: "DistrictList",
    data() {
        return {
            districtsAreLoaded: false,

            filters: {
                name: '',
                minArea: null,
                maxArea: null,
                minPopulation: null,
                maxPopulation: null,
                sortBy: 'name',
                sortOrder: 'asc',
            },
        };
    },
    computed: {
        districts() {
            return this.$store.getters['districts/districts']
        },
    },
    methods: {
        async loadDistricts() {
            try {
                await this.$store.dispatch('districts/loadDistricts', {
                    filters: this.filters,
                    sortBy: this.sortBy,
                    sortOrder: this.sortOrder
                })
            } catch (error) {
            }
            this.districtsAreLoaded = true;
        },

    },

    created() {
        this.loadDistricts();
    },
}
</script>

<template>
    <router-link :to="{ name: 'districtCreate'}">Stwórz nową dzielnicę</router-link>

    <div>
        <div>
            <label>Nazwa:</label>
            <input v-model="filters.name" />
        </div>
        <div>
            <label>Powierzchnia od:</label>
            <input type="number" v-model="filters.minArea" />
            <label>do:</label>
            <input type="number" v-model="filters.maxArea" />
        </div>
        <div>
            <label>Liczba ludności od:</label>
            <input type="number" v-model="filters.minPopulation" />
            <label>do:</label>
            <input type="number" v-model="filters.maxPopulation" />
        </div>
        <div>
            <label>Sortuj:</label>
            <select v-model="filters.sortBy">
                <option value="name">Nazwa</option>
                <option value="area">Powierzchnia</option>
                <option value="population">Liczba ludności</option>
            </select>
            <select v-model="filters.sortOrder">
                <option value="asc">Rosnąco</option>
                <option value="desc">Malejąco</option>
            </select>
        </div>
        <button @click="loadDistricts">Filtruj i Sortuj</button>
        <ul v-if="districtsAreLoaded">
            <li v-for="district in districts" :key="district.id">
                {{ district.name }} - Powierzchnia: {{ district.area }}, Ludność: {{ district.population }}
                <router-link :to="{ name: 'districtView', params: {id: district.id}  }">Zobacz</router-link>
            </li>
        </ul>
    </div>
</template>

<style scoped>

</style>
