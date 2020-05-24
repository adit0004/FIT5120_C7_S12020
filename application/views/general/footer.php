<a href="tel:000" class="btn btn-primary p-3 emergency-button"><i class="fa fa-ambulance"></i></a>

<?php if ($activePage != 'personalizedHealth') { ?>
    <footer class="bg-light text-dark py-5 border-top mt-5">
        <p class="text-center">
            &copy; 2020 Eldvisor.
        </p>
    </footer>

<?php } ?>
<?php $activePage = isset($activePage) ? $activePage : ''; ?>
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
<?php if ($activePage == 'personalizedHealth') { ?>
    <!-- D3 -->
    <script src="https://d3js.org/d3.v4.min.js"></script>
<?php } ?>

<script>
    // Location methods
    // Ask for location and append weather, temperature and AQI to nav
    // Check if geolocation is supported, and if yes, get the location:
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(getWeatherAndAqi);
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
        else if (<?php echo $activePage == 'events' ? '1' : 'false'; ?>)
            $("#eventsNav").addClass('active');
        else if (<?php echo $activePage == 'personalizedHealth' ? '1' : 'false'; ?>)
            $("#personalNav").addClass('active');
        else if (<?php echo $activePage == 'crimeStats' ? '1' : 'false'; ?>)
            $("#crimeNav").addClass('active');
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
                            scrollTop: (target.offset().top - 70)
                        }, 1000);
                    }
                }
            });
        <?php if ($activePage == 'events') { ?>
            var options = {
                format: 'dd M yyyy'
            };
            $("#startDate").datepicker(options);
            $("#endDate").datepicker(options);
        <?php } ?>

        <?php if ($activePage == 'personalizedHealth') { ?>
            $("#q2").hide();
            $("#q2yes").hide();
            $("#q2no").hide();
            $("#q3").hide();
            $("#bmiCalculated").hide();
            $("#bmiButtons").hide();
            $("#bmiContinue").hide();
            $("#q4").hide();
            $("#q5").hide();
            var navbarHeight = $(".navbar").outerHeight();
            var breadCrumbHeight = $(".breadcrumb").outerHeight();
            var windowHeight = $(window).outerHeight();
            var containerHeight = windowHeight - navbarHeight - breadCrumbHeight;
            if (containerHeight < windowHeight) {
                $(".visualizationContainer").css('min-height', containerHeight + "px");
            }
            // Figure out height and width of SVG container
            $("svg").attr('height', containerHeight);
            $("svg").attr('width', $(".visualizationContainer").outerWidth());

        <?php } ?>
    })
    <?php if ($activePage == 'placesMap') { ?>
        var map;

        <?php
        if ($spaceId == 13) {
            foreach ($spaces['results'] as &$space) {
                $space['lat'] = $space['geometry']['location']['lat'];
                $space['long'] = $space['geometry']['location']['lng'];
            }
        } else {
            foreach ($spaces as &$space) {
                $addressJson = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $space['lat'] .
                    ',' . $space['long'] . '&key=AIzaSyCrGmHjWjkwhyXqb9HDaiwQ9htOZCrs0Hs';
                $space['urlString'] = $addressJson;
            };
        }
        ?>

        spaces = <?php echo $spaceId == 13 ? json_encode($spaces['results']) : json_encode($spaces); ?>;

        // Add addresses to the divs
        // console.log(spaces);
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
                    // console.log(typeof autocomplete === 'undefined');
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
                        // console.log('Error fetching weather and aqi');
                    }
                }
            })
        }

        $(function() {
            // If the user is picking a distance, make the address mandatory
            if ($("#distanceFilter").val() != 'All')
                $("#locationFilter").prop('required', true);

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
            var spaceId = <?php echo $spaceId; ?>;
            if (spaceId != 13)
                getAllAddresses();
        });
    <?php } ?>
</script>
<?php if ($activePage == 'placesMap') { ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCrGmHjWjkwhyXqb9HDaiwQ9htOZCrs0Hs&callback=initMap&libraries=places" async defer></script><?php } ?>
<?php if ($activePage == 'personalizedHealth') { ?>
    <script>
        var bmiSplit = false;
        var metGuidelinesSplit = false;

        function sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }

        var svg = d3.select("svg");
        width = $(".visualizationContainer").outerWidth();
        height = $(".visualizationContainer").outerHeight();

        // const forceStrength = 0.03;
        const forceStrength = 0.03;

        // "Electric repulsive charge", prevents overlap of nodes
        var chargeForce = d3.forceManyBody();

        // Keep nodes centered on screen



        d3.csv("<?php echo base_url(); ?>assets/dataFiles/18to24.csv", async function(error, data) {
            var typeScale = d3.scalePoint()
                .domain(data.map(function(d) {
                    return d['type'];
                }))
                .range([0, width])
                .padding(0.5); // give some space at the outer edges

            var xTypeForce = d3.forceX(d => typeScale(d['type']));

            var node = svg.selectAll("circle")
                .data(data)
                .enter().append("circle")
                .attr("r", 5)
                .attr("fill", "#eeeeee");



            var labels = svg.selectAll("text")
                .data(typeScale.domain()) // heh, scales take care of the unique, so grab from there
                .enter().append("text")
                .attr("class", "label")
                .text(function(d) {
                    return d;
                })
                .attr("fill", "rgba(0,0,0,0)")
                .attr("text-anchor", "middle")
                .attr("x", function(d) {
                    return typeScale(d) - 40;
                })
                .attr("y", height / 2.0 - 150);

            width = $(".visualizationContainer").outerWidth();
            height = $(".visualizationContainer").outerHeight();
            if (height == 500) {
                setTimeout(function() {
                    height = $(".visualizationContainer").outerHeight();
                }, 1000)
            }
            await sleep(1000);
            // var centerXForce = d3.forceX().x(width / 2).strength(forceStrength);
            // var centerYForce = d3.forceY().y(height / 2).strength(forceStrength);
            var centerXForce = d3.forceX(100);
            var centerYForce = d3.forceY(100);
            var simulation = d3.forceSimulation()
                .force("charge", chargeForce.strength(-5))
                .force("x", centerXForce)
                .force("y", centerYForce)
                .force("center", d3.forceCenter(width / 2, height / 2))
                .force('collision', d3.forceCollide(5));

            // Add the nodes to the simulation, and specify how to draw
            simulation.nodes(data)
                .on("tick", function() {
                    // The d3 force simulation updates the x & y coordinates
                    // of each node every tick/frame, based on the various active forces.
                    // It is up to us to translate these coordinates to the screen.
                    node.attr("cx", function(d) {
                            return d.x;
                        })
                        .attr("cy", function(d) {
                            return d.y;
                        });

                    d3.selectAll('path').remove();
                    d3.selectAll('line').remove();
                    d3.selectAll('text').remove();
                    var xMin = 9999,
                        yMin = 9999,
                        xMax = 0,
                        yMax = 0,
                        radius = 0;
                    $("circle").each(function() {
                        if (parseFloat($(this).attr('cx')) < xMin)
                            xMin = parseFloat($(this).attr('cx'));
                        if (parseFloat($(this).attr('cy')) < yMin)
                            yMin = parseFloat($(this).attr('cy'));
                        if (parseFloat($(this).attr('cx')) > xMax)
                            xMax = parseFloat($(this).attr('cx'));
                        if (parseFloat($(this).attr('cy')) > yMax)
                            yMax = parseFloat($(this).attr('cy'));
                    })

                    // Draw the arc. Keep a 10 px margin
                    xCenter = (xMin + xMax) / 2;
                    yCenter = (yMin + yMax) / 2;
                    radius = Math.sqrt(Math.pow(xCenter - xMin, 2) + Math.pow(yCenter - yMin, 2));
                    if (radius < 20) radius = 20;
                    xMin -= 10;
                    if (radius > 20)
                        yMin += 20;
                    else yMin -= 10;
                    xMax += 10;
                    yMax += 10;
                    d3.select('svg').append('path')
                        .attr('d', "M " + xMin + " " + yMin + " A " + radius + " " + radius + " 0 0 1 " + xMax + " " + yMin)
                        .attr('fill', 'none')
                        .attr('stroke', '#fff')

                    // Draw a line
                    d3.select('svg').append('line')
                        .attr('x1', xCenter)
                        .attr('y1', yCenter - radius + 8)
                        .attr('x2', xCenter)
                        .attr('y2', yCenter - radius - 2)
                        .attr('stroke', '#fff')

                    // Add the label
                    d3.select('svg')
                        .append("text")
                        .attr("class", "label")
                        .text('100 Australians')
                        .attr("fill", "#fff")
                        .attr("text-anchor", "middle")
                        .attr("x", xCenter)
                        .attr("y", yCenter - radius - 10)
                });

            var splitState = false;
            document.getElementById("processAgeButton").onclick = function() {
                // console.log($("#age-bracket").val());
                // Update the data first 
                $("#q1").fadeOut(400, function() {
                    $("#q2").fadeIn();
                });
                updateData($("#age-bracket").val());
            };

        });

        function updateData(sheetToFetch) {

            // console.log("Work damn you!")
            const forceStrength = 0.03;

            width = $(".visualizationContainer").outerWidth();
            height = $(".visualizationContainer").outerHeight();

            // var centerXForce = d3.forceX().x(width / 2).strength(forceStrength);
            // var centerYForce = d3.forceY().y(height / 2).strength(forceStrength);
            var centerXForce = d3.forceX(100);
            var centerYForce = d3.forceY(100);

            d3.csv("<?php echo base_url(); ?>assets/dataFiles/" + sheetToFetch + ".csv", function(error, data) {
                // console.log("<?php echo base_url(); ?>assets/dataFiles/" + sheetToFetch + ".csv");
                var typeScale = d3.scalePoint()
                    .domain(data.map(function(d) {
                        return d['type'];
                    }))
                    .range([20, width])
                    .padding(0.5); // give some space at the outer edges

                var xTypeForce = d3.forceX(d => typeScale(d['type']));

                svg.selectAll('*').remove();

                var node = svg.selectAll("circle")
                    .data(data)
                    .enter().append("circle")
                    .attr("r", 5)
                    .attr("data-type", function(d) {
                        return d.type
                    })
                    .attr("fill", "#eeeeee");


                if (
                    sheetToFetch.indexOf("bmi") < 0 ||
                    sheetToFetch.indexOf("arthritis") < 0 ||
                    sheetToFetch.indexOf("asthama") < 0 ||
                    sheetToFetch.indexOf("backProblems") < 0 ||
                    sheetToFetch.indexOf("cancer") < 0 ||
                    sheetToFetch.indexOf("copd") < 0 ||
                    sheetToFetch.indexOf("diabetes") < 0 ||
                    sheetToFetch.indexOf("hayfever") < 0 ||
                    sheetToFetch.indexOf("heartstrokevascular") < 0 ||
                    sheetToFetch.indexOf("hypertension") < 0 ||
                    sheetToFetch.indexOf("kidneyissue") < 0 ||
                    sheetToFetch.indexOf("mentalbehavioural") < 0 ||
                    sheetToFetch.indexOf("osteoporosis") < 0) {
                    var simulation = d3.forceSimulation()
                        .force("charge", chargeForce.strength(-5))
                        .force("x", centerXForce)
                        .force("y", centerYForce)
                        .force("center", d3.forceCenter(width / 2 + 30, height / 2))
                        .force('collision', d3.forceCollide(5));
                } else if (sheetToFetch.indexOf("alcohol") < 0) {
                    var simulation = d3.forceSimulation()
                        .force("charge", chargeForce.strength(-7))
                        .force("x", centerXForce)
                        .force("y", centerYForce)
                        .force("center", d3.forceCenter(width / 2, height / 2))
                        .force('collision', d3.forceCollide(5));
                } else {
                    var simulation = d3.forceSimulation()
                        .force("charge", chargeForce.strength(-5))
                        // .force("charge", null)
                        .force("x", centerXForce)
                        .force("y", centerYForce)
                        .force("center", d3.forceCenter(width / 2, height / 2))
                        .force('collision', d3.forceCollide(5));
                }



                var i = 0;
                // Add the nodes to the simulation, and specify how to draw
                simulation.nodes({})
                simulation.nodes(data)
                    .on("tick", function() {
                        // The d3 force simulation updates the x & y coordinates
                        // of each node every tick/frame, based on the various active forces.
                        // It is up to us to translate these coordinates to the screen.
                        node.attr("cx", function(d) {
                                return d.x;
                            })
                            .attr("cy", function(d) {
                                return d.y;
                            });

                        // Remove all existing labels
                        d3.selectAll('path').remove();
                        d3.selectAll('line').remove();
                        d3.selectAll('text').remove();

                        // All Australians label for met guidelines
                        if (sheetToFetch.indexOf("bmi") < 0 &&
                            sheetToFetch.indexOf("arthritis") < 0 &&
                            sheetToFetch.indexOf("asthama") < 0 &&
                            sheetToFetch.indexOf("backProblems") < 0 &&
                            sheetToFetch.indexOf("cancer") < 0 &&
                            sheetToFetch.indexOf("copd") < 0 &&
                            sheetToFetch.indexOf("diabetes") < 0 &&
                            sheetToFetch.indexOf("hayfever") < 0 &&
                            sheetToFetch.indexOf("heartstrokevascular") < 0 &&
                            sheetToFetch.indexOf("hypertension") < 0 &&
                            sheetToFetch.indexOf("kidneyissue") < 0 &&
                            sheetToFetch.indexOf("mentalbehavioural") < 0 &&
                            sheetToFetch.indexOf("osteoporosis") < 0 &&
                            sheetToFetch.indexOf("alcohol") < 0) {
                            if (!metGuidelinesSplit) {

                                var xMin = 9999,
                                    yMin = 9999,
                                    xMax = 0,
                                    yMax = 0,
                                    radius = 0;
                                $("circle").each(function() {
                                    if (parseFloat($(this).attr('cx')) < xMin)
                                        xMin = parseFloat($(this).attr('cx'));
                                    if (parseFloat($(this).attr('cy')) < yMin)
                                        yMin = parseFloat($(this).attr('cy'));
                                    if (parseFloat($(this).attr('cx')) > xMax)
                                        xMax = parseFloat($(this).attr('cx'));
                                    if (parseFloat($(this).attr('cy')) > yMax)
                                        yMax = parseFloat($(this).attr('cy'));
                                })

                                // Draw the arc. Keep a 10 px margin
                                xCenter = (xMin + xMax) / 2;
                                yCenter = (yMin + yMax) / 2;
                                radius = Math.sqrt(Math.pow(xCenter - xMin, 2) + Math.pow(yCenter - yMin, 2));
                                if (radius < 20) radius = 20;
                                xMin -= 10;
                                if (radius > 20)
                                    yMin += 20;
                                else yMin -= 10;
                                xMax += 10;
                                yMax += 10;
                                d3.select('svg').append('path')
                                    .attr('d', "M " + xMin + " " + yMin + " A " + radius + " " + radius + " 0 0 1 " + xMax + " " + yMin)
                                    .attr('fill', 'none')
                                    .attr('stroke', '#fff')

                                // Draw a line
                                d3.select('svg').append('line')
                                    .attr('x1', xCenter)
                                    .attr('y1', yCenter - radius + 8)
                                    .attr('x2', xCenter)
                                    .attr('y2', yCenter - radius - 2)
                                    .attr('stroke', '#fff')

                                // Add the label
                                d3.select('svg')
                                    .append("text")
                                    .attr("class", "label")
                                    .text('100 Australians')
                                    .attr("fill", "#fff")
                                    .attr("text-anchor", "middle")
                                    .attr("x", xCenter)
                                    .attr("y", yCenter - radius - 10)
                            } else {
                                var xMin = 9999,
                                    yMin = 9999,
                                    xMax = 0,
                                    yMax = 0,
                                    radius = 0,
                                    count = 0;
                                $("circle[data-type='Met Guidelines']").each(function() {
                                    if (parseFloat($(this).attr('cx')) < xMin)
                                        xMin = parseFloat($(this).attr('cx'));
                                    if (parseFloat($(this).attr('cy')) < yMin)
                                        yMin = parseFloat($(this).attr('cy'));
                                    if (parseFloat($(this).attr('cx')) > xMax)
                                        xMax = parseFloat($(this).attr('cx'));
                                    if (parseFloat($(this).attr('cy')) > yMax)
                                        yMax = parseFloat($(this).attr('cy'));
                                    count += 1;
                                })

                                // Draw the arc. Keep a 10 px margin
                                xCenter = (xMin + xMax) / 2;
                                yCenter = (yMin + yMax) / 2;
                                xMin -= 10;
                                yMin -= 10;
                                xMax += 10;
                                yMax += 10;
                                radius = Math.sqrt(Math.pow(xCenter - xMin, 2) + Math.pow(yCenter - yMin, 2));
                                d3.select('svg').append('path')
                                    .attr('d', "M " + xMin + " " + yMin + " A " + radius + " " + radius + " 0 0 1 " + xMax + " " + yMin)
                                    .attr('fill', 'none')
                                    .attr('stroke', '#fff')

                                // Draw a line
                                d3.select('svg').append('line')
                                    .attr('x1', xCenter)
                                    .attr('y1', yCenter - radius)
                                    .attr('x2', xCenter)
                                    .attr('y2', yCenter - radius - 10)
                                    .attr('stroke', '#fff')

                                // Add the label
                                d3.select('svg')
                                    .append("text")
                                    .attr("class", "label")
                                    .text('Met guidelines (' + count + '%)')
                                    .attr("fill", "#fff")
                                    .attr("text-anchor", "middle")
                                    .attr("x", xCenter)
                                    .attr("y", yCenter - radius - 15)


                                xMin = 9999,
                                    yMin = 9999,
                                    xMax = 0,
                                    yMax = 0,
                                    radius = 0,
                                    count = 0;
                                $("circle[data-type='Did not meet Guidelines']").each(function() {
                                    if (parseFloat($(this).attr('cx')) < xMin)
                                        xMin = parseFloat($(this).attr('cx'));
                                    if (parseFloat($(this).attr('cy')) < yMin)
                                        yMin = parseFloat($(this).attr('cy'));
                                    if (parseFloat($(this).attr('cx')) > xMax)
                                        xMax = parseFloat($(this).attr('cx'));
                                    if (parseFloat($(this).attr('cy')) > yMax)
                                        yMax = parseFloat($(this).attr('cy'));
                                    count += 1;
                                })

                                // Draw the arc. Keep a 10 px margin
                                xCenter = (xMin + xMax) / 2;
                                yCenter = (yMin + yMax) / 2;
                                xMin -= 10;
                                yMin -= 10;
                                xMax += 10;
                                yMax += 10;
                                radius = Math.sqrt(Math.pow(xCenter - xMin, 2) + Math.pow(yCenter - yMin, 2));
                                d3.select('svg').append('path')
                                    .attr('d', "M " + xMin + " " + yMin + " A " + radius + " " + radius + " 0 0 1 " + xMax + " " + yMin)
                                    .attr('fill', 'none')
                                    .attr('stroke', '#fff')

                                // Draw a line
                                d3.select('svg').append('line')
                                    .attr('x1', xCenter)
                                    .attr('y1', yCenter - radius)
                                    .attr('x2', xCenter)
                                    .attr('y2', yCenter - radius - 10)
                                    .attr('stroke', '#fff')

                                // Add the label
                                d3.select('svg')
                                    .append("text")
                                    .attr("class", "label")
                                    .text('Did not meet Guidelines (' + count + '%)')
                                    .attr("fill", "#fff")
                                    .attr("text-anchor", "middle")
                                    .attr("x", xCenter)
                                    .attr("y", yCenter - radius - 15)
                            }
                        }

                        if (sheetToFetch.indexOf('bmi') >= 0) {

                            // BMI After Splitting
                            if (bmiSplit) {
                                var xMin = 9999,
                                    yMin = 9999,
                                    xMax = 0,
                                    yMax = 0,
                                    radius = 0,
                                    count = 0;
                                $("circle[data-type='Underweight (less than 18.50)']").each(function() {
                                    if (parseFloat($(this).attr('cx')) < xMin)
                                        xMin = parseFloat($(this).attr('cx'));
                                    if (parseFloat($(this).attr('cy')) < yMin)
                                        yMin = parseFloat($(this).attr('cy'));
                                    if (parseFloat($(this).attr('cx')) > xMax)
                                        xMax = parseFloat($(this).attr('cx'));
                                    if (parseFloat($(this).attr('cy')) > yMax)
                                        yMax = parseFloat($(this).attr('cy'));
                                    count += 1;
                                })

                                // Draw the arc. Keep a 10 px margin
                                xCenter = (xMin + xMax) / 2;
                                yCenter = (yMin + yMax) / 2;
                                xMin -= 10;
                                if (radius > 20)
                                    yMin += 20;
                                else yMin -= 10;
                                xMax += 10;
                                yMax += 10;
                                radius = Math.sqrt(Math.pow(xCenter - xMin, 2) + Math.pow(yCenter - yMin, 2));
                                if (radius < 20) radius = 20;
                                d3.select('svg').append('path')
                                    .attr('d', "M " + xMin + " " + yMin + " A " + radius + " " + radius + " 0 0 1 " + xMax + " " + yMin)
                                    .attr('fill', 'none')
                                    .attr('stroke', '#fff')

                                // Draw a line
                                d3.select('svg').append('line')
                                    .attr('x1', xCenter)
                                    .attr('y1', yCenter - radius)
                                    .attr('x2', xCenter)
                                    .attr('y2', yCenter - radius - 10)
                                    .attr('stroke', '#fff')

                                // Add the label
                                d3.select('svg')
                                    .append("text")
                                    .attr("class", "label")
                                    .text('Underweight (less than 18.50) (' + count + '%)')
                                    .attr("fill", "#fff")
                                    .attr("text-anchor", "middle")
                                    .attr("x", xCenter)
                                    .attr("y", yCenter - radius - 15)

                                xMin = 9999, yMin = 9999, xMax = 0, yMax = 0, radius = 0, count = 0;

                                $("circle[data-type='Normal (18.50 to 24.99)']").each(function() {
                                    if (parseFloat($(this).attr('cx')) < xMin)
                                        xMin = parseFloat($(this).attr('cx'));
                                    if (parseFloat($(this).attr('cy')) < yMin)
                                        yMin = parseFloat($(this).attr('cy'));
                                    if (parseFloat($(this).attr('cx')) > xMax)
                                        xMax = parseFloat($(this).attr('cx'));
                                    if (parseFloat($(this).attr('cy')) > yMax)
                                        yMax = parseFloat($(this).attr('cy'));
                                    count += 1;
                                })


                                // Draw the arc. Keep a 10 px margin
                                xCenter = (xMin + xMax) / 2;
                                yCenter = (yMin + yMax) / 2;
                                xMin -= 5;
                                if (radius > 20)
                                    yMin += 20;
                                else yMin -= 5;
                                xMax += 5;
                                yMax += 5;
                                radius = Math.sqrt(Math.pow(xCenter - xMin, 2) + Math.pow(yCenter - yMin, 2));
                                if (radius < 20) radius = 20;
                                d3.select('svg').append('path')
                                    .attr('d', "M " + xMin + " " + yMin + " A " + radius + " " + radius + " 0 0 1 " + xMax + " " + yMin)
                                    .attr('fill', 'none')
                                    .attr('stroke', '#fff')

                                // Draw a line
                                d3.select('svg').append('line')
                                    .attr('x1', xCenter)
                                    .attr('y1', yCenter - radius)
                                    .attr('x2', xCenter)
                                    .attr('y2', yCenter - radius - 10)
                                    .attr('stroke', '#fff')

                                // Add the label
                                d3.select('svg')
                                    .append("text")
                                    .attr("class", "label")
                                    .text('Normal (18.50 to 24.99) (' + count + '%)')
                                    .attr("fill", "#fff")
                                    .attr("text-anchor", "middle")
                                    .attr("x", xCenter)
                                    .attr("y", yCenter - radius - 15)

                                xMin = 9999, yMin = 9999, xMax = 0, yMax = 0, radius = 0, count = 0;
                                $("circle[data-type='Overweight/Obese (25.00 or more)']").each(function() {
                                    if (parseFloat($(this).attr('cx')) < xMin)
                                        xMin = parseFloat($(this).attr('cx'));
                                    if (parseFloat($(this).attr('cy')) < yMin)
                                        yMin = parseFloat($(this).attr('cy'));
                                    if (parseFloat($(this).attr('cx')) > xMax)
                                        xMax = parseFloat($(this).attr('cx'));
                                    if (parseFloat($(this).attr('cy')) > yMax)
                                        yMax = parseFloat($(this).attr('cy'));
                                    count += 1;
                                })

                                // Draw the arc. Keep a 10 px margin
                                xCenter = (xMin + xMax) / 2;
                                yCenter = (yMin + yMax) / 2;
                                xMin -= 5;
                                if (radius > 20)
                                    yMin += 20;
                                else yMin -= 5;
                                xMax += 5;
                                yMax += 5;
                                radius = Math.sqrt(Math.pow(xCenter - xMin, 2) + Math.pow(yCenter - yMin, 2));
                                if (radius < 20) radius = 20;
                                d3.select('svg').append('path')
                                    .attr('d', "M " + xMin + " " + yMin + " A " + radius + " " + radius + " 0 0 1 " + xMax + " " + yMin)
                                    .attr('fill', 'none')
                                    .attr('stroke', '#fff')

                                // Draw a line
                                d3.select('svg').append('line')
                                    .attr('x1', xCenter)
                                    .attr('y1', yCenter - radius)
                                    .attr('x2', xCenter)
                                    .attr('y2', yCenter - radius - 10)
                                    .attr('stroke', '#fff')

                                // Add the label
                                d3.select('svg')
                                    .append("text")
                                    .attr("class", "label")
                                    .text('Overweight/Obese (25.00 or more) (' + count + '%)')
                                    .attr("fill", "#fff")
                                    .attr("text-anchor", "middle")
                                    .attr("x", xCenter)
                                    .attr("y", yCenter - radius - 15)
                            } else {
                                var xMin = 9999,
                                    yMin = 9999,
                                    xMax = 0,
                                    yMax = 0,
                                    radius = 0;
                                $("circle").each(function() {
                                    if (parseFloat($(this).attr('cx')) < xMin)
                                        xMin = parseFloat($(this).attr('cx'));
                                    if (parseFloat($(this).attr('cy')) < yMin)
                                        yMin = parseFloat($(this).attr('cy'));
                                    if (parseFloat($(this).attr('cx')) > xMax)
                                        xMax = parseFloat($(this).attr('cx'));
                                    if (parseFloat($(this).attr('cy')) > yMax)
                                        yMax = parseFloat($(this).attr('cy'));
                                })

                                // Draw the arc. Keep a 10 px margin
                                xCenter = (xMin + xMax) / 2;
                                yCenter = (yMin + yMax) / 2;
                                radius = Math.sqrt(Math.pow(xCenter - xMin, 2) + Math.pow(yCenter - yMin, 2));
                                if (radius < 20) radius = 20;
                                xMin -= 10;
                                if (radius > 20)
                                    yMin += 20;
                                else yMin -= 10;
                                xMax += 10;
                                yMax += 10;
                                d3.select('svg').append('path')
                                    .attr('d', "M " + xMin + " " + yMin + " A " + radius + " " + radius + " 0 0 1 " + xMax + " " + yMin)
                                    .attr('fill', 'none')
                                    .attr('stroke', '#fff')

                                // Draw a line
                                d3.select('svg').append('line')
                                    .attr('x1', xCenter)
                                    .attr('y1', yCenter - radius + 8)
                                    .attr('x2', xCenter)
                                    .attr('y2', yCenter - radius - 2)
                                    .attr('stroke', '#fff')

                                // Add the label
                                d3.select('svg')
                                    .append("text")
                                    .attr("class", "label")
                                    .text('100 Australians')
                                    .attr("fill", "#fff")
                                    .attr("text-anchor", "middle")
                                    .attr("x", xCenter)
                                    .attr("y", yCenter - radius - 10)
                            }
                        }
                        if (sheetToFetch.indexOf("arthritis") >= 0 ||
                            sheetToFetch.indexOf("asthama") >= 0 ||
                            sheetToFetch.indexOf("backProblems") >= 0 ||
                            sheetToFetch.indexOf("cancer") >= 0 ||
                            sheetToFetch.indexOf("copd") >= 0 ||
                            sheetToFetch.indexOf("diabetes") >= 0 ||
                            sheetToFetch.indexOf("hayfever") >= 0 ||
                            sheetToFetch.indexOf("heartstrokevascular") >= 0 ||
                            sheetToFetch.indexOf("hypertension") >= 0 ||
                            sheetToFetch.indexOf("kidneyissue") >= 0 ||
                            sheetToFetch.indexOf("mentalbehavioural") >= 0 ||
                            sheetToFetch.indexOf("osteoporosis") >= 0) {
                            // These are split by default;
                            var xMin = 9999,
                                yMin = 9999,
                                xMax = 0,
                                yMax = 0,
                                radius = 0,
                                count = 0;
                            $("circle[data-type='Underweight/Normal']").each(function() {
                                if (parseFloat($(this).attr('cx')) < xMin)
                                    xMin = parseFloat($(this).attr('cx'));
                                if (parseFloat($(this).attr('cy')) < yMin)
                                    yMin = parseFloat($(this).attr('cy'));
                                if (parseFloat($(this).attr('cx')) > xMax)
                                    xMax = parseFloat($(this).attr('cx'));
                                if (parseFloat($(this).attr('cy')) > yMax)
                                    yMax = parseFloat($(this).attr('cy'));
                                count += 1;
                            })

                            // Draw the arc. Keep a 10 px margin
                            xCenter = (xMin + xMax) / 2;
                            yCenter = (yMin + yMax) / 2;
                            xMin -= 10;
                            yMin -= 10;
                            xMax += 10;
                            yMax += 10;
                            radius = Math.sqrt(Math.pow(xCenter - xMin, 2) + Math.pow(yCenter - yMin, 2));
                            d3.select('svg').append('path')
                                .attr('d', "M " + xMin + " " + yMin + " A " + radius + " " + radius + " 0 0 1 " + xMax + " " + yMin)
                                .attr('fill', 'none')
                                .attr('stroke', '#fff')

                            // Draw a line
                            d3.select('svg').append('line')
                                .attr('x1', xCenter)
                                .attr('y1', yCenter - radius)
                                .attr('x2', xCenter)
                                .attr('y2', yCenter - radius - 10)
                                .attr('stroke', '#fff')

                            // Add the label
                            d3.select('svg')
                                .append("text")
                                .attr("class", "label")
                                .text('Underweight/Normal (' + count + '%)')
                                .attr("fill", "#fff")
                                .attr("text-anchor", "middle")
                                .attr("x", xCenter)
                                .attr("y", yCenter - radius - 15)


                            xMin = 9999,
                                yMin = 9999,
                                xMax = 0,
                                yMax = 0,
                                radius = 0,
                                count = 0;
                            $("circle[data-type='Overweight/Obese']").each(function() {
                                if (parseFloat($(this).attr('cx')) < xMin)
                                    xMin = parseFloat($(this).attr('cx'));
                                if (parseFloat($(this).attr('cy')) < yMin)
                                    yMin = parseFloat($(this).attr('cy'));
                                if (parseFloat($(this).attr('cx')) > xMax)
                                    xMax = parseFloat($(this).attr('cx'));
                                if (parseFloat($(this).attr('cy')) > yMax)
                                    yMax = parseFloat($(this).attr('cy'));
                                count += 1;
                            })

                            // Draw the arc. Keep a 10 px margin
                            xCenter = (xMin + xMax) / 2;
                            yCenter = (yMin + yMax) / 2;
                            xMin -= 10;
                            yMin -= 10;
                            xMax += 10;
                            yMax += 10;
                            radius = Math.sqrt(Math.pow(xCenter - xMin, 2) + Math.pow(yCenter - yMin, 2));
                            d3.select('svg').append('path')
                                .attr('d', "M " + xMin + " " + yMin + " A " + radius + " " + radius + " 0 0 1 " + xMax + " " + yMin)
                                .attr('fill', 'none')
                                .attr('stroke', '#fff')

                            // Draw a line
                            d3.select('svg').append('line')
                                .attr('x1', xCenter)
                                .attr('y1', yCenter - radius)
                                .attr('x2', xCenter)
                                .attr('y2', yCenter - radius - 10)
                                .attr('stroke', '#fff')

                            // Add the label
                            d3.select('svg')
                                .append("text")
                                .attr("class", "label")
                                .text('Overweight/Obese (' + count + '%)')
                                .attr("fill", "#fff")
                                .attr("text-anchor", "middle")
                                .attr("x", xCenter)
                                .attr("y", yCenter - radius - 15)
                        }

                        if (sheetToFetch.indexOf("alcohol") >= 0) {
                            // These are split by default;
                            var xMin = 9999,
                                yMin = 9999,
                                xMax = 0,
                                yMax = 0,
                                radius = 0,
                                count = 0;
                            $("circle[data-type='Alcohol consumption in the last week - Exceeded guidelines']").each(function() {
                                if (parseFloat($(this).attr('cx')) < xMin)
                                    xMin = parseFloat($(this).attr('cx'));
                                if (parseFloat($(this).attr('cy')) < yMin)
                                    yMin = parseFloat($(this).attr('cy'));
                                if (parseFloat($(this).attr('cx')) > xMax)
                                    xMax = parseFloat($(this).attr('cx'));
                                if (parseFloat($(this).attr('cy')) > yMax)
                                    yMax = parseFloat($(this).attr('cy'));
                                count += 1;
                            })

                            // Draw the arc. Keep a 10 px margin
                            xCenter = (xMin + xMax) / 2;
                            yCenter = (yMin + yMax) / 2;
                            xMin -= 10;
                            // yMin -= 10;
                            xMax += 10;
                            yMax += 10;
                            radius = Math.sqrt(Math.pow(xCenter - xMin, 2) + Math.pow(yCenter - yMin, 2));
                            d3.select('svg').append('path')
                                .attr('d', "M " + xMin + " " + yMin + " A " + radius + " " + radius + " 0 0 1 " + xMax + " " + yMin)
                                .attr('fill', 'none')
                                .attr('stroke', '#fff')

                            // Draw a line
                            d3.select('svg').append('line')
                                .attr('x1', xCenter)
                                .attr('y1', yCenter - radius)
                                .attr('x2', xCenter)
                                .attr('y2', yCenter - radius - 10)
                                .attr('stroke', '#fff')

                            // Add the label
                            d3.select('svg')
                                .append("text")
                                .attr("class", "label")
                                .text('Exceeded guidelines last week (' + count + '%)')
                                .attr("fill", "#fff")
                                .attr("text-anchor", "middle")
                                .attr("x", xCenter)
                                .attr("y", yCenter - radius - 15)


                            xMin = 9999,
                                yMin = 9999,
                                xMax = 0,
                                yMax = 0,
                                radius = 0,
                                count = 0;
                            $("circle[data-type='Alcohol consumption in the last week - Did not exceed guidelines']").each(function() {
                                if (parseFloat($(this).attr('cx')) < xMin)
                                    xMin = parseFloat($(this).attr('cx'));
                                if (parseFloat($(this).attr('cy')) < yMin)
                                    yMin = parseFloat($(this).attr('cy'));
                                if (parseFloat($(this).attr('cx')) > xMax)
                                    xMax = parseFloat($(this).attr('cx'));
                                if (parseFloat($(this).attr('cy')) > yMax)
                                    yMax = parseFloat($(this).attr('cy'));
                                count += 1;
                            })

                            // Draw the arc. Keep a 10 px margin
                            xCenter = (xMin + xMax) / 2;
                            yCenter = (yMin + yMax) / 2;
                            xMin -= 10;
                            // yMin -= 10;
                            xMax += 10;
                            yMax += 10;
                            radius = Math.sqrt(Math.pow(xCenter - xMin, 2) + Math.pow(yCenter - yMin, 2));
                            d3.select('svg').append('path')
                                .attr('d', "M " + xMin + " " + yMin + " A " + radius + " " + radius + " 0 0 1 " + xMax + " " + yMin)
                                .attr('fill', 'none')
                                .attr('stroke', '#fff')

                            // Draw a line
                            d3.select('svg').append('line')
                                .attr('x1', xCenter)
                                .attr('y1', yCenter - radius)
                                .attr('x2', xCenter)
                                .attr('y2', yCenter - radius - 10)
                                .attr('stroke', '#fff')

                            // Add the label
                            d3.select('svg')
                                .append("text")
                                .attr("class", "label")
                                .text('Did not exceed guidelines last week (' + count + '%)')
                                .attr("fill", "#fff")
                                .attr("text-anchor", "middle")
                                .attr("x", xCenter)
                                .attr("y", yCenter - radius - 15)


                            xMin = 9999,
                                yMin = 9999,
                                xMax = 0,
                                yMax = 0,
                                radius = 0,
                                count = 0;
                            $("circle[data-type='Did not consume alcohol in the last week but did less than 12 months ago']").each(function() {
                                if (parseFloat($(this).attr('cx')) < xMin)
                                    xMin = parseFloat($(this).attr('cx'));
                                if (parseFloat($(this).attr('cy')) < yMin)
                                    yMin = parseFloat($(this).attr('cy'));
                                if (parseFloat($(this).attr('cx')) > xMax)
                                    xMax = parseFloat($(this).attr('cx'));
                                if (parseFloat($(this).attr('cy')) > yMax)
                                    yMax = parseFloat($(this).attr('cy'));
                                count += 1;
                            })

                            // Draw the arc. Keep a 10 px margin
                            xCenter = (xMin + xMax) / 2;
                            yCenter = (yMin + yMax) / 2;
                            xMin -= 10;
                            // yMin -= 10;
                            xMax += 10;
                            yMax += 10;
                            radius = Math.sqrt(Math.pow(xCenter - xMin, 2) + Math.pow(yCenter - yMin, 2));
                            d3.select('svg').append('path')
                                .attr('d', "M " + xMin + " " + yMin + " A " + radius + " " + radius + " 0 0 1 " + xMax + " " + yMin)
                                .attr('fill', 'none')
                                .attr('stroke', '#fff')

                            // Draw a line
                            d3.select('svg').append('line')
                                .attr('x1', xCenter)
                                .attr('y1', yCenter - radius)
                                .attr('x2', xCenter)
                                .attr('y2', yCenter - radius - 10)
                                .attr('stroke', '#fff')

                            // Add the label
                            d3.select('svg')
                                .append("text")
                                .attr("class", "label")
                                .text('Didn\'t consume alcohol last week, but did this year (' + count + '%)')
                                .attr("fill", "#fff")
                                .attr("text-anchor", "middle")
                                .attr("x", xCenter)
                                .attr("y", yCenter - radius - 15)


                            xMin = 9999,
                                yMin = 9999,
                                xMax = 0,
                                yMax = 0,
                                radius = 0,
                                count = 0;
                            $("circle[data-type='Consumed alcohol 12 or more months ago']").each(function() {
                                if (parseFloat($(this).attr('cx')) < xMin)
                                    xMin = parseFloat($(this).attr('cx'));
                                if (parseFloat($(this).attr('cy')) < yMin)
                                    yMin = parseFloat($(this).attr('cy'));
                                if (parseFloat($(this).attr('cx')) > xMax)
                                    xMax = parseFloat($(this).attr('cx'));
                                if (parseFloat($(this).attr('cy')) > yMax)
                                    yMax = parseFloat($(this).attr('cy'));
                                count += 1;
                            })

                            // Draw the arc. Keep a 10 px margin
                            xCenter = (xMin + xMax) / 2;
                            yCenter = (yMin + yMax) / 2;
                            xMin -= 10;
                            // yMin -= 10;
                            xMax += 10;
                            yMax += 10;
                            radius = Math.sqrt(Math.pow(xCenter - xMin, 2) + Math.pow(yCenter - yMin, 2));
                            d3.select('svg').append('path')
                                .attr('d', "M " + xMin + " " + yMin + " A " + radius + " " + radius + " 0 0 1 " + xMax + " " + yMin)
                                .attr('fill', 'none')
                                .attr('stroke', '#fff')

                            // Draw a line
                            d3.select('svg').append('line')
                                .attr('x1', xCenter)
                                .attr('y1', yCenter - radius)
                                .attr('x2', xCenter)
                                .attr('y2', yCenter - radius - 10)
                                .attr('stroke', '#fff')

                            // Add the label
                            d3.select('svg')
                                .append("text")
                                .attr("class", "label")
                                .text('Consumed alcohol 12 or more months ago (' + count + '%)')
                                .attr("fill", "#fff")
                                .attr("text-anchor", "middle")
                                .attr("x", xCenter)
                                .attr("y", yCenter - radius - 15)


                            xMin = 9999,
                                yMin = 9999,
                                xMax = 0,
                                yMax = 0,
                                radius = 0,
                                count = 0;
                            $("circle[data-type='Never consumed alcohol']").each(function() {
                                if (parseFloat($(this).attr('cx')) < xMin)
                                    xMin = parseFloat($(this).attr('cx'));
                                if (parseFloat($(this).attr('cy')) < yMin)
                                    yMin = parseFloat($(this).attr('cy'));
                                if (parseFloat($(this).attr('cx')) > xMax)
                                    xMax = parseFloat($(this).attr('cx'));
                                if (parseFloat($(this).attr('cy')) > yMax)
                                    yMax = parseFloat($(this).attr('cy'));
                                count += 1;
                            })

                            // Draw the arc. Keep a 10 px margin
                            xCenter = (xMin + xMax) / 2;
                            yCenter = (yMin + yMax) / 2;
                            xMin -= 10;
                            // yMin -= 10;
                            xMax += 10;
                            yMax += 10;
                            radius = Math.sqrt(Math.pow(xCenter - xMin, 2) + Math.pow(yCenter - yMin, 2));
                            d3.select('svg').append('path')
                                .attr('d', "M " + xMin + " " + yMin + " A " + radius + " " + radius + " 0 0 1 " + xMax + " " + yMin)
                                .attr('fill', 'none')
                                .attr('stroke', '#fff')

                            // Draw a line
                            d3.select('svg').append('line')
                                .attr('x1', xCenter)
                                .attr('y1', yCenter - radius)
                                .attr('x2', xCenter)
                                .attr('y2', yCenter - radius - 10)
                                .attr('stroke', '#fff')

                            // Add the label
                            d3.select('svg')
                                .append("text")
                                .attr("class", "label")
                                .text('Never consumed alcohol (' + count + '%)')
                                .attr("fill", "#fff")
                                .attr("text-anchor", "middle")
                                .attr("x", xCenter)
                                .attr("y", yCenter - radius - 15)
                        }
                    });


                if (
                    sheetToFetch.indexOf("arthritis") >= 0 ||
                    sheetToFetch.indexOf("asthama") >= 0 ||
                    sheetToFetch.indexOf("backProblems") >= 0 ||
                    sheetToFetch.indexOf("cancer") >= 0 ||
                    sheetToFetch.indexOf("copd") >= 0 ||
                    sheetToFetch.indexOf("diabetes") >= 0 ||
                    sheetToFetch.indexOf("hayfever") >= 0 ||
                    sheetToFetch.indexOf("heartstrokevascular") >= 0 ||
                    sheetToFetch.indexOf("hypertension") >= 0 ||
                    sheetToFetch.indexOf("kidneyissue") >= 0 ||
                    sheetToFetch.indexOf("mentalbehavioural") >= 0 ||
                    sheetToFetch.indexOf("osteoporosis") >= 0
                ) {
                    svgHeight = $(".visualizationContainer").outerHeight();
                    svgWidth = $(".visualizationContainer").outerWidth();

                    var typeScaleY = d3.scalePoint()
                        .domain(data.map(function(d) {
                            return d['type'];
                        }))
                        .range([0, svgHeight - 100])
                        .padding(0.5); // give some space at the outer edges

                    var yTypeForce = d3.forceY(d => typeScaleY(d['type']));

                    // console.log("Will this work?");
                    var splitState = false;
                    // push the nodes towards respective spots
                    simulation.force("y", yTypeForce);
                    // labels.attr("fill", "#000");
                    // d3.selectAll('circle').transition()
                    // console.log(someUndefinedVariableToBreakJSHere);
                    return;
                    simulation.alpha(1).restart();
                    // console.log(bmi);

                } else if (sheetToFetch.indexOf("alcohol") >= 0) {
                    svgHeight = $(".visualizationContainer").outerHeight();
                    svgWidth = $(".visualizationContainer").outerWidth();

                    // console.log("HEre");
                    var typeScaleY = d3.scalePoint()
                        .domain(data.map(function(d) {
                            return d['type'];
                        }))
                        .range([0, svgHeight - 100])
                        .padding(0.5); // give some space at the outer edges

                    var yTypeForce = d3.forceY(d => typeScaleY(d['type']));

                    simulation.force("charge", chargeForce.strength(-2))
                    simulation.force("x", centerXForce)
                    // simulation.force("y", centerYForce)
                    // push the nodes towards respective spots
                    simulation.force("y", yTypeForce);
                    // labels.attr("fill", "#000");
                    d3.selectAll('circle').transition()
                    simulation.force("center", d3.forceCenter((svgWidth / 2), (svgHeight / 2) - 20))

                    simulation.force('collision', d3.forceCollide(5));




                    // Toggle state
                    splitState = !splitState;

                    // NOTE: Very important to call both alphaTarget AND restart in conjunction
                    // Restart by itself will reset alpha (cooling of simulation)
                    // but won't reset the velocities of the nodes (inertia)
                    simulation.alpha(1).restart();
                    // console.log(bmi);
                }


                var splitState = false;

                document.getElementById('processMetGuidelinesYes').onclick = function() {
                    svgHeight = $(".visualizationContainer").outerHeight();
                    svgWidth = $(".visualizationContainer").outerWidth();

                    var typeScaleY = d3.scalePoint()
                        .domain(data.map(function(d) {
                            return d['type'];
                        }))
                        .range([0, svgHeight - 100])
                        .padding(0.5); // give some space at the outer edges

                    var yTypeForce = d3.forceY(d => typeScaleY(d['type']));
                    $("#q2").fadeOut(400, function() {
                        // DO D3 HERE
                        if (!splitState) {
                            // push the nodes towards respective spots
                            simulation.force("y", yTypeForce);
                            // labels.attr("fill", "#000");
                            d3.selectAll('circle').transition()
                        } else {
                            simulation.force("x", centerXForce);
                            // labels.attr("fill", "rgba(0,0,0,0)");
                            d3.selectAll('circle').transition()
                        }

                        // Toggle state
                        splitState = !splitState;
                        metGuidelinesSplit = true;

                        // NOTE: Very important to call both alphaTarget AND restart in conjunction
                        // Restart by itself will reset alpha (cooling of simulation)
                        // but won't reset the velocities of the nodes (inertia)
                        simulation.alpha(1).restart();
                        $("#q2yes").fadeIn();
                    });
                    // Pick a node with this value and color it black
                    // $("circle[data-type='Met Guidelines']").first().attr('fill', '#000');
                    $("#metGuidelinesPercentage").html($("circle[data-type='Met Guidelines']").length);
                }
                $("#skipAge").on('click', function() {
                    $("#q2").fadeOut(400, function() {
                        $("#q3").fadeIn();
                        updateData($("#age-bracket").val() + "_bmi");
                    })
                })
                document.getElementById('processMetGuidelinesNo').onclick = function() {
                    svgHeight = $(".visualizationContainer").outerHeight();
                    svgWidth = $(".visualizationContainer").outerWidth();

                    var typeScaleY = d3.scalePoint()
                        .domain(data.map(function(d) {
                            return d['type'];
                        }))
                        .range([0, svgHeight - 100])
                        .padding(0.5); // give some space at the outer edges

                    var yTypeForce = d3.forceY(d => typeScaleY(d['type']));

                    $("#q2").fadeOut(400, function() {
                        // DO D3 HERE
                        if (!splitState) {
                            // push the nodes towards respective spots
                            simulation.force("y", yTypeForce);
                            // labels.attr("fill", "#000");
                            d3.selectAll('circle').transition()
                        } else {
                            simulation.force("x", centerXForce);
                            // labels.attr("fill", "rgba(0,0,0,0)");
                            d3.selectAll('circle').transition()
                        }

                        // Toggle state
                        splitState = !splitState;
                        metGuidelinesSplit = true;

                        // NOTE: Very important to call both alphaTarget AND restart in conjunction
                        // Restart by itself will reset alpha (cooling of simulation)
                        // but won't reset the velocities of the nodes (inertia)
                        simulation.alpha(1).restart();
                        $("#q2no").fadeIn();
                    });
                    // Pick a node with this value and color it black
                    // $("circle[data-type='Did not meet Guidelines']").first().attr('fill', '#000');
                    $("#didNotMeet").html($("circle[data-type='Did not meet Guidelines']").length);
                }
                $(".moveToBmi").each(function(e) {
                    try {
                        $(this).on('click', function() {
                            updateData($("#age-bracket").val() + "_bmi");
                            if ($("#q2yes").is(":visible")) {
                                $("#q2yes").fadeOut(400, function() {
                                    $("#q3").fadeIn();
                                })
                            }
                            if ($("#q2no").is(":visible")) {
                                $("#q2no").fadeOut(400, function() {
                                    $("#q3").fadeIn();
                                })
                            }
                        })
                    } catch (err) {
                        // console.log(err);
                    }
                })
                $("#processBmi").on('click', function() {
                    $("#enterHeight").removeClass('is-invalid');
                    $("#enterWeight").removeClass('is-invalid');
                    var validationFlag = 0;
                    if ($.trim($("#enterHeight").val()) == '') {
                        $("#enterHeight").addClass('is-invalid');
                        validationFlag = 1;
                    }
                    if ($.trim($("#enterWeight").val()) == '') {
                        $("#enterWeight").addClass('is-invalid');
                        validationFlag = 1;
                    }
                    if (validationFlag == 1) {
                        return;
                    }
                    var height = parseFloat($("#enterHeight").val()) / 100;
                    var weight = parseFloat($("#enterWeight").val());
                    var bmi = weight / (height * height);
                    bmi = (Math.round(bmi * 10) / 10).toFixed(1);
                    if (bmi < 18.5) {
                        // Underweight
                        $("#bmiResult").removeClass("text-danger");
                        $("#bmiResult").removeClass("text-success");
                        $("#bmiResult").addClass("text-danger");
                        $("#bmiResult").html("Underweight");
                        $("#bmiMessage").html("A BMI of " + bmi + " is within the underweight category. You are among the " + $("circle[data-type='Underweight (less than 18.50)']").length + "% of people in this category. It is recommended that you visit a health professional to discuss the impacts this may have on your health.");
                        $("#bmiContinue").fadeIn();
                        // $("circle[data-type='Underweight (less than 18.50)']").first().attr('fill', '#000');
                    } else if (bmi >= 18.5 && bmi < 25) {
                        // Normal
                        $("#bmiResult").removeClass("text-danger");
                        $("#bmiResult").removeClass("text-success");
                        $("#bmiResult").addClass("text-success");
                        $("#bmiResult").html("Normal");
                        $("#bmiMessage").html("A BMI of " + bmi + " is within the healthy weight category.You are among the " + $("circle[data-type='Normal (18.50 to 24.99)']").length + "% of people in this category.  This is generally good for your health. The challenge is to maintain your weight. You might like to explore places and events nearby to maintain a healthy weight.");
                        $("#bmiButtons").fadeIn();
                        $("#bmiContinue").fadeIn();
                        // $("circle[data-type='Normal (18.50 to 24.99)']").first().attr('fill', '#000');
                    } else {
                        // Overweight / Obese
                        $("#bmiResult").removeClass("text-danger");
                        $("#bmiResult").removeClass("text-success");
                        $("#bmiResult").addClass("text-danger");
                        $("#bmiResult").html("Overweight or Obese");
                        $("#bmiMessage").html("A BMI of " + bmi + " is within the overweight/obese category. You are among the " + $("circle[data-type='Overweight/Obese (25.00 or more)']").length + "% of people in this category. This may not be good for your health. You might like to explore places and events for a more active lifestyle");
                        $("#bmiButtons").fadeIn();
                        $("#bmiContinue").fadeIn();
                        // $("circle[data-type='Overweight/Obese (25.00 or more)']").first().attr('fill', '#000');
                    }
                    $("#bmiCalculated").fadeIn();

                    // DO D3 HERE


                    svgHeightLocal = $(".visualizationContainer").outerHeight();
                    svgWidthLocal = $(".visualizationContainer").outerWidth();

                    var typeScaleY = d3.scalePoint()
                        .domain(data.map(function(d) {
                            return d['type'];
                        }))
                        .range([0, svgHeightLocal])
                        .padding(50); // give some space at the outer edges

                    var yTypeForce = d3.forceY(d => typeScaleY(d['type']));

                    simulation.force("charge", chargeForce.strength(-5))
                    simulation.force("x", centerXForce)
                    simulation.force("y", centerYForce)
                    simulation.force("center", d3.forceCenter((svgWidthLocal / 2), (svgHeightLocal / 2) + 70))
                    simulation.force('collision', d3.forceCollide(5));

                    // console.log("Will this work?");

                    if (!splitState) {
                        // push the nodes towards respective spots
                        // yTypeForce = 
                        // simulation.force("x", xTypeForce);
                        simulation.force("y", yTypeForce)
                        // labels.attr("fill", "#000");
                        d3.selectAll('circle').transition()
                        simulation.alpha(1).restart();
                        bmiSplit = true;
                    }

                    // Toggle state
                    splitState = !splitState;

                    // NOTE: Very important to call both alphaTarget AND restart in conjunction
                    // Restart by itself will reset alpha (cooling of simulation)
                    // but won't reset the velocities of the nodes (inertia)
                    // console.log(bmi);

                })
                $(".moveToLongTermIssues").each(function() {
                    $(this).on('click', function() {
                        try {
                            updateData($("#longTermHealthIssues").val());
                            $("#q3").fadeOut(400, function() {
                                $("#q4").fadeIn();
                                $("#percentageForIssues").html("For " + $("#longTermHealthIssues").find("option:selected").html() + ", " + $("circle[data-type='Underweight/Normal']").length + "% of the people fall under Underweight/Normal category and " + $("circle[data-type='Overweight/Obese']").length + "% of the people fall in the Overweight/Obese category.");
                            });
                        } catch (err) {
                            // console.log(err);
                        }
                    })
                })

                $("#longTermHealthIssues").on('change', function() {
                    updateData($("#longTermHealthIssues").val());
                    $("#percentageForIssues").html("For " + $("#longTermHealthIssues").find("option:selected").html() + ", " + $("circle[data-type='Underweight/Normal']").length + "% of the people fall under Underweight/Normal category and " + $("circle[data-type='Overweight/Obese']").length + "% of the people fall in the Overweight/Obese category.");
                })

                $("#continueFromLongTerm").on('click', function() {
                    $("#q4").fadeOut(400, function() {
                        $("#q5").fadeIn();
                        updateData($("#age-bracket").val() + "alcohol");
                        // console.log($("#age-bracket").val() + "alcohol");
                    })
                })
                $("#compareAlcohol").on('click', function() {
                    $("circle").each(function() {
                        $(this).attr('fill', "#eeeeee");
                    })
                    if ($("#alcoholConsumption").val() == "neverConsumedAlcohol") {
                        // $("circle[data-type='Never consumed alcohol']").first().attr('fill', '#000');
                        $("#alcoholPercentage").html("You are among the " + $("circle[data-type='Never consumed alcohol']").length + "% people who have never consumed alcohol");
                    }
                    if ($("#alcoholConsumption").val() == "12OrMoreMonths") {
                        // $("circle[data-type='Consumed alcohol 12 or more months ago']").first().attr('fill', '#000');
                        $("#alcoholPercentage").html("You are among the " + $("circle[data-type='Consumed alcohol 12 or more months ago']").length + "% people who consumed alcohol 12 or more months ago.");
                    }
                    if ($("#alcoholConsumption").val() == "notInLastWeekButUnder12Months") {
                        // $("circle[data-type='Did not consume alcohol in the last week but did less than 12 months ago']").first().attr('fill', '#000');
                        $("#alcoholPercentage").html("You are among the " + $("circle[data-type='Did not consume alcohol in the last week but did less than 12 months ago']").length + "% people who did not consume alcohol in the last week but did less than 12 months ago.");
                    }
                    if ($("#alcoholConsumption").val() == "didNotExceedGuidelines") {
                        // $("circle[data-type='Alcohol consumption in the last week - Did not exceed guidelines']").first().attr('fill', '#000');
                        $("#alcoholPercentage").html("You are among the " + $("circle[data-type='Alcohol consumption in the last week - Did not exceed guidelines']").length + "% people who did not exceed guidelines last week.");
                    }
                    if ($("#alcoholConsumption").val() == "exceededGuidelines") {
                        // $("circle[data-type='Alcohol consumption in the last week - Exceeded guidelines']").first().attr('fill', '#000');
                        $("#alcoholPercentage").html("You are among the " + $("circle[data-type='Alcohol consumption in the last week - Exceeded guidelines']").length + "% people who exceeded guidelines last week.");
                    }
                })
            });
        }
    </script>
<?php } ?>
</body>

</html>