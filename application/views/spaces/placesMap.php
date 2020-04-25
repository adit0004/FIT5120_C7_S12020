    <div class="container-fluid mt-5 bg-white">
        <!-- Quick links section -->
        <div class="row p-4 m-5 d-flex justify-content-center">
            <div class="col-12 text-center mt-5">
                <h1 class='display-3 mt-5'><?php echo $categoryName; ?></h1>
            </div>
        </div>

        <div class="row p-3 m-3" id="displayTable">
            <div class="col-12 col-md-8">

                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Place Details</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        // echo "<pre>".print_r($spaces,1);die();
                        foreach ($spaces as $space) {
                            echo "<tr>";
                            echo "<td>" . ($i+(($page-1)*10)) . "</td>";
                            if (!empty($space['name'])) {
                                echo "<td class='d-flex'><div class='col-6'>" . ucwords(strtolower($space['name'])) . "";
                            } else {
                                echo "<td class='d-flex'><div class='col-6'>Unnamed Location";
                            }
                            echo "<br><span class='text-muted' id='addressBlock'><div class='spinner-border' role='status'><span class='sr-only'>Loading...</span></div>";
                            echo "</span></div><div class='col-6 text-right'>";
                            echo "<span id='weatherBlock'><button class='btn btn-outline-dark' onclick='getWeatherAndAqiOnClick(" . $i . "," . $space['lat'] . "," . $space['long'] . ")'>Know Weather</button></span>";
                            echo "</div></td>";
                            echo "<td><button class='btn btn-outline-dark' onClick='seeOnMap(" . ($i - 1) . ")'>See on map</button></td>";
                            echo "</tr>";
                            $i++;
                        }
                        if (empty($spaces)) {
                            echo "<tr><td colspan = '3'>No results found for current search. Try broadening your search!</td></tr>";
                        }
                        ?>

                    </tbody>
                </table>
                <?php // Todo: Paginate
                if ($pages > 1) { ?>
                    <div class='d-flex justify-content-center'>
                        <nav aria-label="Page Navigation">
                            <ul class="pagination">
                                <?php if ($page != 1) { ?>
                                    <li class="page-item"><a class="page-link text-dark" href="#">Previous</a></li>
                                <?php } ?>
                                <?php if ($page != 1 && $page != 2){?>
                                    <li class="page-item"><a class="page-link text-dark" href="<?php echo site_url(['spaces', 'showSpacesMap', $spaceId, $page-2, $filters['distanceFromUser'], $filters['userLocation']['latitude'], $filters['userLocation']['longitude'], $filters['category']]);?>"><?php echo $page-2;?></a></li>
                                <?php }?>
                                <?php if ($page != 1) {?>
                                    <li class="page-item"><a class="page-link text-dark" href="<?php echo site_url(['spaces', 'showSpacesMap', $spaceId, $page-1, $filters['distanceFromUser'], $filters['userLocation']['latitude'], $filters['userLocation']['longitude'], $filters['category']]);?>"><?php echo $page-1;?></a></li>
                                <?php }?>
                                <li class="page-item"><a class="page-link text-light bg-dark" href="#!"><?php echo $page;?></a></li>
                                <?php if ($page < $pages){?>
                                    <li class="page-item"><a class="page-link text-dark" href="<?php echo site_url(['spaces', 'showSpacesMap', $spaceId, $page+1, $filters['distanceFromUser'], $filters['userLocation']['latitude'], $filters['userLocation']['longitude'], $filters['category']]);?>"><?php echo $page+1;?></a></li>
                                <?php }?>
                                <?php if ($page != $pages && $page != ($pages - 1)) { ?>
                                    <li class="page-item"><a class="page-link text-dark" href="<?php echo site_url(['spaces', 'showSpacesMap', $spaceId, $page+2, $filters['distanceFromUser'], $filters['userLocation']['latitude'], $filters['userLocation']['longitude'], $filters['category']]);?>"><?php echo $page+2;?></a></li>
                                    <li class="page-item"><a class="page-link text-dark" href="<?php echo site_url(['spaces', 'showSpacesMap', $spaceId, $page+2, $filters['distanceFromUser'], $filters['userLocation']['latitude'], $filters['userLocation']['longitude'], $filters['category']]);?>">Next</a></li>
                                <?php } ?>
                            </ul>
                        </nav>
                    </div>
                <?php } ?>
            </div>
            <div class="col-12 col-md-4 px-5">
                <h3>Refine results:</h3>
                <?php echo form_open(site_url(['spaces', 'showSpacesMap', $spaceId])); ?>
                <div class='form-group mt-4'>
                    <label for="locationFilter">Your location</label>
                    <input class='form-control' name='locationFilter' id='locationFilter' type='text'>
                </div><hr class='my-5'>
                <div class='form-group'>
                    <label for="distanceFilter">Maximum Distance From You (Approximate)</label>
                    <select class='form-control' name='distanceFilter' id="distanceFilter">
                        <?php if ($filters['distanceFromUser'] == "All") { ?>
                            <option value='All' selected>Show All</option>
                        <?php } else { ?>
                            <option value='All'>Show All</option>
                        <?php } ?>
                        <?php if ($filters['distanceFromUser'] == "100") { ?>
                            <option value='100' selected>100 km</option>
                        <?php } else { ?>
                            <option value='100'>100 km</option>
                        <?php } ?>
                        <?php if ($filters['distanceFromUser'] == "10") { ?>
                            <option value='10' selected>10 km</option>
                        <?php } else { ?>
                            <option value='10'>10 km</option>
                        <?php } ?>
                        <?php if ($filters['distanceFromUser'] == "5") { ?>
                            <option value='5' selected>5 km</option>
                        <?php } else { ?>
                            <option value='5'>5 km</option>
                        <?php } ?>
                        <?php if ($filters['distanceFromUser'] == "1") { ?>
                            <option value='1' selected>1 km</option>
                        <?php } else { ?>
                            <option value='1'>1 km</option>
                        <?php } ?>
                    </select>
                </div>
                <hr class='my-5'>
                <div class='form-group mt-4 d-none'>
                    <label for="categoryFilter">Categories</label>
                    <select class='form-control' name='categoryFilter' id="categoryFilter">
                        <option value="All">Show All</option>
                        <?php foreach ($category as $code => $cat) {
                            if ($code == $filters['category'])
                                echo "<option value='" . $code . "' selected>" . $cat . "</option>";
                            else echo "<option value='" . $code . "'>" . $cat . "</option>";
                        } ?>
                    </select>
                </div>
                <input type="hidden" name="lat" id="lat" value=<?php echo $filters['userLocation']['latitude'];?>>
                <input type="hidden" name="long" id="long" value=<?php echo $filters['userLocation']['longitude'];?>>
                <button type="submit" class="btn btn-outline-dark mt-5">Refine</button>
                <?php echo form_close(); ?>
            </div>
            <?php if (!empty($spaces)) { ?>
                <div class="col-12 mt-3 text-center mb-4">
                    <div id="map" class='h-100' style="min-height:600px!important;"></div>
                    <a href="#displayTable" class='btn btn-outline-dark mt-4'>Back to table</a>
                </div>
            <?php } ?>
        </div>
    </div>
        <!-- Maps -->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCrGmHjWjkwhyXqb9HDaiwQ9htOZCrs0Hs&callback=initMap&libraries=places" async defer></script>