<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TEST METHODS</title>
</head>
<body>
    <h1>Weather API</h1>
    <?php echo form_open('general/fetchWeather', ['id'=>'weatherForm']);?>
    Latitude: <input type="text" name="lat"><br>
    Longitude: <input type="text" name="long"><br>
    <input type="submit" value="Fetch">
    <?php echo form_close();?>
    <div id="weatherSpace"></div>

    <h1>AQI API</h1>
    <?php echo form_open('general/fetchAqi', ['id'=>'aqiForm']);?>
    Latitude: <input type="text" name="lat"><br>
    Longitude: <input type="text" name="long"><br>
    <input type="submit" value="Fetch">
    <?php echo form_close();?>
    <div id="aqiSpace"></div>
    
    <h1>Search for places</h1>
    <script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
    <script>
        $(function(){

            // Weather AJAX call
            $("#weatherForm").on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    url:"<?php echo base_url();?>index.php/general/fetchWeather",
                    method:"POST",
                    data:$("#weatherForm").serialize(),
                    success:function(data)
                    {
                        $("#weatherSpace").html(data);
                    }
                })
            })
            // AQI AJAX call
            $("#aqiForm").on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    url:"<?php echo base_url();?>index.php/general/fetchAqi",
                    method:"POST",
                    data:$("#aqiForm").serialize(),
                    success:function(data)
                    {
                        $("#aqiSpace").html(data);
                    }
                })
            })
        });
    </script>
</body>
</html>