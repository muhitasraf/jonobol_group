<?php
$exportable_data = [];
if ($employee_info):
    $header = ['Emp Code','BadgeNumber', 'Name', 'StaffCategory','DOB', 'Department', 'Designation', 'Section', 'Salary', 'DOJ', 'Mobile', 'Gender', 'NationalID', 'ShiftID','LeaveRule', 'OT','HolydayBonus', 'Permanent Address','Present Address','Father Name','Mother Name'];
    $exportable_data[] = $header;//'Grade',
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
            <div class="col-sm-12 mt-1">
                <table class="table table-bordered dataTable FixedHeader">
                    <thead>
                        <tr class="table-success">
                            <th>S.L</th>
                            <th><?php echo $header[0]; ?></th>
                            <th><?php echo $header[1]; ?></th>
                            <th><?php echo $header[2]; ?></th>
                            <th><?php echo $header[3]; ?></th>
                            <th><?php echo $header[4]; ?></th>
                            <th><?php echo $header[5]; ?></th>
                            <th><?php echo $header[6]; ?></th>
                            <th><?php echo $header[7]; ?></th>
                            <th><?php echo $header[8]; ?></th>
                            <th><?php echo $header[9]; ?></th>
                            <th><?php echo $header[10]; ?></th>
                            <th><?php echo $header[11]; ?></th>
                            <th><?php echo $header[12]; ?></th>
                            <th><?php echo $header[13]; ?></th>
                            <th><?php echo $header[14]; ?></th>
                            <th><?php echo $header[15]; ?></th>
                            <th><?php echo $header[16]; ?></th>
                            <!--th><?php //echo $header[16]; ?></th-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=0; foreach($employee_info as $key => $row):
                            $EmployeeCode = $row['EmployeeCode'];
                            $BadgeNumber = $row['BadgeNumber'];
                            $EmployeeName = $row['EmployeeName'];
                            $DOB = date_conversion('d-M-Y', $row['DOB']);
                            $Department = $row['Department'];
                            $Designation = $row['Designation'];
                            $Section = $row['Section'];
                            $EntrySalary = $row['EntrySalary'];
                            $GradeInfoID = $row['GradeInfoID'];
                            $DOJ = date_conversion('d-M-Y', $row['DOJ']);
                            $Mobile = $row['Mobile'];
                            $Gender = $row['Gender'];
                            $NationalIDCardNo = $row['NationalIDCardNo'];
                            $ShiftID = $row['ShiftID'];
                            $OT = $row['OT'];
                            $HolydayBonus = $row['HolydayBonus'];
                            $Address = $row['Address'];
                            $local_address = $row['local_address'];
                            $father_name = $row['father_name'];
                            $mother_name = $row['mother_name'];
                            $LeaveRuleID = $row['LeaveRuleID'];
                            $exportable_data[] = [
                                $EmployeeCode,$BadgeNumber,$EmployeeName,$Department,$Designation,$Section,$EntrySalary,$GradeInfoID,$DOB,$DOJ,$Mobile,$Gender,$NationalIDCardNo,$ShiftID,$OT,$HolydayBonus,$Address,$local_address,$father_name,$mother_name,
                            ];
                            $gend  = array('1'=>'Male','2'=>'FeMale');
                            $bonus  = array('1'=>'Yes','0'=>'No','2'=>'No');
                            ?>
                            <tr>
                                <td><?php echo ++$i; ?></td>
                                <td><?php echo $EmployeeCode; ?></td>
                                <td><?php echo $BadgeNumber; ?></td>
                                <td><?php echo $EmployeeName; ?></td>
                                <td><?php if($row['StaffCategoryID']==5){echo 'Worker';}if($row['StaffCategoryID']==8){echo 'Staff';} ?></td>
                                <td><?php echo $DOB; ?></td>
                                <td><?php echo $Department; ?></td>
                                <td><?php echo $Designation; ?></td>
                                <td><?php echo $Section; ?></td>
                                <td><?php echo round($EntrySalary,2); ?></td>
                                <!--td><?php echo $GradeInfoID; ?></td-->
                                <td><?php echo $DOJ; ?></td>
                                <td><?php echo $Mobile; ?></td>
                                <td><?php echo $gend[$Gender]; ?></td>
                                <td><?php echo $NationalIDCardNo; ?></td>
                                <td><?php echo $ShiftID; ?></td>
                                <td><?php echo $LeaveRuleID; ?></td>
                                <td><?php echo $bonus[$OT]; ?></td>
                                <td><?php echo $bonus[$HolydayBonus]; ?></td>
                                <!--td><?php echo $Address; ?></td>
                                <td><?php echo $local_address; ?></td>
                                <td><?php echo $father_name; ?></td>
                                <td><?php echo $mother_name; ?></td-->
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="ml-2">
                <p>Total : <?php echo $key+1?></p>
            </div>
        </div>
    </div>
<?php else:
        echo "<h5 class='text text-danger'>There is no data according to your search.</h5>";
    endif;
    // cookie('export_data',"",-60);
    // unset($_COOKIE['export_data']);
    // cookie("export_data", json_encode($exportable_data));
    // myLog("export_data as data:");
    // myLog(json_encode($exportable_data));
    // $export_data = cookie('export_data');
    // myLog("export_data read form cookie:");
    // myLog($export_data);

    //session("export_data", "");
    //session("export_data", json_encode($exportable_data));
?>

<script>
    $(function() {
        let pageHeader = $('.page-heading').html();
        // Append a caption to the table before the DataTables initialisation
        //$('.dataTable').append('<caption style="caption-side: bottom">Printed at 15.20pm.</caption>');

        $('.dataTable').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    messageTop: 'Employee List'
                },
                /*{
                    extend: 'pdf',
                    messageTop: 'Employee List'
                },*/
                {
                    extend: 'print',
                    messageTop: pageHeader,
                    title: ''
                },
            ],
            paging: false,
            bInfo: false
        });
    });
</script>
