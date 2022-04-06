<?php
$exportable_data = [];
if ($employee_info):
    $head_array[] = 'No.';
    if($cb_code)
        $head_array[] = 'Code';
    if($cb_name)
        $head_array[] = 'Name';
    if($cb_doj)
        $head_array[] = 'DOJ';
    if($cb_designation)
        $head_array[] = 'Designation';
    if($cb_section)
        $head_array[] = 'Section';
    if($cb_department)
        $head_array[] = 'Department';
    if($cb_staffcat)
        $head_array[] = 'Staff Category';

    $header = [
        'Gross', 'Basic', 'House Rent', 'Medical & Allowance', 'Days in month', 'Weekly off', 'Present Day', 'Leave',
        'Absent Day', 'Payable Day', 'Deduction', 'Attendance Bonus', 'Payable Salary','Overtime', 'Stamp', 'Total Payable',
        'Signature and Stamp'
    ];
    $header = array_merge($head_array,$header);
    $exportable_data[] = $header;
    ?>
    <div class="container-fluid">
        <div class="row page-heading">
            <div class="col-sm-12 col-xl-12">
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
        <div class="row mt-1">
            <div class="col-sm-12">
                    <?php
                        $section_name_old = null;
                        foreach($employee_info as $key => $row):
                            $section_name = $row['Section'];
                            if ($section_name != $section_name_old) {
                                $section_name_old = $section_name;
                                if ( $key != 0 ) {?>
                                                </tbody>
                                            </table>
                                <?php } ?>
                                <div class="mt-2 row">
                                    <div class="col-sm-6 float-left">
                                        <table class="table-borderless">
                                            <tbody>
                                            <tr>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Department: <?php echo $row['Department'];?></td>
                                            </tr>
                                            <tr>
                                                <td>Section: <?php echo $row['Section'];?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <table class="table table-bordered table-sm dataTable" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <?php if($cb_code):?>
                                                <th>Code</th>
                                            <?php endif;?>
                                            <?php if($cb_name):?>
                                                <th>Name</th>
                                            <?php endif;?>
                                            <?php if($cb_doj):?>
                                                <th>DOJ</th>
                                            <?php endif;?>
                                            <?php if($cb_designation):?>
                                                <th>Designation</th>
                                            <?php endif;?>
                                            <?php if($cb_section):?>
                                                <th>Section</th>
                                            <?php endif;?>
                                            <?php if($cb_department):?>
                                                <th>Department</th>
                                            <?php endif;?>
                                            <?php if($cb_staffcat):?>
                                                <th>Staff Category</th>
                                            <?php endif;?>
                                            <th>Gross</th>
                                            <th>Basic</th>
                                            <th>House Rent</th>
                                            <th>Medical & Allowance</th>
                                            <th>Days in month</th>
                                            <th>Weekly off</th>
                                            <th>Present Day</th>
                                            <th colspan="4" class="text-center">Leave</th>
                                            <th>Absent Day</th>
                                            <th>Payable Day</th>
                                            <th colspan="4" class="text-center">Deduction</th>
                                            <th>Attendance Bonus</th>
                                            <th>Payable Salary</th>
                                            <th colspan="3" class="text-center">Overtime</th>
                                            <th>Stamp</th>
                                            <th>Total Payable</th>
                                            <th>Signature and Stamp</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <?php if($cb_code):?>
                                                <td></td>
                                            <?php endif;?>
                                            <?php if($cb_name):?>
                                                <td></td>
                                            <?php endif;?>
                                            <?php if($cb_doj):?>
                                                <td></td>
                                            <?php endif;?>
                                            <?php if($cb_designation):?>
                                                <td></td>
                                            <?php endif;?>
                                            <?php if($cb_section):?>
                                                <td></td>
                                            <?php endif;?>
                                            <?php if($cb_department):?>
                                                <td></td>
                                            <?php endif;?>
                                            <?php if($cb_staffcat):?>
                                                <td></td>
                                            <?php endif;?>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>CL</td>
                                            <td>SL</td>
                                            <td>EL</td>
                                            <td>SPL</td>
                                            <td></td>
                                            <td></td>
                                            <td>Absent</td>
                                            <td>P.F</td>
                                            <td>Advance</td>
                                            <td>Total Deduction</td>
                                            <td></td>
                                            <td></td>
                                            <td>OT Rate</td>
                                            <td>Total OT Hour</td>
                                            <td>Total OT Payment</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                            <?php } ?>
                                        <?php
                                        $no = $key+1;
                                        $EmployeeCode = $row['EmployeeCode'];
                                        $EmployeeName = $row['EmployeeName'];
                                        $DOJ = date_conversion('d-m-Y',$row['DOJ']);
                                        $designation = $row['Designation'];
                                        $department = $row['Department'];
                                        $Section = $row['Section'];
                                        $staff_category = $row['StaffCategory'];
                                        $gross = ($row['orgGROSS']);
                                        $BASIC = ($row['orgBASIC']);
                                        $HOUSERENT = ($row['orgHOUSERENT']);
                                        $MEDICAL = ($row['orgMEDICAL']);
                                        $DaysInMonth = date_conversion('d',$row['ToDate']);
                                        $WeeklyOffDay = $row['WeeklyOffDay'];
                                        $absenteeism = ($row['Absenteeism']);
                                        $pf = ($row['PF']);
                                        $advance = ($row['ADVANCE']);
                                        $deduction = ($absenteeism+$pf+$advance);
                                        $attendanceBonus =  ($row['ATTENDANCEBONUS']);
                                        $payable = ($gross-$deduction)+$attendanceBonus;//+$conveyance
                                        $OTAmount = $row['OT'];
                                        $OTHour = CEIL($row['OTHour']);
                                        $OTRate = $row['OTRate'];
                                        $stamp =  $row['STAMP'];
                                        $totalPayable = $payable+$OTAmount-$stamp;
                                        $absent_day = $row['AbsentDay'];

                                        $leave_type = explode(',',$row['LeaveType']);
                                        $leave_days = explode(',',$row['LeaveDays']);
                                        $leave_data = array_combine($leave_type,$leave_days);

                                        $cl = $leave_data['CL'] ?? 0;
                                        $sl = $leave_data['SL'] ?? 0;
                                        $el = $leave_data['EL'] ?? 0;
                                        $spl = $leave_data['SPL'] ?? 0;
                                        $total_leave = $cl + $sl + $el + $spl;
                                        $present_day = $DaysInMonth - $total_leave - $absent_day;
                                        $payable_day  = $DaysInMonth - $absent_day;

                                        $data_array[] = $no;
                                        if($cb_code)
                                            $data_array[] = $EmployeeCode;
                                        if($cb_name)
                                            $data_array[] = $EmployeeName;
                                        if($cb_doj)
                                            $data_array[] = $DOJ;
                                        if($cb_designation)
                                            $data_array[] = $designation;
                                        if($cb_section)
                                            $data_array[] = $Section;
                                        if($cb_department)
                                            $data_array[] = $department;
                                        if($cb_staffcat)
                                            $data_array[] = $staff_category;

                                        $exportable_data[] = array_merge($data_array,
                                            [
                                                $gross,
                                                $BASIC,
                                                $HOUSERENT,
                                                $MEDICAL,
                                                $DaysInMonth,
                                                $WeeklyOffDay,
                                                $present_day,
                                                $total_leave,
                                                $absent_day,
                                                $payable_day,
                                                //$pf,
                                                //$advance,
                                                $deduction,
                                                $attendanceBonus,
                                                $payable,
                                                $OTAmount,
                                                $stamp,
                                                $totalPayable
                                            ]
                                        );
                                        unset($data_array);
                                        ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <?php if($cb_code):?>
                                                <td><?php echo $EmployeeCode; ?></td>
                                            <?php endif;?>
                                            <?php if($cb_name):?>
                                                <td><?php echo $EmployeeName; ?></td>
                                            <?php endif;?>
                                            <?php if($cb_doj):?>
                                                <td><?php echo $DOJ; ?></td>
                                            <?php endif;?>
                                            <?php if($cb_designation):?>
                                                <td><?php echo $designation; ?></td>
                                            <?php endif;?>
                                            <?php if($cb_section):?>
                                                <td><?php echo $Section; ?></td>
                                            <?php endif;?>
                                            <?php if($cb_department):?>
                                                <td><?php echo $department; ?></td>
                                            <?php endif;?>
                                            <?php if($cb_staffcat):?>
                                                <td><?php echo $staff_category; ?></td>
                                            <?php endif;?>

                                            <td><?php echo $gross;?></td>
                                            <td><?php echo $BASIC;?></td>
                                            <td><?php echo $HOUSERENT;?></td>
                                            <td><?php echo $MEDICAL;?></td>
                                            <td><?php echo $DaysInMonth;?></td>
                                            <td><?php echo $WeeklyOffDay;?></td>
                                            <td><?php echo $present_day;?></td>
                                            <td><?php echo $cl;?></td>
                                            <td><?php echo $sl;?></td>
                                            <td><?php echo $el;?></td>
                                            <td><?php echo $spl;?></td>
                                            <td><?php echo $absent_day;?></td>
                                            <td><?php echo $payable_day;?></td>
                                            <td><?php echo $absenteeism; ?></td>
                                            <td><?php echo $pf;?></td>
                                            <td><?php echo $advance;?></td>
                                            <td><?php echo $deduction;?></td>
                                            <td><?php echo $attendanceBonus;?></td>
                                            <td><?php echo $payable;?></td>
                                            <td><?php echo $OTRate;?></td>
                                            <td><?php echo $OTHour;?></td>
                                            <td><?php echo $OTAmount;?></td>
                                            <td><?php echo $stamp;?></td>
                                            <td><?php echo $totalPayable;?></td>
                                            <td><?php ;?></td>
                                        </tr>
                        <?php  endforeach; ?>
                </table>
            </div>
        </div>
    </div>

    <style>
        body {
            width: max-content !important;
        }
        .col-sm-3 {
            -ms-flex: 0 0 25%;
            flex: 0 0 25%;
            max-width: 10% !important;
        }
        /*.page-header {
            margin-left: 10% !important;
        }*/
        @media print {
            body {
                /*zoom:100%; /*or whatever percentage you need, play around with this number */
                width: auto !important;
                margin: 0 5px 0 0 !important;
                font-size: 8px !important;
                /*height: auto !important;*/
            }
            .page-header {
                margin-left: 30% !important;
            }
            table.table-borderless tr,table.table-borderless td {
                border: none;
                margin: auto;
            }
            table {page-break-after:always}
        }
    </style>

    <script>
        $(function() {
            let pageHeader = $('.page-heading').html();
            // Append a caption to the table before the DataTables initialisation
            //$('.dataTable').append('<caption style="caption-side: bottom">Printed at 15.20pm.</caption>');

            $('.dataTable').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'csv',
                        messageTop: 'Monthly Salary',
                    },
                    {
                        extend: 'excel',
                        messageTop: RemoveHTMLTags(pageHeader),
                    },
                    /*{
                        extend: 'pdf',
                        messageTop: 'Monthly Salary',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                    },*/
                    {
                        extend: 'print',
                        messageTop: pageHeader,
                        action: function ( e, dt, node, config ) {
                            printLandscape();
                            window.print();
                        }
                    },
                ],
                paging: false,
                bInfo: false
            });
        });
    </script>
<?php else:
    echo "<h5 class='text text-danger'>There is no data according to your search.</h5>";
endif;

//session("export_data", "");
//session("export_data", json_encode($exportable_data));
?>
