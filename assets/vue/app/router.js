import {createRouter, createWebHistory} from "vue-router";

import DistrictList from './pages/district/DistrictList.vue';
import DistrictView from './pages/district/DistrictView.vue';

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {path: '/', component: DistrictList, name:'districtList'},
    {path: '/:id', component: DistrictView, name:'districtView', props: true},
  ]
});

export default router;
