<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content-header">
        <h3> Dashboard </h3>
    </section>
    <section class="content pt-2 pb-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?php echo $employee_count; ?></h3>
                            <p>Employee</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-file-code"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3><?php echo $user_count; ?></h3>
                            <p>User</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-user"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3><?php echo $shift_rule_count; ?></h3>
                            <p>Shift Rule</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-address-book"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3><?php echo $shift_plan_count; ?></h3>
                            <p>Shift Plan</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-address-card"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <div class="row mt-2">
                <div class="col-sm-6">
                    <!-- BAR CHART -->
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title font-weight-bold"> Last 7 Days Attendance:</h3>
                        </div>
                        <div class="box-body">
                            <div class="chart">
                                <canvas id="barChart" style="height:250px"></canvas>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
                <div class="col-sm-6">
                    <!-- PIE CHART -->
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title font-weight-bold"> Last 7 Days Late:</h3>
                        </div>
                        <div class="box-body">
                            <div class="chart">
                                <canvas id="pieChart" style="height:250px"></canvas>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- ChartJS -->
<script src="<?php echo asset('plugins/Chart.js-2.9.4/dist/Chart.bundle.min.js'); ?>"></script>
<script>
    $(function () {
        /* ChartJS
        * -------
        * Here we will create a few charts using ChartJS
        */

        //-------------
        //- BAR CHART -
        //-------------
        var barChartCanvas = $('#barChart').get(0).getContext('2d');
        var barChart = new Chart(barChartCanvas, {
            type: 'bar',
            data: {
                labels  : [<?php print_r($work_date);?>],
                datasets: [{
                    label: 'Absent',
                    barThickness: 25,
                    data: [<?php echo $absent_data;?>],
                    backgroundColor: '#dc3545',
                    borderColor:     'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                },{
                    label: 'Present',
                    barThickness: 25,
                    data: [<?php echo $present_data;?>],
                    backgroundColor: '#17a2b8',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1
                },{
                    label: 'Leave',
                    barThickness: 25,
                    data: [<?php echo $lv_data;?>],
                    backgroundColor: '#ffc107',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    xAxes: [{
                        type: 'time'
                    }],
                }
            }
        });

        //-------------
        //- BAR CHART -
        //-------------
        var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
        var pieChart = new Chart(pieChartCanvas, {
            type: 'doughnut',
            data: {
                labels  : [<?php print_r($work_date);?>],
                datasets: [{
                    label: '# of Late',
                    barThickness: 25,
                    data: [<?php print_r($late_attendance_data);?>],
                    backgroundColor: [
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56',
                        '#4BC0C0',
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56',
                    ],
                    borderColor: [
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56',
                        '#4BC0C0',
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                //cutoutPercentage: 40,
                responsive: false,
            }
        });

    })
</script>