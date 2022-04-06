<?php if ($employee_info):?>
    <div class="printable">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 col-xl-12 page-heading">
                    <div class="row page-header">
                        <div class="col-sm-4 col-xl-5">
                            <?php echo view('includes/company_logo',compact('company_info'),false); ?>
                        </div>
                        <div class="col-sm-8 col-xl-7">
                            <h4><?php echo $company_info->name?></h4>
                            <p><?php echo $company_info->address?></p>
                            <p class="font-weight-bold"><?php echo $title?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <?php foreach ($employee_info as $row):
                    $work_dates = explode(',', $row['WorkDate']);
                    $ShiftOutTime = explode(',', $row['ShiftOutTime']);
                    $late_hours = explode(',',$row['LateHour']);
                    $in_times = explode(',', $row['InTime']);
                    $out_times = explode(',', $row['OutTime']);
                    $remarks = explode(',', $row['Remarks']);
                    $all_status = explode(',',$row['DayStatus']);
                    $total_data = count($work_dates);

                    $grand_total_ot_hour = 0;
                    $total_present = 0;
                    $total_absent = 0;
                    $total_leave = 0;
                    $total_late = 0;
                    $total_weekend = 0;
                    $total_holiday = 0;
                    $month = date_conversion('M-y',$to_date);
                    $number_of_day_in_this_month = date('t',strtotime($to_date));

                    $table =
                        '<table class="table table-bordered table-sm dataTable" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Status</th>
                                <th>In Time</th>
                                <th>Out Time</th>
                                <th>Late Hour</th>
                                <th>OT Hour</th>
                                <th>EOT Hour</th>
                                <th>Total Hour</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>';
                    for ( $day = 0; $day < $total_data; $day++  ) {
                        $day_status = $all_status[$day] ?? null;
                        $work_date = date_conversion('d-M-Y', $work_dates[$day] ?? null);
                        $in_time = date_conversion('h:i a', $in_times[$day] ?? null);
                        $out_time = date_conversion('h:i a', $out_times[$day] ?? null);
                        $remark = $remarks[$day] ?? null;
                        $shift_out_time = date_conversion('h:i a', $ShiftOutTime[$day] ?? null);
                        $late_hour = $late_hours[$day];

                        $total_ot_hour = 0;
                        $slab1 = null;
                        $slab2 = null;
                        if (check_ot_ability($row['OTEntitledDate'], $work_dates[$day])) {
                            if (!is_null($out_time)) {
                                $ot_time = calculate_ot_time($out_time,$shift_out_time);
                                if ($ot_time !=0 ) {
                                    $total_ot_hour = calculate_total_ot($day_status, $ot_time, 0.50, 1.00);

                                    $slab = calculate_slab($total_ot_hour);
                                    if (!empty($slab)) {
                                        $slab1 = $slab[0];
                                        $slab2 = $slab[1];
                                    }
                                }
                            }
                        }

                        $table .= '           
                                    <tr>
                                        <td>'.$work_date.'</td>
                                        <td>'.$day_status.'</td>
                                        <td>'.$in_time.'</td>
                                        <td>'.$out_time.'</td>
                                        <td>'.$late_hour.'</td>
                                        <td>'.$slab1.'</td>
                                        <td>'.$slab2.'</td>
                                        <td>'.($slab1+$slab2).'</td>
                                        <td>'.$remark.'</td>
                                    </tr>';
                        if ($day_status == 'A'){
                            $total_absent++;
                        }
                        elseif ($day_status == 'L'){
                            $total_late++;
                        }
                        elseif ($day_status == 'LV'){
                            $total_leave++;
                        }
                        elseif ($day_status == 'W'){
                            $total_weekend++;
                        }
                        elseif ($day_status == 'H'){
                            $total_holiday++;
                        }
                        else
                            $total_present++;

                        $grand_total_ot_hour += $slab1+$slab2;
                    }
                    $table .= '</tbody>
                    </table>';

                    ?>
                    <div class="col-sm-12">
                        <div class="row">
                            <table class="table table-bordered table-sm">
                                <tbody>
                                <tr>
                                    <td class="font-weight-bold">Employee Code</td>
                                    <td><?php echo $row['EmployeeCode'];?></td>
                                    <td class="font-weight-bold">DOJ</td>
                                    <td><?php echo date_conversion('d-M-Y',$row['DOJ']);?></td>
                                    <td class="font-weight-bold">Present Days</td>
                                    <td><?php echo $total_present;?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Name</td>
                                    <td><?php echo $row['EmployeeName'];?></td>
                                    <td class="font-weight-bold">Month</td>
                                    <td><?php echo $month;?></td>
                                    <td class="font-weight-bold">Absent</td>
                                    <td><?php echo $total_absent;?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Designation</td>
                                    <td><?php echo $row['Designation'];?></td>
                                    <td class="font-weight-bold">Month Days</td>
                                    <td><?php echo $number_of_day_in_this_month;?></td>
                                    <td class="font-weight-bold">Leave</td>
                                    <td><?php echo $total_leave;?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Department</td>
                                    <td><?php echo $row['Department'];?></td>
                                    <td class="font-weight-bold">Holiday</td>
                                    <td><?php echo $total_holiday;?></td>
                                    <td class="font-weight-bold">Late</td>
                                    <td><?php echo $total_late;?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Section</td>
                                    <td><?php echo $row['Section'];?></td>
                                    <td class="font-weight-bold">Weekly Holiday</td>
                                    <td><?php echo $total_weekend;?></td>
                                    <td class="font-weight-bold">Overtime(Hrs)</td>
                                    <td><?php echo $grand_total_ot_hour;?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-12 mb-4">
                        <div class="row">
                            <?php echo $table;?>
                        </div>
                    </div>
                <?php endforeach?>
            </div>
        </div>
    </div>
<?php else:
    echo "<h5 class='text text-danger'>There is no data according to your search.</h5>";
endif;
?>