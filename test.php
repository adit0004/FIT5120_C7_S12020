<?php 
    $con = mysqli_connect('localhost', 'root', '');
    mysqli_select_db($con, 'test');

    $string = file_get_contents("1.json");
    $json_a = json_decode($string, true);
    $dogs = array();
    foreach($json_a as $key=>&$value){
        unset($value['fields']['geo_shape']);
        // Only fields is useful in dogs
        $dogs[] = $value['fields'];
    }
    $fields = array_keys($dogs);
    // mysqli_query($con, "CREATE TABLE dogs (id integer auto_increment primary key, `status` varchar(100), `comment` text, `dates` varchar(100), `name` varchar(100), `url` varchar(100), geo_point_2d varchar(100), `regulation` varchar(100), `off_rules` varchar(100), `on_rules` varchar(100))");
    // foreach($dogs as $path)
    // {
    //     mysqli_query($con, "INSERT INTO dogs VALUES (null,'".addslashes($path['status'])."','".addslashes($path['comment'])."','".addslashes($path['dates'])."','".addslashes($path['name'])."','".addslashes($path['url'])."','".implode(',',$path['geo_point_2d'])."','".addslashes($path['regulation'])."','".addslashes($path['off_rules'])."','".addslashes($path['on_rules'])."')") or die(mysqli_error($con));
    // }
    // echo "<pre>".print_r($dogs,1);die();

    $string = file_get_contents("2.json");
    $json_a = json_decode($string, true);
    
    // mysqli_query($con, "CREATE TABLE paths (id integer auto_increment primary key, `perimeter` integer, `pos_id` integer, `mslink` integer, shape_area decimal(20,10), `objectid` integer, places_pos integer, mapid integer, oscategory varchar(5), geodb_oid integer, shape_len decimal(20,10), geo_point_2d varchar(100))") or die(mysqli_error($con));
    // foreach($json_a as $path)
    // {
    //     $path = $path['fields'];
    //     mysqli_query($con, "INSERT INTO paths VALUES (null,".addslashes($path['perimeter']).",".addslashes($path['pos_id']).",".addslashes($path['mslink']).",".addslashes($path['shape_area']).",".addslashes($path['objectid']).",".addslashes($path['places_pos']).",".addslashes($path['mapid']).",'".addslashes($path['oscategory'])."',".addslashes($path['geodb_oid']).", ".addslashes($path['shape_len']).", '".implode(',',$path['geo_point_2d'])."')") or die(mysqli_error($con));
    // }
    

    // echo "<pre>".print_r($json_a,1);die();

    $string = file_get_contents("3.json");
    $json_a = json_decode($string, true);

    mysqli_query($con, "CREATE TABLE playgrounds (id integer auto_increment primary key, `name` varchar(50),geo_point_2d varchar(100))");
    foreach($json_a as $pg)
    {
        $pg = $pg['fields'];
        mysqli_query($con, "INSERT INTO playgrounds VALUES (null, '".$pg['pg_name']."','".implode(',',$pg['geo_point_2d'])."')") or die(mysqli_error($con));
    }

    echo "<pre>".print_r($json_a,1);die();
?>