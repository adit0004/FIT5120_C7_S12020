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
                            <p class="card-text">Understand health information and how it affects you</p>
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
                            <h5 class="card-title">Events</h5>
                            <p class="card-text">Discover what's happening in the community</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <hr>

        <!-- Who we are section -->
        <div class="row p-4 m-5">
            <div class='col-12 col-md-6 text-center'>
                <img src="<?php echo base_url(); ?>assets/img/logo_white_bg.jpg" style="max-height:300px;text-align:center;margin:auto" class="img-fluid">
            </div>
            <div class="col-12 col-md-6 text-center bg-light p-5 d-flex align-items-center">
                <div>
                    <h3>Who we are</h3>
                    <p style='font-size:1rem'>As a dedicated Elderly Assistance Service, EldVisor is devoted to making life easier in and around the house. Founded in 2020, we offer home care and maintenance services for all, providing personalized administrative and health care for the Greater Geelong area. We do our best to provide affordable solutions and take care to respect your privacy and preferences.</p>
                </div>
            </div>
        </div>
    </div>