<script>
import {toDataURL} from "../../helper/fileUtils";
export default {
    name: "DistrictView",
    props: {
        'id': Number
    },
    data() {
        return {
            districtIsLoaded: false,

            urlObject: null
        };
    },
    computed: {
        district() {
            return this.$store.getters['districts/district'](this.id)
        },
    },
    methods: {
        async loadDistrict() {
            try {
                await this.$store.dispatch('districts/loadDistrict', {
                    id: this.id
                })
            } catch (error) {
            }
            this.districtIsLoaded = true;
        },

        async updateDistrict() {
            if (this.urlObject !== null) {
                this.district.image = await toDataURL(this.urlObject).then((base64data => {
                    return base64data
                }))
                    .catch((error) => {
                        console.error('Błąd podczas konwersji do base64:', error.message);
                    });
            }


            try {
                await this.$store.dispatch('districts/updateDistrict', {
                    district: this.district,
                })
            } catch (error) {
            }
            this.districtIsLoaded = true;
        },

        onFileChange(e) {
            const file = e.target.files[0];
            this.urlObject = URL.createObjectURL(file);
        }

    },

    created() {
        this.loadDistrict();
    },
    updated() {
        this.loadDistrict()
    }
}
</script>

<template>

    <div v-if="districtIsLoaded">

        <div>
            <label>Nazwa:</label>
            <input v-model="district.name" />
        </div>
        <div>
            <label>Powierzchnia:</label>
            <input v-model="district.area" />
        </div>
        <div>
            <label>Liczba ludności:</label>
            <input v-model="district.population" />
        </div>

        <div>
            <input type="file" @change="onFileChange" />

            <div id="preview">
                <img v-if="urlObject" :src="urlObject"  alt=""/>
            </div>
        </div>

        <button @click="updateDistrict">Zaktualizuj dzielnicę</button>
    </div>
</template>

<style scoped>



#preview {
    display: flex;
    justify-content: left;
    align-items: center;
}

#preview img {
    max-width: 100%;
    max-height: 100px;
}
</style>
