    <section class="hero mt-4">
        <div class="hero-inner">
            <h1 class='display-1 text-white'>EldVisor</h1>
            <p class='text-white hero-lead'>Guiding you to a healthier life!</p>
        </div>
    </section>

    <div class="container-fluid mt-3 bg-white">
        <!-- Quick links section -->
        <div class="row p-4 m-5 d-flex justify-content-center">
            <div class="col-12 text-center">
                <h3>Quick Links</h3>
            </div>

            <div class="card-deck quick-links mt-4 row">
                <a href="<?php echo site_url(['general','showCharts']);?>" class="text-dark col-12 col-md-4">
                    <div class="card">
                        <img src="<?php echo base_url(); ?>assets/img/woman_near_flowers.jpg" class="card-img-top img-fluid">
                        <div class="card-body">
                            <h5 class="card-title">Health Facts</h5>
                            <p class="card-text">Understand how physical activity affects your health</p>
                        </div>
                    </div>
                </a>
                <a href="<?php echo site_url(['spaces', 'showSpaces']);?>" class="text-dark col-12 col-md-4">
                    <div class="card">
                        <img src="<?php echo base_url(); ?>assets/img/park.jpg" class="card-img-top img-fluid">
                        <div class="card-body">
                            <h5 class="card-title">Explore The Outdoors</h5>
                            <p class="card-text">Find spaces around you to exercise and get healthy</p>
                        </div>
                    </div>
                </a>
                <a href="<?php echo site_url(['events', 'showEvents']);?>" class="text-dark col-12 col-md-4">
                    <div class="card">
                        <img src="<?php echo base_url(); ?>assets/img/events.jpg" class="card-img-top img-fluid">
                        <div class="card-body">
                            <h5 class="card-title">Explore Events Around</h5>
                            <p class="card-text">Discover what's happening in the community</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <hr>

        <!-- Who we are section -->
        <div class="row p-4 m-5 d-flex align-items-center">
            <div class='col-12 col-md-4 text-center align-self-center'>
                <img src="<?php echo base_url(); ?>assets/img/logo_white_bg.jpg" style="max-height:250px;text-align:center;margin:auto" class="img-fluid">
            </div>
            <div class="col-12 col-md-8 text-center bg-light p-5 d-flex align-items-center">
                <div>
                    <h3>Who we are</h3>
                    <p style='font-size:1rem'>As a dedicated elderly assistance service team, EldVisor is devoted to making the elderly more physically active for the well being of their physical and mental health. Founded in 2020, our aim is to make the elderly engage in the community, through the convenient use of technology. This website aims to motivate the elderly to do physical activity and provide a one-stop platform to get details of fun locations and happening events in the nearby area for the amazing residents of the Greater Geelong area.</p>
                </div>
            </div>
        </div>
    </div>