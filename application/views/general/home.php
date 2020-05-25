    <section class="hero hero-homepage mt-4">
        <div class="hero-inner">
            <h1 class='display-1 text-white'>EldVisor</h1>
            <p class='text-white hero-lead'>Guiding you to a healthier life!</p>
            <a href="#moreInfo" class="btn btn-primary btn-lg mt-3">Find out more <i class="fa fa-caret-down"></i></a>
        </div>
    </section>

    <div class="container-fluid mt-3" id="moreInfo">
        <!-- Quick links section -->
        <div class="row p-4 m-5 d-flex justify-content-center">
            <div class="col-12 col-lg-8">
                <!-- <p class="larger-text">Built for the elderly of Greater Geelong Area to help explore open spaces and fun events nearby. EldVisor aims to break the monotony of an inactive lifestyle indoors and take the elderly closer to a healthier and happier retirement life, by motivating through health facts and making one feel connected to the community.</p> -->
                <p class="larger-text text-center">EldVisor aims to break the monotony of an inactive lifestyle indoors and take the elderly closer to a healthier and happier retirement life, by motivating through health facts and making one feel connected to the community.</p>
            </div>

            <div class="col-12 col-md-8 col-lg-6 mt-5">
                <div class="row">
                    <div class="col-6" style='border-right:2px solid #e93f4a;'>
                        <p class="larger-text text-center">Almost 25%</p>
                        <p class="text-center">of the people in Greater Geelong are over 60 years old</p>
                    </div>
                    <div class="col-6">
                        <p class="text-center">It doesn't seem like much, but that's</p>
                        <p class="larger-text text-center">over 50,000 people!</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-8">
                <p class="larger-text text-center mt-5">EldVisor is built for the elderly of Greater Geelong Area to help explore open spaces and fun events nearby.</p>
            </div>
            <div class="col-12 text-center">
                <a href="#healthFacts" class="btn btn-lg btn-primary mt-5">What can EldVisor do for me?</a>
            </div>

        </div>
        <div class="row p-5 d-flex align-items-center bgimg-2" id="healthFacts">
            <div class="col-12 col-md-8 offset-md-2 p-5 larger-text text-white" style="margin-top:200px; text-align:justify;">
                Regular physical activity is proven to have health benefits along with reducing risk of developing Dementia and Alzheimer’s disease and mortality among older adults.
                <div class="row">
                    <div class="col-12 text-center">
                        <a href="<?php echo site_url(['general', 'personalizedQuiz']); ?>" class="btn btn-lg btn-primary p-3 larger-text px-5 mt-3">See Health Facts</a>
                    </div>
                </div>
            </div>
            <a class="btn btn-rounded btn-primary align-self-end mb-5" style="height:75px; width:75px; border-radius:50%; font-size:40px;" href="#exploreOutdoors"><i class="fa fa-arrow-down"></i></a>
        </div>

        <!-- Open Spaces -->
        <div class="row p-5 d-flex align-items-center bgimg-3" id="exploreOutdoors">
            <div class="col-12 col-md-8 offset-md-2 p-5 larger-text text-white" style="margin-top:200px; text-align:justify;">
                Getting outdoors not only boosts energy but also helps in connecting with people having similar interests, making it easier to have a more social life. The elderly of Greater Geelong can benefit a great deal by exploring the various option available below, so as to have an outing at their convenience.
                <div class="row">
                    <div class="col-12 text-center">
                        <a href="<?php echo site_url(['spaces', 'showSpaces']); ?>" class="btn btn-lg btn-primary p-3 larger-text px-5 mt-3">Explore the Outdoors</a>
                    </div>
                </div>
            </div>
            <a class="btn btn-rounded btn-primary align-self-end mb-5" style="height:75px; width:75px; border-radius:50%; font-size:40px;" href="#exploreEvents"><i class="fa fa-arrow-down"></i></a>
        </div>

        <!-- Events -->
        <div class="row p-5 d-flex align-items-center bgimg-4" id="exploreEvents">
            <div class="col-12 col-md-8 offset-md-2 p-5 larger-text text-white" style="margin-top:200px; text-align:justify;">
                Greater Geelong area is involved with a significant number of awesome events each year for family and friends to participate and enjoy. Click below to track the famed events and activities.
                <div class="row">
                    <div class="col-12 text-center">
                        <a href="<?php echo site_url(['events', 'showEvents']); ?>" class="btn btn-lg btn-primary p-3 larger-text px-5 mt-3">Explore Events Around</a>
                    </div>
                </div>
            </div>
        </div>

    </div>