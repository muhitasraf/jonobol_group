<?php
$exportable_data = [];
if ($employee_info):
    $exportable_data[] = $header;
    ?>
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <?php echo view('includes/company_logo',compact('company_info'),false); ?>
            </div>
            <div class="col-sm-8">
                <h4><?php echo $company_info->name?></h4>
                <p><?php echo $company_info->address?></p>
                <p class="font-weight-bold"><?php echo $title?></p>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-sm-10x">
                <table class="table table-bordered table-sm">
                    <thead>
                    <tr>
                        <?php foreach ($header as $head) {
                            echo "<td>".$head."</td>";
                        }?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($employee_info as $index => $employee) {
                        echo "<tr>";
                        echo "<td>".$employee['EmployeeCode']."</td>";
                        echo "<td>".$employee['EmployeeName']."</td>";
                        $work_dates = explode(',',$employee['WorkDate']);
                        $all_status = explode(',',$employee['DayStatus']);
                        $ShiftOutTime = explode(',',$employee['ShiftOutTime']);
                        $total_data = count($work_dates);
                        $total_head = count($header)-2;

                        $in_times = explode(',',$employee['InTime']);
                        $out_times = explode(',',$employee['OutTime']);

                        $exportable_data[$index+1][] = $employee['EmployeeCode'];
                        $exportable_data[$index+1][] = $employee['EmployeeName'];

                        /*if ($employee['EmployeeCode'] == 'GL-000489'){
                            myLog('header: '.$employee['EmployeeCode'].'->'.json_encode($header));
                            myLog('work_dates: '.json_encode($work_dates));
                            myLog('day_status: '.json_encode($all_status));
                            myLog('in_times: '.json_encode($in_times));
                            myLog('out_times: '.json_encode($out_times));
                        }*/
                        $day_status_index = 0;
                        $weekend_index = 0;
                        for ($day = 0; $day < $total_head; $day++  ) {
                            $day_status = $all_status[$day] ?? null;
                            $in_time = date_conversion('h:i a',$in_times[$day_status_index] ?? null);
                            $out_time = date_conversion('h:i a',$out_times[$day_status_index] ?? null);
                            $shift_out_time = date_conversion('h:i a',$ShiftOutTime[$day_status_index] ?? null);

                            $ot_time = 0;
                            if (isset($out_time)) {
                                $ot_time = calculate_ot($out_time, $shift_out_time);
                            }
                            $total_ot_hour = make_round($ot_time, 0.75, 1.00);
//                                    if ($employee['EmployeeCode'] == 'GL-000003') {
//                                        myLog("WorkDate: $work_date, InTime: $in_time, OutTime: $out_time, shift_out_time:$shift_out_time, ottime:$ot_time, total_ot_hour:$total_ot_hour");
//                                    }
                            $status_with_time = $day_status.',  ('.$in_time.' - '.$out_time.'),  '.$total_ot_hour;
                            echo "<td>$day_status<hr/>$in_time<hr/>$out_time<hr/>$total_ot_hour</b></td>";
                            $exportable_data[$index+1][$day+2] = $status_with_time;
                        }
                        echo "</tr>";
                    }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php
else:
    echo "<h5 class='text text-danger'>There is no data according to your search.</h5>";
endif;

session("export_data", "");
session("export_data", json_encode($exportable_data));
?>

<style>
    body {
        width: max-content !important;
    }
    .col-sm-3{
        -ms-flex: 0 0 25%;
        flex: 0 0 25%;
        max-width: 20%;
    }
    @media print {
        @page {
            size: legal !important;
        }
    }
</style>
