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
            <div class="col-sm-12">
                <table class="table table-bordered">
                    <thead>
                        <th>Emp Code</th>
                        <th>Emp Name</th>
                        <th>Department</th>
                        <th>Designation</th>
                        <th>Section</th>
                        <th>Grade</th>
                        <th>DOB</th>
                        <th>DOJ</th>
                    </thead>
                    <tbody>
                        <?php foreach($employee_info as $key => $row):?>
                            <tr>
                                <td><?php echo $row['EmployeeCode']; ?></td>
                                <td><?php echo $row['EmployeeName']; ?></td>
                                <td><?php echo $row['Department']; ?></td>
                                <td><?php echo $row['Designation']; ?></td>
                                <td><?php echo $row['Section']; ?></td>
                                <td><?php echo $row['GradeInfoID']; ?></td>
                                <td><?php echo date_conversion('d-M-Y',$row['DOB']); ?></td>
                                <td><?php echo date_conversion('d-M-Y',$row['DOJ']); ?></td>
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
?>