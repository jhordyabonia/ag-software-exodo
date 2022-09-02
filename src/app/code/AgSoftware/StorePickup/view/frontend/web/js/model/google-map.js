define([
    'uiComponent',
], function (Component) {
    'use strict';
    return {
        map:'',
        marker:'',
        latlng:'',
        updatePosition : function (lat, lng) {
            let latlng = new google.maps.LatLng(lat, lng);
            this.marker.setPosition(latlng);
            this.map.setCenter(latlng);
        },
        prepare: function () {
            var script_polyfill = document.createElement('script');
            script_polyfill.src = 'https://polyfill.io/v3/polyfill.min.js?features=default';
            document.head.appendChild(script_polyfill);

            var script = document.createElement('script');

            let api_key = 'AIzaSyB7GEO_6zuaK107dKemqD6HXPtz0aNfzbw';//document.getElementById('container_map').dataset.api;

            script.src = 'https://maps.googleapis.com/maps/api/js?width=350&&key=' + api_key + '&callback=initMap';
            script.async = true;
            document.head.appendChild(script);
            this.setMap();
        },
        startMap: function () {
            window.initMap();
        },
        setMap: function () {
            let self = this;

            window.initMap = function (center) {
                if (typeof center === "undefined") {
                    center = {lat: -25.363, lng: 131.044 }
                }
                self.latlng = new google.maps.LatLng(center);

                const mapOptions = {
                    zoom: 18,
                    center: center
                }

                self.map = new google.maps.Map(document.getElementById("container_map"), mapOptions);

                self.marker = new google.maps.Marker({
                    position: center,
                    map: self.map,
                    animation: google.maps.Animation.DROP
                });

                const infowindow = new google.maps.InfoWindow({
                    content: "<p>Marker Location:" + self.marker.getPosition() + "</p>",
                    maxWidth: 200,
                });

                google.maps.event.addListener(self.marker, "click", () => {
                    infowindow.open(self.map, self.marker);
                });

                self.marker.addListener('zoom_changed', function () {

                });

                document.querySelectorAll('[name="list-stores"]').forEach(tag=>{
                    tag.addEventListener('change', (e) => {
                        let item = document.querySelector('[name="list-stores"] [value="' + e.target.value + '"]');
                        let lat = parseFloat(item.dataset.lat);
                        let lng = parseFloat(item.dataset.lng);
                        self.updatePosition(lat, lng);
                    });
                });
            }

        }
    };
})
