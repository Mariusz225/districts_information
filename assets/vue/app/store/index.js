import { createStore } from 'vuex';

import districtsModule from './modules/districts/index.js'
import citiesModule from './modules/cities/index.js'

const store = createStore({
  modules: {
    districts: districtsModule,
    cities: citiesModule,
  },
})

export default store;
