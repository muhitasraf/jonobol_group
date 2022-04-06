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
                <table class="table table-borderless table-sm">
                    <tbody>
                        <tr>
                            <td class="font-weight-bold">Unit</td>
                            <td>: <?php echo $employee_info->UnitID?></td>
                            <td></td>
                            <td></td>
                            <td class="font-weight-bold">DOJ</td>
                            <td>: <?php echo date_conversion('d-M-Y',$employee_info->DOJ);?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Section</td>
                            <td>: <?php echo $employee_info->SectionID;?></td>
                            <td></td>
                            <td></td>
                            <td class="font-weight-bold">Grade</td>
                            <td>: <?php echo $employee_info->GradeID?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Name</td>
                            <td>: <?php echo $employee_info->EmployeeName;?></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Designation</td>
                            <td>: <?php echo $employee_info->DesignationID;?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-sm-10x">
                <table class="table table-bordered">
                    <thead>
                        <th>Date</th>
                        <th>Status</th>
                        <th>In Time</th>
                        <th>Out Time</th>
                        <th>Late Hour</th>
                        <th>OT Hour</th>
                        <th>EOT Hours offday</th>
                        <th>Remarks</th>
                    </thead>
                    <tbody>
                        <?php echo $data;?>
<!--                        --><?php //foreach($employee_info as $key => $row):?>
<!--                            <tr>-->
<!--                                <td>--><?php //echo $key+1; ?><!--</td>-->
<!--                                <td>--><?php //echo $row->EmployeeName; ?><!--</td>-->
<!--                                <td>--><?php //echo $row->Department; ?><!--</td>-->
<!--                                <td>--><?php //echo $row->Designation; ?><!--</td>-->
<!--                                <td>--><?php //echo $row->Section; ?><!--</td>-->
<!--                                <td>--><?php //echo $row->GradeInfoID; ?><!--</td>-->
<!--                                <td>--><?php //echo date_conversion($row->DOB,'d-M-Y'); ?><!--</td>-->
<!--                                <td>--><?php //echo date_conversion($row->DOJ,'d-M-Y'); ?><!--</td>-->
<!--                            </tr>-->
<!--                        --><?php //endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php else:
    echo "<h5 class='text text-danger'>There is no data according to your search.</h5>";
endif;
?>