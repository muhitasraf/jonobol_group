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
                <table class="table table-bordered">
                    <thead>
                        <th>No.</th>
                        <th>Date</th>
                        <th>Employee Code</th>
                        <th>Name</th>
                        <th>Shift In Time</th>
                        <th>Shift Out Time</th>
                        <th>In Time</th>
                        <th>Out Time</th>
                    </thead>
                    <tbody>
                        <?php foreach($employee_info as $key => $row):?>
                            <tr>
                                <td><?php echo $key+1; ?></td>
                                <td><?php echo date_conversion('d-m-Y',$row['WorkDate']); ?></td>
                                <td><?php echo $row['EmployeeCode']; ?></td>
                                <td><?php echo $row['EmployeeName']; ?></td>
                                <td><?php echo date_conversion('h:i A',$row['ShiftInTime']); ?></td>
                                <td><?php echo date_conversion('h:i A',$row['ShiftOutTime']); ?></td>
                                <td><?php echo date_conversion('h:i A',$row['InTime']); ?></td>
                                <td><?php echo date_conversion('h:i A',$row['OutTime']); ?></td>
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