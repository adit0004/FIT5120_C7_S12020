<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>assets/css/bootstrap.css'>
    <link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>assets/css/custom.css'>
    <title>EldVisor</title>
</head>

<body class='bg-light background-image'>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#"><img src="<?php echo base_url();?>assets/img/nav_logo.png"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor03">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Elderly Health</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About Us</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="text" placeholder="Search">
                <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-12 col-md-9 pt-4 pb-2">
                <div class="col-12">
                    <div class="row pt-4 pb-2 px-4 card-custom">
                        Open Space Icon Here
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3 pt-4 pb-2">
                <div class="col-12">
                    <div class="row pt-4 pb-2 px-4 card-custom">
                        <div class="row d-flex align-items-left">
                            <div class="col-3">
                                <h1><i class="fa fa-cloud-sun-rain"></i></h1>
                            </div>
                            <div class="col-9">
                                <h4>23 &deg; C<br>
                                Rain Today</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- AQI and weather information -->
            </div>
        </div>
    </div>
    <!-- Vendor scripts -->
    <!-- jQuery -->
    <script src='<?php echo base_url(); ?>assets/js/jquery.min.js'></script>
    <!-- Popper -->
    <script src='<?php echo base_url(); ?>assets/js/popper.min.js'></script>
    <!-- Bootstrap (Custom) -->
    <script src='<?php echo base_url(); ?>assets/js/bootstrap.min.js'></script>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/1370f26db3.js" crossorigin="anonymous"></script>
</body>

</html>