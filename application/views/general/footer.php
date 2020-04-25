    <footer class="bg-light text-dark py-5 border-top mt-5">
        <p class="text-center">
            &copy; 2020 Eldvisor.
        </p>
    </footer>

    <?php $activePage = isset($activePage)?$activePage:'';?>
    <?php if ($activePage == 'placesMap') { ?>
        <div class="modal fade" id="locateMeModal" tabindex="-1" role="dialog" aria-labelledby="locateMeModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="locateMeModalLabel">Locate Me</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class='lead-text'>Where are you coming from?</p>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-outline-dark">Confirm Location</button>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <!-- Vendor scripts -->
    <!-- jQuery -->
    <script src='<?php echo base_url(); ?>assets/js/jquery.min.js'></script>
    <!-- Popper -->
    <script src='<?php echo base_url(); ?>assets/js/popper.min.js'></script>
    <!-- Bootstrap (Custom) -->
    <script src='<?php echo base_url(); ?>assets/js/bootstrap.min.js'></script>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/1370f26db3.js"></script>
    <!-- Charts -->
    <script src="<?php echo base_url(); ?>assets/js/Chart.bundle.min.js"></script>
    <!-- Datepicker -->
    <script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.min.js"></script>


    <script>
        // Location methods
        // Ask for location and append weather, temperature and AQI to nav
        // Check if geolocation is supported, and if yes, get the location:
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(getWeatherAndAqi);
            } else {
                console.log("Geolocation is not supported by this browser.");
            }
        }

        function getWeatherAndAqi(position) {
            $.ajax({
                url: '<?php echo site_url(['general', 'getWeatherAndAqi']); ?>',
                method: 'POST',
                data: {
                    'lat': position.coords.latitude,
                    'long': position.coords.longitude
                },
                success: function(data) {
                    data = JSON.parse(data);
                    var temperature = Math.round(((data.weather.main.temp - 273.15) * 10)) / 10;
                    var weather = data.weather.weather[0].main;
                    var icon = '<?php echo base_url(); ?>assets/img/weather_icons/' + data.weather.weather[0].icon + '.png';
                    var elem = '<div class="d-flex align-items-centre"><div class="d-inline-block"><img src="' + icon + '" height="50px"></div><div class="d-inline-block ml-2">' + temperature + ' &deg;C<br>' + weather + '</div></div>';
                    $("#weatherContainer").html(elem);
                }
            })
        }

        $(function() {
            // Attach active class to active page
            if (<?php echo $activePage == 'home' ? '1' : 'false'; ?>)
                $("#homeNav").addClass('active');
            else if (<?php echo $activePage == 'charts' ? '1' : 'false'; ?>)
                $("#healthNav").addClass('active');
            else if (<?php echo $activePage == 'places' || $activePage == 'placesMap' ? '1' : 'false' ?>)
                $("#placesNav").addClass('active');
            else if (<?php echo $activePage == 'events'? '1' : 'false'; ?>)
                $("#eventsNav").addClass('active');
            getLocation();


            // Smooth-Scroll
            $('a[href*="#"]')
                // Remove links that don't actually link to anything
                .not('[href="#"]')
                .not('[href="#!"]')
                .click(function(event) {
                    // On-page links
                    if (
                        location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') &&
                        location.hostname == this.hostname
                    ) {
                        // Figure out element to scroll to
                        var target = $(this.hash);
                        target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                        // Does a scroll target exist?
                        if (target.length) {
                            // Only prevent default if animation is actually gonna happen
                            event.preventDefault();
                            $('html, body').animate({
                                scrollTop: (target.offset().top)
                            }, 1000);
                        }
                    }
                });
            <?php if($activePage == 'events') {?>
                var options = {format:'dd M yyyy'};
                $("#startDate").datepicker(options);
                $("#endDate").datepicker(options);
            <?php }?>
        })
        <?php if ($activePage == 'placesMap') { ?>
            var map;

            <?php foreach ($spaces as &$space) {
                $addressJson = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $space['lat'] .
                    ',' . $space['long'] . '&key=AIzaSyCrGmHjWjkwhyXqb9HDaiwQ9htOZCrs0Hs';
                $space['urlString'] = $addressJson;
            }; ?>

            spaces = <?php echo json_encode($spaces); ?>;

            // Add addresses to the divs
            console.log(spaces);
            // Calculate average lat, lng
            var latSum = 0;
            var lngSum = 0;
            for (var i = 0; i < spaces.length; i++) {
                latSum += parseFloat(spaces[i].lat);
                lngSum += parseFloat(spaces[i].long);
            }
            avgLat = latSum / spaces.length;
            avgLng = lngSum / spaces.length;

            function seeOnMap(index) {
                $('html, body').animate({
                    scrollTop: $("#map").offset().top
                }, 800);
                // map.setCenter(markers[index].getPosition());

                google.maps.event.trigger(markers[index], 'click');
            }

            async function initMap() {
                markers = [];
                map = new google.maps.Map(document.getElementById('map'), {
                    center: {
                        lat: avgLat,
                        lng: avgLng
                    },
                    zoom: 10
                });

                // Marker for user
                if ($("#lat").val() != 0 && $("#long").val() != 0) {
                    icon = {
                        url: "<?php echo base_url(); ?>assets/img/user_icon.png", // url
                        size: new google.maps.Size(137, 197),
                        scaledSize: new google.maps.Size((137 * 50 / 197), 50), // scaled size
                        origin: new google.maps.Point(0, 0), // origin
                        anchor: new google.maps.Point(((137 * 50) / (197 * 2)), 50) // anchor
                    };
                    userMarker = new google.maps.Marker({
                        position: {
                            lat: parseFloat($("#lat").val()),
                            lng: parseFloat($("#long").val())
                        },
                        map: map,
                        icon: icon,
                        zIndex: 100
                    });
                } else if (navigator.geolocation && $("#lat").val() != 0 && $("#long").val() != 0) {
                    var location = navigator.geolocation.getCurrentPosition(function(location) {
                        icon = {
                            url: "<?php echo base_url(); ?>assets/img/user_icon.png", // url
                            size: new google.maps.Size(137, 197),
                            scaledSize: new google.maps.Size((137 * 50 / 197), 50), // scaled size
                            origin: new google.maps.Point(0, 0), // origin
                            anchor: new google.maps.Point(((137 * 50) / (197 * 2)), 50) // anchor
                        };
                        userMarker = new google.maps.Marker({
                            position: {
                                lat: location.coords.latitude,
                                lng: location.coords.longitude
                            },
                            map: map,
                            icon: icon
                        });
                    });
                } else {
                    icon = {
                        url: "<?php echo base_url(); ?>assets/img/user_icon.png", // url
                        size: new google.maps.Size(137, 197),
                        scaledSize: new google.maps.Size((137 * 50 / 197), 50), // scaled size
                        origin: new google.maps.Point(0, 0), // origin
                        anchor: new google.maps.Point(((137 * 50) / (197 * 2)), 50) // anchor
                    };
                    userMarker = new google.maps.Marker({
                        map: map,
                        icon: icon
                    });
                }

                var infowindow = new google.maps.InfoWindow({
                    content: ""
                });
                spaces.forEach(function(space) {
                    var marker = new google.maps.Marker({
                        position: {
                            lat: parseFloat(space.lat),
                            lng: parseFloat(space.long)
                        },
                        content: space.name == undefined ? "Unnamed Location" : space.name,
                        map: map
                    });
                    var content = space.name;
                    userAddress = '';
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function(location) {
                            userAddress = location.coords.latitude + ',' + location.coords.longitude;
                        })
                    } else {
                        userAddress = '';
                    }
                    marker.addListener('click', function() {
                        map.panTo(marker.getPosition());
                        map.setZoom(15);
                        infowindow.setContent('<div class="text-center"><h3>' + marker.content + '</h3><br><a href="https://www.google.com/maps/dir/' + userAddress + '/' + marker.getPosition().lat() + ',' + marker.getPosition().lng() + '" class="btn btn-outline-dark btn-sm" target="_blank">Directions &rarr;</a></div>');
                        infowindow.open(map, marker);
                    });
                    markers.push(marker)

                    // Only bind if lat and long are not 0
                    if ($("#lat").val() == 0 && $("#long").val() == 0) {
                        var input = document.getElementById('locationFilter');
                        var options = {
                            componentRestrictions: {
                                country: 'au'
                            }
                        };
                        autocomplete = new google.maps.places.Autocomplete(input, options);
                        autocomplete.addListener('place_changed', function() {
                            var place = autocomplete.getPlace()
                            var geocoder = new google.maps.Geocoder;
                            geocoder.geocode({
                                'placeId': place.place_id
                            }, function(results, status) {
                                if (status !== 'OK') {
                                    window.alert('Geocoder failed due to: ' + status);
                                    return;
                                }
                                $("#lat").val(results[0].geometry.location.lat());
                                $("#long").val(results[0].geometry.location.lng())
                                map.setZoom(11);
                                map.setCenter(results[0].geometry.location);

                                // Set the position of the marker using the place ID and location.
                                userMarker.setPlace({
                                    placeId: place.place_id,
                                    location: results[0].geometry.location
                                });
                                userMarker.setVisible(true);
                            });
                        });
                    } else {
                        // Bind only on first change
                        console.log(typeof autocomplete === 'undefined');
                        if (typeof autocomplete === 'undefined') {
                            $("#locationFilter").on('keydown', function() {
                                var input = document.getElementById('locationFilter');
                                var options = {
                                    componentRestrictions: {
                                        country: 'au'
                                    }
                                };
                                autocomplete = new google.maps.places.Autocomplete(input, options);
                                autocomplete.addListener('place_changed', function() {
                                    var place = autocomplete.getPlace()
                                    var geocoder = new google.maps.Geocoder;
                                    geocoder.geocode({
                                        'placeId': place.place_id
                                    }, function(results, status) {
                                        if (status !== 'OK') {
                                            window.alert('Geocoder failed due to: ' + status);
                                            return;
                                        }
                                        $("#lat").val(results[0].geometry.location.lat());
                                        $("#long").val(results[0].geometry.location.lng())
                                        map.setZoom(11);
                                        map.setCenter(results[0].geometry.location);

                                        // Set the position of the marker using the place ID and location.
                                        userMarker.setPlace({
                                            placeId: place.place_id,
                                            location: results[0].geometry.location
                                        });
                                        userMarker.setVisible(true);
                                    });
                                });
                            })
                        }
                    }
                });
            }

            function getAddress(i, url) {
                return new Promise((resolve, reject) => {
                    fetch(url)
                        .then((resp) => resp.json())
                        .then((data) => {
                            var address = data.results[0].formatted_address.split(",");
                            $("tr").eq(i + 1).find("td").eq(1).find("#addressBlock").html("<address>" + address[0] + "<br>" + address[1] + "</address>");
                        })
                })
            }

            async function getAllAddresses() {

                // Variable to hold addresses once promise is resolved
                let addresses = [];

                // Fetch street addresses for all locations
                for (var i = 1; i < spaces.length + 1; i++) {
                    addresses.push({
                        i: getAddress(i - 1, spaces[i - 1].urlString)
                    });
                }
                await Promise.all(addresses)
            }

            function getWeatherAndAqiOnClick(i, lat, long) {

                $.ajax({
                    url: '<?php echo site_url(['general', 'getWeatherAndAqi']); ?>',
                    method: 'POST',
                    data: {
                        'lat': lat,
                        'long': long,
                        'index': i
                    },
                    success: function(data) {
                        try {
                            data = JSON.parse(data);
                            aqi = JSON.parse(data.aqi);
                            aqi = aqi.data.aqi;
                            var aqiStr = 'Very good air quality';
                            if (aqi > 33 && aqi <= 66)
                                aqiStr = 'Good air quality';
                            else if (aqi > 66 && aqi <= 99)
                                aqiStr = 'Fair air quality';
                            else if (aqi > 99 && aqi <= 150)
                                aqiStr = 'Poor air quality';
                            else if (aqi > 150)
                                aqiStr = 'Very poor air quality';

                            // var address = data.results[0].formatted_address.split(",");

                            var weatherAqiStr = (Math.round(((data.weather.main.temp - 273.15) * 10)) / 10) + " &deg;C, " + data.weather.weather[0].main + "<br>" + aqiStr;
                            $("tr").eq(i).find("td").eq(1).find("#weatherBlock").html(weatherAqiStr);

                        } catch {
                            console.log('Error fetching weather and aqi');
                        }
                    }
                })
            }

            $(function() {

                // If the server has lat/lng, don't do this 
                if ($("#lat").val() != 0 && $("#long").val() != 0) {
                    userAddress = $("#lat").val() + ',' + $("#long").val();
                    // Actual user address:
                    var url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=" + userAddress + "&key=AIzaSyCrGmHjWjkwhyXqb9HDaiwQ9htOZCrs0Hs";
                    fetch(url)
                        .then((response) => response.json())
                        .then((data) => {
                            $("#locationFilter").val(data.results[0].formatted_address);
                        })
                }
                getAllAddresses();
            })


        <?php } ?>
    </script>
    </body>

    </html>