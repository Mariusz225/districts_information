import {createRouter, createWebHistory} from "vue-router";

import DistrictList from './pages/district/DistrictList.vue';
import DistrictCreate from './pages/district/DistrictCreate.vue';
import DistrictView from './pages/district/DistrictView.vue';

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {path: '/', component: DistrictList, name:'districtList'},
    {path: '/create', component: DistrictCreate, name:'districtCreate'},
    {path: '/:id', component: DistrictView, name:'districtView', props: ({params}) => ({id: Number.parseInt(params.id, 10) || undefined})},
  ]
});

export default router;
