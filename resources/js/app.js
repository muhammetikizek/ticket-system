import './bootstrap';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

import { createApp } from 'vue';

import OrderMaster from './components/OrderMaster.vue';

createApp({})
.component('order-master', OrderMaster)
.use(VueSweetalert2)
.mount('#app');
