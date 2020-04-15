<?php
$con = mysqli_connect('localhost', 'root', '');
mysqli_select_db($con, 'test');
$res = [];
$query = mysqli_query($con, "SELECT * FROM playgrounds");
while ($row = mysqli_fetch_assoc($query)) {
    $res[] = $row;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <style>
        /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
        #map {
            height: 100%;
        }

        /* Optional: Makes the sample page fill the window. */
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
    <div id="map"></div>
    <script>
    var map;
            function initMap() {
                map = new google.maps.Map(document.getElementById('map'), {
                    center: {
                        lat: -38.019162,
                        lng: 144.383628
                    },
                    zoom: 15
                });
            }
            </script>
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBY1xsAqSjnYbl2pWWQJRkvht-LiEvil5I&callback=initMap"></script>
            <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script>
        $(function() {
            var mapMarkers = <?php echo json_encode($res); ?>;
            for (var i = 0; i < mapMarkers.length; i++) {
                var point = new google.maps.LatLng(
                    parseFloat(mapMarkers[i]['geo_point_2d'].split(',')[0]),
                    parseFloat(mapMarkers[i]['geo_point_2d'].split(',')[1])
                );
                var marker = new google.maps.Marker({
                    map: map,
                    position: point,
                    label: mapMarkers[i]['name']
                })
            }
        })
    </script>
</body>

</html>