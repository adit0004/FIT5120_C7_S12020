<section class="hero hero-spaces mt-4">
    <div class="hero-inner">
        <h1 class='display-1 text-white'>Open Spaces</h1>
        <!-- <p class='text-white hero-lead'>Guiding you to a healthier life!</p> -->
    </div>
</section>

<div class="container mt-5 bg-white">
    <div class="row mb-5">
        <div class="col-12 col-md-6 p-5 d-flex align-items-center">
            <div>
                <h1 class="align-self-center">Greater Geelong Open Spaces</h1>
                <p class="mt-5 align-self-center">EldVisor aims to help older people in Greater Geelong stay connected with the community by providing information about nearby open spaces such as parks, meditation centers, trails and others.</p>
                <a href="#featuredSpaces" class='btn btn-primary btn-lg'>See places &rarr;</a>
            </div>
        </div>
        <div class="col-12 col-md-6 text-center">
            <img src="<?php echo base_url(); ?>assets/img/open_glass_window.jpeg" class="img-fluid" style="max-height:600px;">
        </div>
    </div>
    <hr class='my-5'>
</div>
<div class="container-fluid mt-5" id="featuredSpaces">
    <div class="row mt-5">
        <div class="col-12">
            <h1 class="display-3 text-center">Featured Spaces</h1>
        </div>
    </div>
    <div class="row mt-3 custom-image-grid">
        <?php
            foreach($places as $place){
                echo "<div class='col-6 col-md-3 custom-card my-5 text-center'>";
                echo "<a href='".site_url(['spaces','showSpacesMap',$place['area_id']])."' class='d-block h-100'><img class='img-fluid' src='".$place['area_image_url']."'></a>";
                echo "<a href='".site_url(['spaces','showSpacesMap',$place['area_id']])."' class='text-dark'>".$place['area_name']."</a>";
                echo "</div>";
            }
        ?>
    </div>
    <div class="row mt-5">
        <div class="col-12 text-center">
            <a class="btn btn-primary btn-lg text-white" href="<?php echo site_url(['spaces', 'moreSpaces']);?>">See More Spaces <i class="fa fa-arrow-right"></i></a>
        </div>
    </div>
</div>