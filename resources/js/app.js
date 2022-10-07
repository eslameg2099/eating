require('./bootstrap');
import Vue from 'vue';
// import vSelect from 'vue-select'

// import 'vue-select/dist/vue-select.css';

import * as VueGoogleMaps from 'vue2-google-maps'

// import FileUploader from 'laravel-file-uploader';

// Vue.use(FileUploader);

let key = document.head.querySelector('meta[name="google-key"]');
Vue.use(VueGoogleMaps, {
  load: {
    key: key.content,
    // key: 'AIzaSyDpv1ZHHnt6FoUMxlDa1p-T1HTCG67Tg1w',
    libraries: 'places,geometry,geocoder', // This is required if you use the Autocomplete plugin
    // OR: libraries: 'places,drawing'
    // OR: libraries: 'places,d rawing,visualization'
    // (as you require)
    language: 'ar',

  },
  installComponents: true
})


Vue.component('google-map-marker', require('./components/GoogleMapMarker').default);
// Vue.component('shops-select', require('./components/ShopsSelectComponent').default);
// Vue.component('v-select', vSelect)

const app = new Vue({
  el: '#app',
});