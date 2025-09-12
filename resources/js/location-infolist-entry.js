import { Loader } from '@googlemaps/js-api-loader'

export default function locationInfolistEntry({ location, config }) {
    return {
        map: null,
        marker: null,
        markerLocation: null,
        loader: null,
        location: null,
        config: {
            controls: {
                mapTypeControl: true,
                scaleControl: true,
                streetViewControl: true,
                rotateControl: true,
                fullscreenControl: true,
                zoomControl: false,
            },
            defaultLocation: {
                lat: 0,
                lng: 0,
            },
            defaultZoom: 8,
            apiKey: '',
            language: 'en',
        },

        init: function () {
            this.location = location
            this.config = { ...this.config, ...config }
            this.loadGmaps()
        },

        loadGmaps: function () {
            this.loader = new Loader({
                apiKey: this.config.apiKey,
                language: this.config.language,
                version: 'weekly',
            })

            this.loader
                .load()
                .then((google) => {
                    this.map = new google.maps.Map(this.$refs.map, {
                        center: this.getCoordinates(),
                        zoom: this.config.defaultZoom,
                        ...this.config.controls,
                    })

                    this.marker = new google.maps.Marker({
                        map: this.map,
                    })
                    this.marker.setPosition(this.getCoordinates())
                })
                .catch((error) => {
                    console.error('Error loading Google Maps API:', error)
                })
        },

        getCoordinates: function () {
            let location = this.location

            if (
                location === null ||
                !location.hasOwnProperty('lat') ||
                !location.hasOwnProperty('lng')
            ) {
                location = {
                    lat: this.config.defaultLocation.lat,
                    lng: this.config.defaultLocation.lng,
                }
            }

            return location
        },
    }
}
