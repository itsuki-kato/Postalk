import './bootstrap';
import '../css/app.css';
import { createApp } from 'vue';

// alertコンポーネントの表示テスト。
import showAlert from './alert.vue';
const alert = createApp(showAlert);
alert.mount('#vue-test');

// ドロップダウンメニューコンポーネントのテスト。
import test from './select.vue';
const selectFruits = createApp(test);
selectFruits.mount('#vue-test2');
