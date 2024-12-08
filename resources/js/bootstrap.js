import axios from 'axios';
import cep from './cep';
window.axios = axios;
window.searchByCep = cep;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
