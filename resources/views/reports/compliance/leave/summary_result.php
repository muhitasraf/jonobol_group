<?php if ($employee_info):?>
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
                        <th>No.</th>
                        <th>Department</th>
                        <th>Designation</th>
                        <th>Section</th>
                        <th>Employee Code</th>
                        <th>Employee Name</th>
                        <th>DOJ</th>
                        <th>Service Length</th>
<!--                        <th colspan="5">Leave Allocated</th>-->
                        <th>Leave Allocated</th>
                        <th>Leave Availed</th>
                        <th>Leave Balance</th>
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
                            <td></td>
                            <td></td>
                            <td></td>
<!--                            <td>CL</td>-->
<!--                            <td>SL</td>-->
<!--                            <td>SPL</td>-->
<!--                            <td>LWP</td>-->
<!--                            <td>EL</td>-->
<!--                            <td>CL</td>-->
<!--                            <td>SL</td>-->
<!--                            <td>SPL</td>-->
<!--                            <td>LWP</td>-->
<!--                            <td>EL</td>-->
<!--                            <td>CL</td>-->
<!--                            <td>SL</td>-->
<!--                            <td>SPL</td>-->
<!--                            <td>LWP</td>-->
<!--                            <td>EL</td>-->
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
                                    ?>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
<!--                                <td>CL</td>-->
<!--                                <td>SL</td>-->
<!--                                <td>SPL</td>-->
<!--                                <td>LWP</td>-->
<!--                                <td>EL</td>-->
<!--                                <td>CL</td>-->
<!--                                <td>SL</td>-->
<!--                                <td>SPL</td>-->
<!--                                <td>LWP</td>-->
<!--                                <td>EL</td>-->
<!--                                <td>CL</td>-->
<!--                                <td>SL</td>-->
<!--                                <td>SPL</td>-->
<!--                                <td>LWP</td>-->
<!--                                <td>EL</td>-->
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
?>

<script>
    dataTablePlaceHolder();
</script>