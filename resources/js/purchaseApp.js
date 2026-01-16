import './bootstrap';
import { createApp } from 'vue';
import PurchaseApp from './components/PurchaseApp.vue';

// Vue.jsアプリケーションを初期化
const app = createApp(PurchaseApp);
app.mount('#purchase-app');


