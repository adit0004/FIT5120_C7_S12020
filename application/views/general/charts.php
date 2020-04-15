<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-alt.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/Chart.css">
    <title>Document</title>
</head>

<body>
    <div class="container mt-4">
        <div class="row">
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
    <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/Chart.bundle.min.js"></script>
    <script>
        $(function() {
            // Initialize with met guidelines
            const ctx = document.getElementById('chart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['<?php echo implode('\',\'', array_keys($y)); ?>'],
                    datasets: [{
                        label: 'Yes',
                        data: [<?php echo implode(',', $y); ?>],
                        backgroundColor: "rgba(122, 148, 97, 1)",
                        // categoryPercentage:1.0,
                        barPercentage: 0.9
                    }, {
                        label: 'No',
                        data: [<?php echo implode(',', $n); ?>],
                        backgroundColor: "rgba(155, 61, 61, 1)",
                        barPercentage: 0.9
                    }]
                },
                options: {
                    categoryPercentage: 1.0,
                }
            });
            $(ctx).data('chart', chart)
            $('input[name="gender"]').on('change', function(e) {
                // console.log($(this).val());
                var chart = $(ctx).data('chart');
                if ($(this).val() == 'Male') {
                    <?php for ($i = 0 ; $i < count($male['n']); $i++){
                        echo 'chart.data.datasets[0].data['.$i.'] = '.$male['y'][$i].';';
                        echo 'chart.data.datasets[1].data['.$i.'] = '.$male['n'][$i].';';
                    }?>
                } else if ($(this).val() == 'Female') {
                    <?php for ($i = 0 ; $i < count($female['n']); $i++){
                        echo 'chart.data.datasets[0].data['.$i.'] = '.$female['y'][$i].';';
                        echo 'chart.data.datasets[1].data['.$i.'] = '.$female['n'][$i].';';
                    }?>
                }
                else{
                    <?php 
                    $i = 0;
                    foreach($y as $age=>$yes){
                        echo 'chart.data.datasets[0].data['.$i.'] = '.$yes.';';
                        echo 'chart.data.datasets[1].data['.$i++.'] = '.$n[$age].';';
                    }
                    ?>
                }
                    chart.update();
            });
        })
    </script>
</body>

</html>