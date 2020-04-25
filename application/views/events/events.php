<section class="hero hero-events mt-5">
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
    <?php echo form_open(site_url(['events', 'showEvents']));?>
    <div class="row d-flex align-items-end">
        <div class="col-12 col-md-3">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="<?php echo isset($filters['name'])?$filters['name']:'default';?>" class="form-control">
        </div>
        <div class="col-12 col-md-3">
            <label for="startDate">Start Date</label>
            <input type="text" name="startDate" id="startDate" value="<?php echo isset($filters['startDate'])?$filters['startDate']:'default';?>" class="form-control">
        </div>
        <div class="col-12 col-md-3">
            <label for="endDate">End Date</label>
            <input type="text" name="endDate" id="endDate" value="<?php echo isset($filters['endDate'])?$filters['endDate']:'default';?>" class="form-control">
        </div>
        <div class="col-6 offset-3 col-md-3 offset-md-0 align-self-bottom">
            <button type='submit' class="btn btn-outline-dark btn-block">Refine</a>
        </div>
    </div>
    <?php echo form_close();?>
    <div class="row mt-5">
        <div class="col-12">
            <h4>Events</h4>
        </div>

        <?php foreach ($events as $event) { ?>
            <div class="col-12 card mt-4 px-0">
                <div class="card-body px-5 py-5">
                    <div class="row">
                        <div class="col-12 col-md-8">
                            <strong class="card-title"><?php echo $event['title'];?></strong>
                            <?php if(!empty($event['dtstart']) && !empty($event['dtend'])) {?>
                                <p class='text-muted'><?php echo date('d M Y', strtotime($event['dtstart']));?> - <?php echo date('d M Y', strtotime($event['dtend']));?></p>
                                <strong>Description</strong>
                            <?php } else if(!empty($event['dtsummary'])){?>
                                <p class='text-muted'><?php echo $event['dtsummary'];?></p>
                                <strong>Description</strong>
                            <?php } else {?>
                                <strong class='d-block mt-3'>Description</strong>
                            <?php }?>
                            <p class="card-text"><?php echo $event['description'];?></p>
                            <strong>Location</strong>
                            <address><?php $location = explode(",",$event['location']);echo $location[0];?><br> <?php if(isset($location[1])) echo $location[1];?></address>
                        </div>
                        <div class="col-12 col-md-4">
                            <a href="#!" class='btn btn-dark d-block py-3 mt-3'><i class="fa fa-calendar-week"></i> View Calendar Details</a>
                            <a href="#!" class='btn btn-primary d-block py-3 mt-3'><i class="fa fa-building"></i> View Organization Details</a>
                            <a href="#!" class='btn btn-info d-block py-3 mt-3'><i class="fa fa-directions"></i> Get Directions</a>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                            <p><?php if(!empty($event['website'])) {?><i class="fa fa-globe"></i> <a href="<?php echo $event['website'];?>" class='text-dark'><u><?php echo $event['website'];?></u></a> <?php if(!empty($event['phone']) || !empty($event['email'])) echo "|";?> <?php } if(!empty($event['phone'])){?><i class="fa fa-phone"></i> <?php echo $event['phone']; if(!empty($event['email'])) echo " | "; } if(!empty($event['email'])){?><i class="fa fa-envelope"></i> <?php echo $event['email'];?><?php }?></p>
                </div>
            </div>
        <?php } ?>

        <!-- Pages -->
    </div>


</div>