    <footer class="bg-light text-dark py-5 border-top mt-5">
        <p class="text-center">
            &copy; 2020 Eldvisor.
        </p>
    </footer>
    <!-- Vendor scripts -->
    <!-- jQuery -->
    <script src='<?php echo base_url(); ?>assets/js/jquery.min.js'></script>
    <!-- Popper -->
    <script src='<?php echo base_url(); ?>assets/js/popper.min.js'></script>
    <!-- Bootstrap (Custom) -->
    <script src='<?php echo base_url(); ?>assets/js/bootstrap.min.js'></script>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/1370f26db3.js" crossorigin="anonymous"></script>
    <!-- Charts -->
    <script src="<?php echo base_url(); ?>assets/js/Chart.bundle.min.js"></script>
    <script>
        $(function() {
            // Attach active class to active page
            if(<?php echo $activePage == 'home'?'1':'false';?>)
                $("#homeNav").addClass('active');
            else if (<?php echo $activePage == 'charts'?'1':'false';?>)
                $("#healthNav").addClass('active');

            // Only initialize charts if this is the charts page.
            <?php if ($activePage == 'charts'){?>
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
                        <?php for ($i = 0; $i < count($male['n']); $i++) {
                            echo 'chart.data.datasets[0].data[' . $i . '] = ' . $male['y'][$i] . ';';
                            echo 'chart.data.datasets[1].data[' . $i . '] = ' . $male['n'][$i] . ';';
                        } ?>
                    } else if ($(this).val() == 'Female') {
                        <?php for ($i = 0; $i < count($female['n']); $i++) {
                            echo 'chart.data.datasets[0].data[' . $i . '] = ' . $female['y'][$i] . ';';
                            echo 'chart.data.datasets[1].data[' . $i . '] = ' . $female['n'][$i] . ';';
                        } ?>
                    } else {
                        <?php
                        $i = 0;
                        foreach ($y as $age => $yes) {
                            echo 'chart.data.datasets[0].data[' . $i . '] = ' . $yes . ';';
                            echo 'chart.data.datasets[1].data[' . $i++ . '] = ' . $n[$age] . ';';
                        }
                        ?>
                    }
                    chart.update();
                });
            <?php }?>
        })
    </script>
    </body>

    </html>