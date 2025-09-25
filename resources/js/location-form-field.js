import { Loader } from '@googlemaps/js-api-loader'

export default function locationFormField({ location, config }) {
    return {
        map: null,
        marker: null,
        markerLocation: null,
        infoWindow: null,
        loader: null,
        location: null,
        config: {
            draggable: true,
            clickable: false,
            defaultZoom: 8,
            controls: {
                mapTypeControl: true,
                scaleControl: true,
                streetViewControl: true,
                rotateControl: true,
                fullscreenControl: true,
                zoomControl: false,
            },
            myLocationButtonLabel: '',
            sourceAddress: '',
            language: 'en',
            region: 'es',
            defaultLocation: {
                lat: 0,
                lng: 0,
            },
            apiKey: '',
            statePath: '',
        },

        init: function () {
            this.location = location
            this.config = { ...this.config, ...config }
            this.loadGmaps()
            this.$watch('location', (value) => this.updateMapFromAlpine())
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
                        disableDoubleClickZoom: true,
                        zoom: this.config.defaultZoom,
                        ...this.config.controls,
                    })

                    this.infoWindow = new google.maps.InfoWindow()

                    this.marker = new google.maps.Marker({
                        draggable: this.config.draggable,
                        map: this.map,
                    })
                    this.marker.setPosition(this.getCoordinates())
                    this.setCoordinates(this.marker.getPosition())

                    this.map.addListener('dblclick', (event) => {
                        this.setMarkerLocation(event.latLng.toJSON())
                    })

                    if (this.config.clickable) {
                        this.map.addListener('click', (event) => {
                            this.setMarkerLocation(event.latLng.toJSON())
                        })
                    }

                    if (this.config.draggable) {
                        google.maps.event.addListener(
                            this.marker,
                            'dragend',
                            (event) => {
                                this.setMarkerLocation(event.latLng.toJSON())
                            },
                        )
                    }

                    // const mapTools = document.createElement('div')
                    // mapTools.classList.add('map-tools')

                    // mapTools.appendChild(this.createSearchInput())

                    // const inputElement = document.createElement('input')
                    // inputElement.type = 'text'
                    // inputElement.placeholder = 'Search...'

                    // const searchBox = new google.maps.places.SearchBox(
                    //     inputElement,
                    // )

                    // searchBox.addListener('places_changed', () => {
                    //     inputElement.value = ''
                    //     map.setZoom(18)
                    //     console.log(searchBox.getPlaces())
                    //     this.setMarkerLocation(
                    //         searchBox.getPlaces()[0].geometry.location,
                    //     )
                    // })

                    // mapTools.appendChild(this.createLocationButton())
                    // this.map.controls[
                    //     google.maps.ControlPosition.TOP_LEFT
                    // ].push(mapTools)
                })
                .catch((error) => {
                    console.error('Error loading Google Maps API:', error)
                })
        },

        handleSearchSubmit: function (event) {
            console.log(`You entered: ${event.target.value}`)
            this.fetchGeolocation(event.target.value)
        },

        handleGeoAddress: function (event) {
            this.$refs.searchInput.value = this.config.sourceAddress
            this.fetchGeolocation(this.config.sourceAddress)
        },

        setMarkerLocation: function (location) {
            this.markerLocation = location
            this.setCoordinates(location)
            this.marker.setPosition(location)
            this.map.panTo(location)
        },

        updateMapFromAlpine: function () {
            const location = this.getCoordinates()
            const markerLocation = this.marker.getPosition()
            if (
                !(
                    location.lat === markerLocation.lat() &&
                    location.lng === markerLocation.lng()
                )
            ) {
                this.updateMap(location)
            }
        },

        fetchGeolocation: function (address) {
            const queryString = new URLSearchParams({
                key: this.config.apiKey,
                region: this.region,
                address,
            }).toString()

            const url = `https://maps.googleapis.com/maps/api/geocode/json?${queryString}`

            fetch(url)
                .then((response) => response.json())
                .then((data) => {
                    if (data.status === 'OK') {
                        this.setMarkerLocation(
                            data.results[0].geometry.location,
                        )
                    } else {
                        throw new Error('ERROR: No results!')
                    }
                })
                .catch((error) => {
                    console.error('ERROR: Error making request:', error)
                    alert('Error making request: ' + error)
                })
        },

        updateMap: function (location) {
            this.marker.setlocation(location)
            this.map.panTo(location)
        },

        setCoordinates: function (location) {
            this.$wire.set(this.config.statePath, location)
        },

        getCoordinates: function () {
            let location = this.$wire.get(this.config.statePath)

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

        myLocationError: function (browserHasGeolocation, infoWindow, pos) {
            infoWindow.setPosition(pos)
            infoWindow.setContent(
                browserHasGeolocation
                    ? 'Error: The Geolocation service failed.'
                    : "Error: Your browser doesn't support geolocation.",
            )
            infoWindow.open(this.map)
        },
    }
}
