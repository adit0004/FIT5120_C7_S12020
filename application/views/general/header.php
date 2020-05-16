<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>assets/css/bootstrap.css'>
    <link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>assets/css/custom.css'>
    <!-- Chartist -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
    <!-- Datepicker -->
    <link rel="stylesheet" type='text/css' href="<?php echo base_url(); ?>assets/css/bootstrap-datepicker.min.css">
    <title>EldVisor</title>
</head>

<body class='background-image'>

    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <a class="navbar-brand" href="<?php echo base_url(); ?>"><h4>EldVisor</h4></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor03">
            <div id="weatherContainer" class='mr-auto'></div>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item ml-4" id="homeNav">
                    <a class="nav-link" href="<?php echo site_url(['general', 'index']); ?>">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item ml-4" id="personalNav">
                    <a class="nav-link" href="<?php echo site_url(['general', 'personalizedQuiz']); ?>">Know your own Health</a>
                </li>
                <li class="nav-item ml-4" id="placesNav">
                    <a class="nav-link" href="<?php echo site_url(['spaces', 'showSpaces']); ?>">Explore the Outdoors</a>
                </li>
                <li class="nav-item ml-4" id="eventsNav">
                    <a class="nav-link" href="<?php echo site_url(['events', 'showEvents']); ?>">Explore Events Around</a>
                </li>
                <li class="nav-item ml-4" id="crimeNav">
                    <a class="nav-link" href="<?php echo site_url(['general', 'crimeStats']); ?>">Crime Statistics</a>
                </li>
                <!-- <li class="nav-item ml-4">
                    <a class="nav-link" href="#">News</a>
                </li>
                <li class="nav-item ml-4">
                    <a class="nav-link" href="#">About Us</a>
                </li> -->
            </ul>
            <!-- <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="text" placeholder="Search">
                <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search <i class="fa fa-search"></i></button>
            </form> -->
        </div>
    </nav>

    <?php if(isset($breadcrumbs)) {?>
    <div class="container-fluid px-0" style="margin-top:70px;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bc-whitebg mb-0">
                <?php
                $i = 1;
                foreach ($breadcrumbs as $pageName => $url) {
                    if ($i == sizeof($breadcrumbs)) {
                        // This is the active page, add the active class
                        echo "<li class='breadcrumb-item active' aria-current='page'>" . $pageName . "</li>";
                    } else {
                        echo "<li class='breadcrumb-item'><a href='" . $url . "'>" . $pageName . "</a></li>";
                    }
                    $i++;
                }
                ?>
            </ol>
        </nav>
    </div>
    <?php }?>