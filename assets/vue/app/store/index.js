import { createStore } from 'vuex';

import districtsModule from './modules/districts/index.js'

const store = createStore({
  modules: {
    districts: districtsModule,
  },
})

export default store;
