<?php
$exportable_data = [];
if ($employee_info):
    $header = [
        'No.', 'Employee Code', 'Name', 'Department', 'Designation', 'Section', 'Leave Type',
        'From Date', 'To Date', 'Total Days'
    ];
    $exportable_data[] = $header;
    ?>
    <div class="container">
        <div class="row page-heading">
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
                <table class="table table-bordered table-sm dataTable" cellspacing="0" width="100%">
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
                        <?php
                        //myLog(json_encode($employee_info));
                        foreach($employee_info as $key => $row):
                            $no = $key+1;
                            $EmployeeCode = $row['EmployeeCode'];
                            $EmployeeName = $row['EmployeeName'];
                            $designation = $row['Designation'];
                            $department = $row['Department'];
                            $Section = $row['Section'];
                            $LeaveType = $row['LeaveType'];
                            $FromDate = date_conversion('d-m-Y',$row['FromDate']);
                            $ToDate = date_conversion('d-m-Y',$row['ToDate']);
                            $LeaveDays = $row['LeaveDays'];

                            $exportable_data[] = [
                                $no,
                                $EmployeeCode,
                                $EmployeeName,
                                $department,
                                $designation,
                                $Section,
                                $LeaveType,
                                $FromDate,
                                $ToDate,
                                $LeaveDays
                            ];
                            ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $EmployeeCode; ?></td>
                                <td><?php echo $EmployeeName; ?></td>
                                <td><?php echo $department; ?></td>
                                <td><?php echo $designation; ?></td>
                                <td><?php echo $Section; ?></td>
                                <td><?php echo $LeaveType; ?></td>
                                <td><?php echo $FromDate; ?></td>
                                <td><?php echo $ToDate; ?></td>
                                <td><?php echo $LeaveDays; ?></td>
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