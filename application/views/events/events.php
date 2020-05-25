<section class="hero hero-events">
    <div class="hero-inner">
        <h1 class='display-1 text-white'>Events</h1>
        <p class='text-white hero-lead'>Stay connected!</p>
    </div>
</section>

<div class="container mt-5 bg-white">
    <div class="row">
        <div class="col-12 mb-3">
            <!-- Filters -->
            <h4>Filters</h4>
        </div>
    </div>
    <?php echo form_open(site_url(['events', 'showEvents'])); ?>
    <div class="row d-flex align-items-end">
        <div class="col-12 col-md-3">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="<?php echo (isset($filters['name']) && $filters['name'] !== 0) ? $filters['name'] : ''; ?>" class="form-control" placeholder="Search for an event">
        </div>
        <div class="col-12 col-md-3">
            <label for="startDate">Start Date</label>
            <input type="text" name="startDate" id="startDate" value="<?php echo (isset($filters['startDate']) && $filters['startDate'] != 0) ? $filters['startDate'] : $earliestDate; ?>" class="form-control">
        </div>
        <div class="col-12 col-md-3">
            <label for="endDate">End Date</label>
            <input type="text" name="endDate" id="endDate" value="<?php echo (isset($filters['endDate']) && $filters['endDate'] != 0) ? $filters['endDate'] : $latestDate; ?>" class="form-control">
        </div>
        <div class="col-12 col-md-3">
            <label for="endDate">Tag</label>
            <select class="form-control" name="eventCategory">
                <option value="All">All Events</option>
                <?php
                    foreach($categories as $category) {
                        if($filters['category'] == $category['event_category'])
                            echo "<option value='".$category['event_category']."' selected>".$category['event_category']."</option>";
                        else
                            echo "<option value='".$category['event_category']."'>".$category['event_category']."</option>";
                    }
                ?>
            </select>
        </div>
        <div class="col-12 col-md-3 offset-md-9 mt-3">
            <button type='submit' class="btn btn-outline-dark btn-block">Refine</a>
        </div>
    </div>
    <?php echo form_close(); ?>
    <div class="row mt-5">
        <div class="col-12">
            <h4>Events</h4>
            <p class="text-muted">Showing results <?php echo $count < 9 ? ($count == 0 ? '0' : "1 to " . $count) : ((($page - 1) * 9) + 1) . " - " . ((($page - 1) * 9) + 9) . " of " . $count; ?></p>
        </div>
        <?php $iterator = 0;
        foreach ($events as $event) { ?>
            <?php if ($iterator == 0) { ?>
                <div class="card-deck">
                <?php } ?>
                <div class="card col-12 col-md-4 mt-4 px-0">
                    <?php if ($event['event_category'] == "Arts/Cultural") $img = "Arts.jpg";
                    else if ($event['event_category'] == "Center Geelong") $img = "CenterGeelong.jpg";
                    else $img = $event['event_category'] . ".jpg";
                    ?>
                    <img src="<?php echo base_url(); ?>assets/img/events/<?php echo $img; ?>" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title mb-1"><?php echo $event['title']; ?></h5>
                        <?php if (!empty($event['dtstart']) && !empty($event['dtend']) && $event['dtstart'] != $event['dtend']) { ?>
                            <p class='text-muted'><?php echo date('d M Y', strtotime($event['dtstart'])); ?> - <?php echo date('d M Y', strtotime($event['dtend'])); ?></p>
                        <?php } else if (!empty($event['dtstart']) && !empty($event['dtend']) && $event['dtstart'] == $event['dtend']) { ?>
                            <p class='text-muted'><?php echo date('d M Y', strtotime($event['dtstart'])); ?></p>
                        <?php } else if (!empty($event['dtsummary'])) { ?>
                            <p class='text-muted'><?php echo $event['dtsummary']; ?></p>
                        <?php } else { ?>
                            <strong class='d-block mt-3'>Description</strong>
                        <?php } ?>
                        <p><?php echo $event['location']; ?></p>
                        <p class="text-muted"><strong>Tag: </strong><?php echo $event['event_category']; ?></p>
                    </div>
                    <div class="card-footer bg-white">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <a href="<?php echo $event['link']; ?>" class="btn btn-dark btn-block" target="_blank"><i class="fa fa-calendar-week"></i> Calendar</a>
                            </div>
                            <?php if (isset($event['website'])) { ?>

                                <div class="col-12 col-md-6">
                                    <a href="<?php if(substr($event['website'],0,4) == "http") echo $event['website']; else echo "http://".$event['website'] ?>" class="btn btn-primary btn-block" target="_blank"><i class="fa fa-building"></i> Website</a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php
                $iterator++;
                if ($iterator == 3) {
                    echo "</div>";
                    $iterator = 0;
                } ?>
            <?php } ?>
            <?php
            if (empty($events)) {
                echo "<h5>No results found for current search. Try broadening your search!</h5>";
            }
            ?>

            <!-- Pages -->
            <?php if ($pages > 1) { ?>
                <div class="col-12 text-center mt-5">
                    <div class='d-flex justify-content-center'>
                        <nav aria-label="Page Navigation">
                            <ul class="pagination">
                                <?php if ($page != 1) { ?>
                                    <li class="page-item"><a class="page-link text-dark" href="<?php echo site_url(['events', 'showEvents', $page - 1, $filters['name'], $filters['startDate'], $filters['endDate']]); ?>">Previous</a></li>
                                <?php } ?>
                                <?php if ($page != 1 && $page != 2) { ?>
                                    <li class="page-item"><a class="page-link text-dark" href="<?php echo site_url(['events', 'showEvents', $page - 2, $filters['name'], $filters['startDate'], $filters['endDate']]); ?>"><?php echo $page - 2; ?></a></li>
                                <?php } ?>
                                <?php if ($page != 1) { ?>
                                    <li class="page-item"><a class="page-link text-dark" href="<?php echo site_url(['events', 'showEvents', $page - 1, $filters['name'], $filters['startDate'], $filters['endDate']]); ?>"><?php echo $page - 1; ?></a></li>
                                <?php } ?>
                                <li class="page-item"><a class="page-link text-light bg-dark" href="#!"><?php echo $page; ?></a></li>
                                <?php if ($page < $pages) { ?>
                                    <li class="page-item"><a class="page-link text-dark" href="<?php echo site_url(['events', 'showEvents', $page + 1, $filters['name'], $filters['startDate'], $filters['endDate']]); ?>"><?php echo $page + 1; ?></a></li>
                                <?php } ?>
                                <?php if ($page != $pages && $page != ($pages - 1)) { ?>
                                    <li class="page-item"><a class="page-link text-dark" href="<?php echo site_url(['events', 'showEvents', $page + 2, $filters['name'], $filters['startDate'], $filters['endDate']]); ?>"><?php echo $page + 2; ?></a></li>
                                    <li class="page-item"><a class="page-link text-dark" href="<?php echo site_url(['events', 'showEvents', $page + 2, $filters['name'], $filters['startDate'], $filters['endDate']]); ?>">Next</a></li>
                                <?php } ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            <?php } ?>
                </div>


    </div>