<?php if ($employee_info):?>
    <div class="container-fluid leave-summary-sheet">
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
                        <th>No.</th>
                        <th>Department</th>
                        <th>Designation</th>
                        <th>Section</th>
                        <th>Employee Code</th>
                        <th>Employee Name</th>
                        <th>DOJ</th>
                        <th>Service Length</th>
                        <th colspan="5">Leave Allocated</th>
                        <th colspan="5">Leave Availed</th>
                        <th colspan="5">Leave Balance</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>CL</td>
                            <td>SL</td>
                            <td>SPL</td>
                            <td>LWP</td>
                            <td>EL</td>
                            <td>CL</td>
                            <td>SL</td>
                            <td>SPL</td>
                            <td>LWP</td>
                            <td>EL</td>
                            <td>CL</td>
                            <td>SL</td>
                            <td>SPL</td>
                            <td>LWP</td>
                            <td>EL</td>
                        </tr>
                        <?php foreach($employee_info as $key => $row):?>
                            <tr>
                                <td><?php echo $key+1; ?></td>
                                <td><?php echo $row['Department']; ?></td>
                                <td><?php echo $row['Designation']; ?></td>
                                <td><?php echo $row['Section']; ?></td>
                                <td><?php echo $row['EmployeeCode']; ?></td>
                                <td><?php echo $row['EmployeeName']; ?></td>
                                <td><?php echo date_conversion('d-m-Y',$row['DOJ']); ?></td>
                                <td><?php
                                        $doj = date_create($row['DOJ']);
                                        $current_date = date_create(date('Y-m-d'));
                                        $service_length = date_diff($doj, $current_date);
                                        echo $service_length->format('%y Year, %m Month, %d Days');

                                        $leave_types = $row['LeaveType'];
                                        $leave_types = explode(',',$leave_types);
                                        //print_r($leave_types);

                                        $allocated_days = $row['allocatedDays'];
                                        $allocated_days = explode(',',$allocated_days);
                                        //print_r($allocated_days);

                                        $availed_days = $row['availedDays'];
                                        $availed_days = explode(',',$availed_days);
                                        //print_r($availed_days);

                                        $allocated_days = array_combine($leave_types, $allocated_days);
                                        //print_r($allocated_days);

                                        $availed_days = array_combine($leave_types, $availed_days);
                                        //print_r($allocated_days);
                                    ?>
                                </td>
                                <td><?php echo $allocated_cl = $allocated_days['CL'] ?? 0 ;?></td>
                                <td><?php echo $allocated_sl = $allocated_days['SL'] ?? 0;?></td>
                                <td><?php echo $allocated_spl = $allocated_days['SPL'] ?? 0;?></td>
                                <td><?php echo $allocated_lwp = $allocated_days['LWP'] ?? 0;?></td>
                                <td><?php echo $allocated_el = $allocated_days['EL'] ?? 0;?></td>

                                <td><?php echo $availed_cl = $availed_days['CL'] ?? 0 ;?></td>
                                <td><?php echo $availed_sl = $availed_days['SL'] ?? 0;?></td>
                                <td><?php echo $availed_spl = $availed_days['SPL'] ?? 0;?></td>
                                <td><?php echo $availed_lwp = $availed_days['LWP'] ?? 0;?></td>
                                <td><?php echo $availed_el = $availed_days['EL'] ?? 0;?></td>



                                <td><?php echo ($allocated_cl-$availed_cl);?></td>
                                <td><?php echo ($allocated_sl-$availed_sl);?></td>
                                <td><?php echo ($allocated_spl-$availed_spl);?></td>
                                <td><?php echo ($allocated_lwp-$availed_lwp);?></td>
                                <td><?php echo ($allocated_el-$availed_el);?></td>
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
        $('.btn-export').on('click',function (e) {
            let uri = 'data:application/vnd.ms-excel;base64,';
            let template = $('div.leave-summary-sheet').html();
            window.location.href = uri + btoa(template);
        });
    </script>
<?php else:
    echo "<h5 class='text text-danger'>There is no data according to your search.</h5>";
endif;
?>

<script>
    dataTablePlaceHolder();
</script>