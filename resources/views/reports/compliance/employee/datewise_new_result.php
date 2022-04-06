<?php
$exportable_data = [];
if ($employee_info):
    $header = ['Emp Code', 'Name', 'Department', 'Designation', 'Section', 'Grade', 'DOB', 'DOJ'];
    $exportable_data[] = $header;
    ?>
    <div class="container">
        <div class="row mt-1">
            <div class="col-sm-12">
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
                    </thead>
                    <tbody>
                        <?php foreach($employee_info as $key => $row):
                            $EmployeeCode = $row['EmployeeCode'];
                            $EmployeeName = $row['EmployeeName'];
                            $Department = $row['Department'];
                            $Designation = $row['Designation'];
                            $Section = $row['Section'];
                            $GradeInfoID = $row['GradeInfoID'];
                            $DOB = date_conversion('d-M-Y', $row['DOB']);
                            $DOJ = date_conversion('d-M-Y', $row['DOJ']);

                            $exportable_data[] = [
                                $EmployeeCode,
                                $EmployeeName,
                                $Department,
                                $Designation,
                                $Section,
                                $GradeInfoID,
                                $DOB,
                                $DOJ
                            ];
                            ?>
                            <tr>
                                <td><?php echo $EmployeeCode; ?></td>
                                <td><?php echo $EmployeeName; ?></td>
                                <td><?php echo $Department; ?></td>
                                <td><?php echo $Designation; ?></td>
                                <td><?php echo $Section; ?></td>
                                <td><?php echo $GradeInfoID; ?></td>
                                <td><?php echo $DOB; ?></td>
                                <td><?php echo $DOJ; ?></td>
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

    session("export_data", "");
    session("export_data", json_encode($exportable_data));
?>
<script>
    dataTablePlaceHolder();
</script>
