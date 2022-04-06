<?php
$exportable_data = [];
if ($employee_info):
    $header = [
        'Date', 'Employee Code', 'Employee Name', 'Department', 'Designation', 'Section', 'Shift In Time',
        'Shift Out Time', 'In Time', 'Out Time'
    ];
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
                <table class="table table-bordered dataTable">
                    <thead>
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
                    </thead>
                    <tbody>
                        <?php foreach($employee_info as $key => $row):
                            $EmployeeCode = $row['EmployeeCode'];
                            $EmployeeName = $row['EmployeeName'];
                            $Department = $row['Department'];
                            $Designation = $row['Designation'];
                            $Section = $row['Section'];
                            $WorkDate = date_conversion('d-m-Y',$row['WorkDate']);
                            $ShiftInTime = date_conversion('h:i A',$row['ShiftInTime']);
                            $ShiftOutTime = date_conversion('h:i A',$row['ShiftOutTime']);

                            $exportable_data[] = [
                                $WorkDate,
                                $EmployeeCode,
                                $EmployeeName,
                                $Department,
                                $Designation,
                                $Section,
                                $ShiftInTime,
                                $ShiftOutTime
                            ];
                            ?>
                            <tr>
                                <td><?php echo $WorkDate; ?></td>
                                <td><?php echo $EmployeeCode; ?></td>
                                <td><?php echo $EmployeeName; ?></td>
                                <td><?php echo $Designation; ?></td>
                                <td><?php echo $Department; ?></td>
                                <td><?php echo $Section; ?></td>
                                <td><?php echo $ShiftInTime; ?></td>
                                <td><?php echo $ShiftOutTime; ?></td>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php else:
    echo "<h5 class='text text-danger'>There is no data according to your search.</h5>";
endif;

session("export_data", "");
session("export_data", json_encode($exportable_data));
?>
<script>
    dataTablePlaceHolder();
</script>