<?php if ($employee_info):?>
    <div class="container">
        <div class="row">
            <div class="col-sm-7">
                <div class="row">
                    <div class="col-sm-4">
                        <?php echo view('includes/company_logo',compact('company_info'),false); ?>
                    </div>
                    <div class="col-sm-8">
                        <h4><?php echo $company_info->name?></h4>
                        <p><?php echo $company_info->address?></p>
                        <p class="font-weight-bold">Employee Profile</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 offset-sm-2">
                <div class="float-right">
                    <?php
                    $path = "uploads/images/";
                    $employee_photo = $path."employee/".$employee_info->EmployeePhoto;
                    $file_dir = upload_path("/images/employee/".$employee_info->EmployeePhoto);
                    if(!$employee_info->EmployeePhoto || !is_file($file_dir)) {
                        $employee_photo = $path."no-image.jpg";
                    }
                    ?>
                    <img class="img img-fluid rounded EmployeePhoto" src="<?php echo asset($employee_photo);?>" alt="Profile picture" style="width: 150px; height: 130px;">
                    <p>Report Date: <?php echo date('d-M-Y') ?></p>
                </div>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-sm-12">
                <table class="table table-borderless table-sm table-responsive">
                    <tbody>
                    <tr>
                        <td class="w-25 font-weight-bold">Name  </td>
                        <td>: <?php echo $employee_info->EmployeeName; ?></td>
                    </tr>
                    <tr>
                        <td class="w-25 font-weight-bold">Father's Name  </td>
                        <td>: </td>
                    </tr>
                    <tr>
                        <td class="w-25 font-weight-bold">Mother's Name  </td>
                        <td>: </td>
                    </tr>
                    <tr>
                        <td class="w-25 font-weight-bold">Present Address  </td>
                        <td>: <?php echo $pr_address_info->Address ?? ''; ?></td>
                    </tr>
                    <tr>
                        <td class="w-25 font-weight-bold">Permanent Address  </td>
                        <td>: <?php echo $prm_address_info->Address ?? ''; ?></td>
                    </tr>
                    <tr>
                        <td class="w-25 font-weight-bold">Date of Birth  </td>
                        <td>: <?php echo date_conversion('d-m-Y',$employee_info->DOB); ?></td>
                    </tr>
                    <tr>
                        <td class="w-25 font-weight-bold">Marital Status  </td>
                        <td>: <?php echo $employee_info->MaritalStatus; ?></td>
                    </tr>
                    <tr>
                        <td class="w-25 font-weight-bold">Nationality  </td>
                        <td>: <?php echo $employee_info->Nationality; ?></td>
                    </tr>
                    <tr>
                        <td class="w-25 font-weight-bold">Education  </td>
                        <td>: </td>
                    </tr>
                    <tr>
                        <td class="w-25 font-weight-bold">Blood Group  </td>
                        <td>: <?php echo $employee_info->BloodGroup; ?></td>
                    </tr>
                    <tr>
                        <td class="w-25 font-weight-bold">Card No  </td>
                        <td>: <?php echo $employee_info->PunchCardNo; ?></td>
                    </tr>
                    <tr>
                        <td class="w-25 font-weight-bold">Designation  </td>
                        <td>: <?php echo $employee_info->DesignationID; ?></td>
                    </tr>
                    <tr>
                        <td class="w-25 font-weight-bold">Section  </td>
                        <td>: <?php echo $employee_info->SectionID; ?></td>
                    </tr>
                    <tr>
                        <td class="w-25 font-weight-bold">Date of Join  </td>
                        <td>: <?php echo date_conversion('d-m-Y',$employee_info->DOJ); ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="ml-2">
                <u>_____________</u>
                <p>Signature</p>
            </div>
        </div>
    </div>
<?php else:
    echo "<h5 class='text text-danger'>There is no data according to your search.</h5>";
endif;
?>