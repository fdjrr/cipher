import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Alpine from 'alpinejs'
import persist from '@alpinejs/persist'

window.Alpine = Alpine
Alpine.plugin(persist)
Alpine.start()
