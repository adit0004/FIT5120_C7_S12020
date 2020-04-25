<section class="hero hero-spaces mt-4">
    <div class="hero-inner">
        <h1 class='display-1 text-white'>Open Spaces</h1>
        <!-- <p class='text-white hero-lead'>Guiding you to a healthier life!</p> -->
    </div>
</section>

<div class="container">
    <div class="row mt-5">
        <div class="col-12">
            <h1 class="display-3 text-center">All Spaces</h1>
        </div>
    </div>
    <div class="row mt-3 custom-image-grid">
        <?php
            foreach($places as $place){
                echo "<div class='col-6 col-md-3 custom-card my-5 text-center'>";
                echo "<a style='border-radius:30px;max-height:100px;' href='".site_url(['spaces','showSpacesMap',$place['area_id']])."' class='d-block h-40'><img class='img-fluid' style='bottom:0;' src='".$place['area_image_url']."'></a>";
                echo "<a href='".site_url(['spaces','showSpacesMap',$place['area_id']])."' class='text-dark'>".$place['area_name']."</a>";
                echo "</div>";
            }
        ?>
    </div>
</div>