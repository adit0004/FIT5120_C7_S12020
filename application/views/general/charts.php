    <div class="container my-5 pt-5">
        <div class="row mt-5 pt-5">
            <div class="col-12">
                <label>Type of Data</label>
            </div>
        </div>
        <div class="row">
            <select id="dataset" class='form-control'>
                <option value="1">Met Guidelines for Physical Activity</option>
                <option value="2">Type of Exercise</option>
                <option value="3">Number of days of physical activity</option>
            </select>
        </div>
        <div class="row mt-4">
            <div class="col-12 col-md-9">
                <canvas id="chart" width="400" height="400"></canvas>
            </div>
            <div class="col-12 col-md-3">
                Filters
                <div id="row">
                    <div class="col-12">

                        <div class="custom-control custom-radio">
                            <input type="radio" id="genderAll" name="gender" class="custom-control-input" value="All" checked>
                            <label class="custom-control-label" for="genderAll">All</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="genderMale" name="gender" class="custom-control-input" value="Male">
                            <label class="custom-control-label" for="genderMale">Male</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="genderFemale" name="gender" class="custom-control-input" value="Female">
                            <label class="custom-control-label" for="genderFemale">Female</label>
                        </div>

                    </div>
                </div>
                <div id="filters"></div>
            </div>
        </div>

    </div>