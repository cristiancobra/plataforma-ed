import { createApp } from 'vue';
import DivStatus from './components/show/DivStatus.vue';
import DivPriority from './components/show/DivPriority.vue';

const app = createApp({});

app.component('div-status', DivStatus);
app.component('div-priority', DivPriority);

app.mount('#app');