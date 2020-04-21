    <footer class="bg-light text-dark py-5 border-top mt-5">
        <p class="text-center">
            &copy; 2020 Eldvisor.
        </p>
    </footer>
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
    <!-- Maps -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBY1xsAqSjnYbl2pWWQJRkvht-LiEvil5I&callback=initMap" async defer></script>
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
            // console.log("Latitude: " + position.coords.latitude +
            //     "<br>Longitude: " + position.coords.longitude);
            // If we got the location, pull the weather and AQI
            $.ajax({
                url: '<?php echo site_url(['general', 'getWeatherAndAqi']); ?>',
                method: 'POST',
                data: {
                    'lat': position.coords.latitude,
                    'long': position.coords.longitude
                },
                success: function(data) {
                    try {
                        data = JSON.parse(data);
                        console.log(data);
                        var temperature = Math.round(((data.weather.main.temp - 273.15) * 10)) / 10;
                        var weather = data.weather.weather[0].main;
                        var icon = '<?php echo base_url(); ?>assets/img/weather_icons/' + data.weather.weather[0].icon + '.png';
                        console.log(temperature, weather);
                        var elem = '<div class="d-flex align-items-centre"><div class="d-inline-block"><img src="' + icon + '" height="50px"></div><div class="d-inline-block ml-2">' + temperature + ' &deg;C<br>' + weather + '</div></div>';
                        $("#weatherContainer").html(elem);
                    } catch {
                        console.log('Error fetching weather and aqi');
                    }
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
                                scrollTop: target.offset().top
                            }, 1000, function() {
                                // // Callback after animation
                                // // Must change focus!
                                // var $target = $(target);
                                // $target.focus();
                                // if ($target.is(":focus")) { // Checking if the target was focused
                                //     return false;
                                // } else {
                                //     $target.attr('tabindex', '-1'); // Adding tabindex for elements not focusable
                                // };
                            });
                        }
                    }
                });

            // Only initialize charts if this is the charts page.
            <?php if ($activePage == 'charts') { ?>
                // Initialize with met guidelines
                const ctx = document.getElementById('chart').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['<?php echo implode('\',\'', array_keys($y)); ?>'],
                        datasets: [{
                            label: 'Yes',
                            data: [<?php echo implode(',', $y); ?>],
                            backgroundColor: "rgba(122, 148, 97, 1)",
                            // categoryPercentage:1.0,
                            barPercentage: 0.9
                        }, {
                            label: 'No',
                            data: [<?php echo implode(',', $n); ?>],
                            backgroundColor: "rgba(155, 61, 61, 1)",
                            barPercentage: 0.9
                        }]
                    },
                    options: {
                        categoryPercentage: 1.0,
                    }
                });
                $(ctx).data('chart', chart)
                $('input[name="gender"]').on('change', function(e) {
                    // console.log($(this).val());
                    var chart = $(ctx).data('chart');
                    if ($(this).val() == 'Male') {
                        <?php for ($i = 0; $i < count($male['n']); $i++) {
                            echo 'chart.data.datasets[0].data[' . $i . '] = ' . $male['y'][$i] . ';';
                            echo 'chart.data.datasets[1].data[' . $i . '] = ' . $male['n'][$i] . ';';
                        } ?>
                    } else if ($(this).val() == 'Female') {
                        <?php for ($i = 0; $i < count($female['n']); $i++) {
                            echo 'chart.data.datasets[0].data[' . $i . '] = ' . $female['y'][$i] . ';';
                            echo 'chart.data.datasets[1].data[' . $i . '] = ' . $female['n'][$i] . ';';
                        } ?>
                    } else {
                        <?php
                        $i = 0;
                        foreach ($y as $age => $yes) {
                            echo 'chart.data.datasets[0].data[' . $i . '] = ' . $yes . ';';
                            echo 'chart.data.datasets[1].data[' . $i++ . '] = ' . $n[$age] . ';';
                        }
                        ?>
                    }
                    chart.update();
                });
            <?php } ?>
        })
        <?php if ($activePage == 'placesMap') { ?>
            var map;

            <?php foreach ($spaces as &$space) {
                $addressJson = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $space['lat'] .
                    ',' . $space['long'] . '&key=AIzaSyCrGmHjWjkwhyXqb9HDaiwQ9htOZCrs0Hs';
                $space['urlString'] = $addressJson;
            }; ?>

            spaces = <?php echo json_encode($spaces); ?>;


            // var flickerAPI = "https://api.flickr.com/services/feeds/photos_public.gne?jsoncallback=?";
            // $.getJSON(flickerAPI, {
            //         tags: "mount rainier",
            //         tagmode: "any",
            //         format: "json"
            //     })
            //     .done(function(data) {
            //         $.each(data.items, function(i, item) {
            //             $("<img>").attr("src", item.media.m).appendTo("#images");
            //             if (i === 3) {
            //                 return false;
            //             }
            //         });
            //     });

            // Add addresses to the divs
            console.log(spaces);
            // Calculate average lat, lng
            var latSum = 0;
            var lngSum = 0;
            for (var i = 0; i < spaces.length; i++) {
                latSum += parseFloat(spaces[i].lat);
                lngSum += parseFloat(spaces[i].long);
            }
            avgLat = latSum / 10;
            avgLng = lngSum / 10;

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
                // getCurrentPosition(function(position){})
                if (navigator.geolocation) {
                    var location = navigator.geolocation.getCurrentPosition(function(location) {
                        var icon = {
                            url: "<?php echo base_url(); ?>assets/img/user_icon.png", // url
                            size: new google.maps.Size(137, 197),
                            scaledSize: new google.maps.Size((137 * 50 / 197), 50), // scaled size
                            origin: new google.maps.Point(0, 0), // origin
                            anchor: new google.maps.Point(((137 * 50) / (197 * 2)), 50) // anchor
                        };
                        var user = new google.maps.Marker({
                            position: {
                                lat: location.coords.latitude,
                                lng: location.coords.longitude
                            },
                            map: map,
                            icon: icon
                        });
                        console.log(location);
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
                        content: space.name,
                        map: map
                    });
                    var content = space.name;
                    marker.addListener('click', function() {
                        map.panTo(marker.getPosition());
                        map.setZoom(15);
                        infowindow.setContent('<div><strong>' + marker.content + '</strong></div>');
                        infowindow.open(map, marker);
                    });
                    markers.push(marker)
                });









                // // Marker for Open Spaces
                // for (var i = 0; i < spaces.length; i++) {
                //     var loc = {
                //         lat: parseFloat(spaces[i].lat),
                //         lng: parseFloat(spaces[i].long)
                //     };
                //     console.log(loc);
                //     var marker = new google.maps.Marker({
                //         position: loc,
                //         map: map
                //     });

                //     markers.push(marker);
                //     var infowindow = new google.maps.InfoWindow({
                //         content: '<strong>' + spaces[i].name + '</strong>'
                //     })
                //     marker.addListener('click', function() {
                //         infowindow.open(map, markers[i]);
                //     })
                // }
            }
            $(function() {
                for (var i = 1; i < spaces.length + 1; i++) {
                    // console.log($("tr").eq(i).find("td").eq(1).html())
                    $.ajax({
                        url: spaces[i - 1].urlString,
                        method: "POST",
                        async: false,
                        success: function(data) {
                            spaces[i - 1].address = data.results[0].formatted_address;
                            var address = data.results[0].formatted_address.split(",");
                            $("tr").eq(i).find("td").eq(1).find("#addressBlock").html("<address>" + address[0] + "<br>" + address[1] + "</address>");
                            console.log(data.results[0].formatted_address);
                        }
                    })
                }
            })


        <?php } ?>
    </script>
    </body>

    </html>