    <div class="container mt-5 bg-white">
        <!-- Quick links section -->
        <div class="row p-4 m-5 d-flex justify-content-center">
            <div class="col-12 text-center mt-5">
                <h1 class='display-3 mt-5'><?php echo $categoryName;?></h1>
            </div>
        </div>

        <!-- Todo: Filters to come here -->
        <div class="row">
            <div class="col-12">
                <p class="text-muted">Todo: Filters to come here</p>
            </div>
        </div>

        <div class="row p-3 m-3 no-gutters">
            <div class="col-12 col-md-4">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                            foreach($spaces as $space)
                            {
                                echo "<tr>";
                                echo "<td>".$i++."</td>";
                                if(!empty($space['name']))
                                {
                                    echo "<td><a href='#!' class='text-dark'><u>".ucwords(strtolower($space['name']))."</u></a></td>";
                                }
                                else 
                                {
                                    echo "<td><a href='#!' class='text-dark'><u>Unnamed Location</u></a></td>";
                                }
                                echo "</tr>";
                            }
                            // Todo: Paginate
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="col-12 col-md-8">
                <div id="map" class='h-100' style="min-height:500px!important;"></div>
            </div>
        </div>
    </div>