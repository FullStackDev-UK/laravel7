<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Postcode -> Location -> Map</div>

                <div class="card-body">

                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="card">

                                    <div class="card-header red-header" id="heading-example">
                                        <h5 class="mb-0">{{heading}}</h5>
                                    </div>

                                    <div class="card-body">

                                        <div id="inputForm">
                                            <input type="text" name="postcode" id="postcode" placeholder="Postcode" />
                                            <button class="btn btn-cta btn-md" @click="handlePostcodeSubmit()">Submit</button>
                                            <button class="btn btn-cta btn-md" @click="populateGLPostcode()">Populate GL</button>
                                            <button class="btn btn-cta btn-md" @click="populateMPostcode()">Populate M</button>
                                        </div>

                                        <div ref="result" v-if="this.result !== null">

                                            <p>
                                                Longitute: {{result.longitude}} <br>
                                                Latitute: {{result.latitude}} <br>
                                                Region: {{result.region}} <br>
                                                District: {{result.admin_district}} <br>
                                                Area: {{result.nuts}} <br>
                                            </p>

                                        </div>

                                        <div class="mapHolder">
                                            <div id="leafletmap" style="width:600px; height: 300px;"></div>
                                        </div>

                                    </div>


      <p>{{ count }}</p>
      <p>
        <button @click="decrement">-</button>
        <button @click="increment">+</button>
      </p>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</template>
<style <style lang="scss" scoped>
    #inputForm {
        margin-bottom: 20px;
    }
    .mapHolder {
        width: 100%;
        text-align: center;
        clear: both;
    }
    #map {
        width: 600px;
        height: 300px;
    }
</style>
<script>
    import axios from 'axios';
    import L from '../leaflet'
    import "leaflet/dist/leaflet.css";
    L.Icon.Default.imagePath = 'public/images/vendor/leaflet/dist';

    export default {        
        data : function() {
            return {
                heading: 'Enter a postcode',
                result: null,
                longitude: -2.202836,
                latitude: 52.455654,
                map: null,
                markers: [
                    {
                        "name": "Point 1",
                        "url": "http://localhost/laravel7/home",
                        "lat": 52.855654,
                        "lng": -1.702836
                    },
                    {
                        "name": "Point 2",
                        "url": "http://localhost/laravel7/home",
                        "lat": 51.255654,
                        "lng": -1.402836
                    },
                    {
                        "name": "Point 3",
                        "url": "http://localhost/laravel7/home",
                        "lat": 52.655654,
                        "lng": -1.102836
                    }
                ]
            }
        },
        created(){
        },
        mounted() {
            this.createMap();
        },
        methods: {
            increment () {
                this.$store.commit('increment')
            },
            decrement () {
                this.$store.commit('decrement')
            },
            handlePostcodeSubmit(){
                var pc = document.getElementById('postcode').value
                var url = 'https://api.postcodes.io/postcodes/' + pc
                
                axios.get(url).then(response => {
                    this.result = response.data.result
                    this.longitude = response.data.result.longitude
                    this.latitude = response.data.result.latitude
                    this.addMarkerAndPanToLatLong(this.latitude,this.longitude);
                }).catch( error => {
                    console.log(error)
                })
            },
            populateGLPostcode(){
                document.getElementById('postcode').value = 'GL1 1AD'
            },
            populateMPostcode(){
                document.getElementById('postcode').value = 'M32 0JG'
            },
            createMap(){
                var lat = this.latitude;
                var lng = this.longitude;
                var markers = this.markers;

                // initialize Leaflet
                var map = L.map("leafletmap").setView({lon: lng, lat: lat}, 6);

                // add the OpenStreetMap tiles
                L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                    attribution: "&copy; <a href='https://openstreetmap.org/copyright'>OpenStreetMap contributors</a>"
                }).addTo(map);

                for ( var i=0; i < markers.length; ++i ) {
                    L.marker( [markers[i].lat, markers[i].lng] )
                        .addTo( map ).bindPopup( '<h4>' + markers[i].name + '</h4>' );
                }
                this.map = map 
            },
            addMarkerAndPanToLatLong(lat,lng){
                this.map.setView({lon:lng, lat:lat}, 8);

                var markerinfo = document.getElementById('postcode').value

                var p = L.marker([lat, lng], { pointAttribute: 'Pertinant Information' }).addTo(this.map).bindPopup('<h4>' + markerinfo + '</h4>'); 
                
                console.log(p.options.pointAttribute, markerinfo)
            }
        },
        computed: {
            count () {
                return this.$store.state.count
            }
        }
    }
</script>
