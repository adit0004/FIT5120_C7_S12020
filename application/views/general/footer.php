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
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                console.log("Geolocation is not supported by this browser.");
            }
        }

        function showPosition(position) {
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
            <?php } else if ($activePage == 'places') { ?>
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
            <?php } ?>
        })
        <?php if ($activePage == 'placesMap') { ?>
            var map;

            var spaces = <?php echo json_encode($spaces);?>;
            console.log(spaces);
            // Calculate average lat, lng
            var latSum = 0;
            var lngSum = 0;
            for (var i = 0 ; i < spaces.length ; i++)
            {
                latSum += parseFloat(spaces[i].lat);
                lngSum += parseFloat(spaces[i].long);
            }
            avgLat = latSum/10;
            avgLng = lngSum/10;
            function initMap() {
                map = new google.maps.Map(document.getElementById('map'), {
                    center: {
                        lat: avgLat,
                        lng: avgLng
                    },
                    zoom: 10
                });
                for (var i = 0 ; i < spaces.length ; i++)
                {
                    var loc = {lat:parseFloat(spaces[i].lat), lng:parseFloat(spaces[i].long)};
                    console.log(loc);
                    var marker = new google.maps.Marker({position:loc, map:map});
                }
            }
        <?php } ?>
    </script>
    </body>

    </html>