    <div class="container-fluid mt-5 bg-white">
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

        <div class="row p-3 m-3">
            <div class="col-12">

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
                            foreach($spaces as $space)
                            {
                                echo "<tr>";
                                echo "<td>".$i."</td>";
                                if(!empty($space['name']))
                                {
                                    echo "<td>".ucwords(strtolower($space['name']))."";
                                }
                                else 
                                {
                                    echo "<td>Unnamed Location";
                                }
                                echo "<br><span class='text-muted' id='addressBlock'>";
                                echo "</span>";
                                echo "</td>";
                                echo "<td><button class='btn btn-outline-dark' onClick='seeOnMap(".($i-1).")'>See on map</button></td>";
                                echo "</tr>";
                                $i++;
                            }
                            // Todo: Paginate
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="col-12 mt-3">
                <div id="map" class='h-100' style="min-height:700px!important;"></div>
            </div>
        </div>
    </div>