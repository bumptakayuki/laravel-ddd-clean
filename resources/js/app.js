import './bootstrap';
import { createApp } from 'vue';
import OrderApp from './components/OrderApp.vue';

// Vue.jsアプリケーションを初期化
const app = createApp(OrderApp);
app.mount('#app');
