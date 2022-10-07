<template>
  <div>
    <label>
      <gmap-autocomplete
          class="map-search"
          placeholder="ابحث في الخريطة"
          @keydown.enter.prevent="onSearchEnter"
          @place_changed="setPlace">
      </gmap-autocomplete>
    </label>
    <GmapMap
        :center="centerMap"
        :zoom="mapZoom"
        map-type-id="terrain"
        :style="`height: ${height}px; width:100%`"
        ref="mapRef"
        @click="markerDragged"
    >
      <GmapMarker
          :position="getMarkerPosition"
          :clickable="true"
          :draggable="true"
          @dragend="markerDragged"
      />
    </GmapMap>
    <input type="hidden" :name="latInputName" :value="latValue">
    <input type="hidden" :name="lngInputName" :value="lngValue">
  </div>
</template>
<style scoped>
.map-search {
  height: 50px;
  width: 500px;
  position: relative;
  bottom: -50px;
  z-index: 1;
  border: 1px solid #ccc;
  padding: 10px;
  outline: none;
  margin: 0 auto;
  background: #fff;
}
</style>
<script>
import {gmapApi} from 'vue2-google-maps'

export default {
  props: {
    addressInput: {
      type: String,
      required: false,
      default: '#address',
    },
    latInputName: {
      type: String,
      required: false,
      default: 'lat',
    },
    lngInputName: {
      type: String,
      required: false,
      default: 'lng',
    },
    initialLatValue: {
      type: Number,
      required: false,
      default: null,
    },
    initialLngValue: {
      type: Number,
      required: false,
      default: null,
    },
    center: {
      required: false,
      default() {
        return {
          lat: 24.700548606169395,
          lng: 46.64410303322909,
        }
      }
    },
    zoom: {
      type: Number,
      required: false,
      default: 5
    },
    height: {
      type: Number,
      required: false,
      default: 600
    },
  },
  data() {
    return {
      latValue: 24.700548606169395,
      lngValue: 46.64410303322909,
      centerMap: {
        lat: 24.700548606169395,
        lng: 46.64410303322909,
      },
      mapZoom: 5,
      place: null,
      icon: {
        path: 'M -2,0 0,-2 2,0 0,2 z',
        strokeColor: '#F00',
        fillColor: '#F00',
        fillOpacity: 1
      },
      icons: [
        {icon: this.icon, offset: '0%'},
        {icon: this.icon, offset: '100%'}
      ],
    }
  },
  created() {
    this.centerMap = this.center;
    this.mapZoom = this.zoom;
    if (this.initialLatValue) {
      this.latValue = this.initialLatValue
    }
    if (this.initialLngValue) {
      this.lngValue = this.initialLngValue
    }
  },
  mounted() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function (position) {
        this.centerMap = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };
        this.latValue = this.centerMap.lat
        this.lngValue = this.centerMap.lng
      }.bind(this));
    }
  },
  methods: {
    markerDragged(event) {
      this.latValue = event.latLng.lat()
      this.lngValue = event.latLng.lng()

      this.getAddress(this.latValue, this.lngValue)

      this.$emit('markerDragged', event);
    },
    setPlace(place) {
      this.centerMap = {
        lat: place.geometry.location.lat(),
        lng: place.geometry.location.lng(),
      }

      this.latValue = place.geometry.location.lat()
      this.lngValue = place.geometry.location.lng()

      this.getAddress(this.latValue, this.lngValue)

      this.mapZoom = 8;
    },
    onSearchEnter() {
      return false;
    },
    getAddress(lat, lng) {
      axios.get('/api/get/address', {
        params: {
          lat,
          lng,
        }
      })
          .then(response => {
            let input = document.querySelector(this.addressInput);
            if (input) {
              input.value = response.data;
            }
          })
    },
  },
  computed: {
    google: gmapApi,
    getMarkerPosition() {
      return {
        lat: this.latValue,
        lng: this.lngValue
      };
    },
  }
}
</script>
