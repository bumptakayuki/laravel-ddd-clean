import './bootstrap';
import { createApp } from 'vue';
import StoreApp from './components/StoreApp.vue';

// Vue.jsアプリケーションを初期化
const app = createApp(StoreApp);
app.mount('#store-app');



