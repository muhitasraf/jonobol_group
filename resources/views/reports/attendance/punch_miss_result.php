<?php if ($employee_info):?>
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
                        <tr>
                            <th>Date</th>
                            <th>EmployeeCode</th>
                            <th>Employee Name</th>
                            <th>Designation</th>
                            <th>Department</th>
                            <th>Section</th>
                            <th>Shift In Time</th>
                            <th>Shift Out Time</th>
                            <th>In Time</th>
                            <th>Out Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($employee_info as $key => $row):?>
                            <tr>
                                <td><?php echo date_conversion('d-m-Y',$row['WorkDate']); ?></td>
                                <td><?php echo $row['EmployeeCode']; ?></td>
                                <td><?php echo $row['EmployeeName']; ?></td>
                                <td><?php echo $row['Designation']; ?></td>
                                <td><?php echo $row['Department']; ?></td>
                                <td><?php echo $row['Section']; ?></td>
                                <td><?php echo date_conversion('h:i A',$row['ShiftInTime']); ?></td>
                                <td><?php echo date_conversion( 'h:i A',$row['ShiftOutTime']); ?></td>
                                <td><?php echo date_conversion('h:i A',$row['PunchIN']); ?></td>
                                <td><?php echo date_conversion('h:i A',$row['PunchOUT']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
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
            max-width: 14% !important;
        }
        /*.page-header {*/
        /*    margin-left: 15% !important;*/
        /*}*/
        /*@media print {*/
        /*    body {*/
        /*        !*zoom:100%; !*or whatever percentage you need, play around with this number *!*/
        /*        width: auto !important;*/
        /*        margin: 0 5px 0 0 !important;*/
        /*        font-size: 8px !important;*/
        /*        !*height: auto !important;*!*/
        /*    }*/
        /*    .page-header {*/
        /*        margin-left: 25% !important;*/
        /*    }*/
        /*}*/
    </style>

<?php else:
    echo "<h5 class='text text-danger'>There is no data according to your search.</h5>";
endif;
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