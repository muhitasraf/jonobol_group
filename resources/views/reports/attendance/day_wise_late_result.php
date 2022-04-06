<?php
$exportable_data = [];
if ($employee_info):
    $header = [
        'Date', 'Employee Code', 'Employee Name', 'Department', 'Designation', 'Section', 'Shift In Time',
        'Shift Out Time', 'In Time'
    ];
    $exportable_data[] = $header;?>
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
                <table class="table table-bordered table-sm dataTable" cellspacing="0" width="100%">
                    <thead>
                        <th>No.</th>
                        <th><?php echo $header[0]; ?></th>
                        <th><?php echo $header[1]; ?></th>
                        <th><?php echo $header[2]; ?></th>
                        <th><?php echo $header[3]; ?></th>
                        <th><?php echo $header[4]; ?></th>
                        <th><?php echo $header[5]; ?></th>
                        <th><?php echo $header[6]; ?></th>
                        <th><?php echo $header[7]; ?></th>
                        <th><?php echo $header[8]; ?></th>
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
                            $PTime = date_conversion('h:i A',$row['PunchIN']);

                            $exportable_data[] = [
                                $WorkDate,
                                $EmployeeCode,
                                $EmployeeName,
                                $Department,
                                $Designation,
                                $Section,
                                $ShiftInTime,
                                $ShiftOutTime,
                                $PTime
                            ];
                        ?>
                            <tr>
                                <td><?php echo $key+1; ?></td>
                                <td><?php echo $WorkDate; ?></td>
                                <td><?php echo $EmployeeCode; ?></td>
                                <td><?php echo $EmployeeName; ?></td>
                                <td><?php echo $Designation; ?></td>
                                <td><?php echo $Department; ?></td>
                                <td><?php echo $Section; ?></td>
                                <td><?php echo $ShiftInTime; ?></td>
                                <td><?php echo $ShiftOutTime; ?></td>
                                <td><?php echo $PTime; ?></td>
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