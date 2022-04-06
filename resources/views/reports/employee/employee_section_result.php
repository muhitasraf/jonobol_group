<?php
$exportable_data = [];
if ($section_info):
    $header = ['Employee ID','Employee Code', 'Employee Name', 'Badge Number','Date of Join', 'Mobile', 'Section Name'];
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
                            <!--th><?php //echo $header[16]; ?></th-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=0; foreach($section_info as $key => $row):
                            $EmployeeID = $row['id'];
                            $EmployeeCode = $row['EmployeeCode'];
                            $EmployeeName = $row['EmployeeName'];
                            $FromDate = $row['BadgeNumber'];
                            $ToDate = $row['DOJ'];
                            $LeaveDays = $row['Mobile'];
                            $LeaveType = $row['SectionName'];                            
                            $exportable_data[] = [
                                $EmployeeID,$EmployeeCode,$EmployeeName,$FromDate,$ToDate,$LeaveDays,$LeaveType,
                            ];
                            ?>
                            <tr>
                                <td><?php echo ++$i; ?></td>
                                <td><?php echo $row ['id']; ?></td>                                                               
                                <td><?php echo $row ['EmployeeCode']; ?></td>                                                               
                                <td><?php echo $row ['EmployeeName']; ?></td>                                                               
                                <td><?php echo $row ['BadgeNumber']; ?></td>                                                               
                                <td><?php echo $row ['DOJ']; ?></td>                                                               
                                <td><?php echo $row ['Mobile']; ?></td>                                                               
                                <td><?php echo $row['SectionName']; ?></td>
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
