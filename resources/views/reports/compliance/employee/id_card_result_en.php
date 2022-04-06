<?php if ($employee_infos):
    foreach ($employee_infos as $employee_info):
        if ($employee_info) {
            $pr_address_info = $this_object->employee->table("address_info")->where("EmployeeID",$employee_info->id)->where('Type',1)->fetch();
            if ($pr_address_info) {
                $pr_address_info['StateId'] = $this_object->employee->table('districts',$pr_address_info->StateId)->name ?? '';//->fetch();
            }

            $prm_address_info = $this_object->employee->table("address_info")->where("EmployeeID",$employee_info->id)->where('Type',2)->fetch();
            if ($prm_address_info) {
                $prm_address_info['StateId'] = $this_object->employee->table('districts',$prm_address_info->StateId)->name ?? '';//->fetch();
            }

            $designation = $this_object->employee->table("settings_master",$employee_info->DesignationID);//->fetch();
            if ($designation) {
                $employee_info->DesignationID = $designation->name ?? '';
            }
            $department = $this_object->employee->table("settings_master",$employee_info->DepartmentID);//->fetch();
            if ($department) {
                $employee_info->DepartmentID = $department->name ?? '';
            }
            $section = $this_object->employee->table("settings_master",$employee_info->SectionID);//->fetch();
            if (isset($section->name)) {
                $employee_info->SectionID = $section->name;
            }

            $employee_info->BloodGroup = $employee_info->BloodGroup > 0 ? config('constants.blood')['en'][$employee_info->BloodGroup] : null;
            $employee_info->MaritalStatus = $employee_info->MaritalStatus > 0 ? config('constants.maritial')[$employee_info->MaritalStatus] : null;
            //myLog("MaritalStatus: ". $employee_info->MaritalStatus);

            $transfer_data = $this_object->employee->table('transfer_history')->select('id','EffectiveDate')->where('EmployeeCode',$employee_info->EmployeeCode)->orderBy('id','desc')->fetch();
        }
        ?>
        <div class="col-sm-5 col-md-auto">
            <div class="card card-print" style="width: 290px; height: 460px !important;">
                <div class="card-body-x p-2">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-5 offset-sm-3">
                                    <?php
                                    $path = "uploads/images/";
                                    $company_photo = $path."company/".$company_info->logo;
                                    $file_dir = upload_path("/images/company/".$company_info->logo);
                                    if(!$company_info->logo || !is_file($file_dir)) {
                                        $company_photo = $path."no-image.jpg";
                                    }
                                    ?>
                                    <img class="img img-fluid rounded company-logo" src="<?php echo asset($company_photo);?>" alt="Company Logo">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-12">
                                    <h5 class="ml-4"><?php echo $company_info->name?></h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8 offset-sm-3">
                                    <span class="font-weight-bold">IDENTITY CARD</span>
                                </div>
                                <div class="col-sm-5 offset-sm-3">
                                    <?php
                                    $path = "uploads/images/";
                                    $employee_photo = $path."employee/".$employee_info->EmployeePhoto;
                                    $file_dir = upload_path("/images/employee/".$employee_info->EmployeePhoto);
                                    if(!$employee_info->EmployeePhoto || !is_file($file_dir)) {
                                        $employee_photo = $path."no-image.jpg";
                                    }
                                    ?>
                                    <img class="img img-fluid rounded EmployeePhoto ml-1" src="<?php echo asset($employee_photo);?>" alt="Profile picture" style="width:100px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-sm-10 offset-sm-1">
                            <div class="row">
                                <div class="col-sm-5">
                                    <span class="font-weight-bold">ID No.</span>
                                </div>
                                <div class="col-sm-1">
                                    :
                                </div>
                                <div class="col-sm-6">
                                    <?php echo $employee_info->EmployeeCode; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">
                                    <span class="font-weight-bold">Emp Name</span>
                                </div>
                                <div class="col-sm-1">
                                    :
                                </div>
                                <div class="col-sm-6">
                                    <?php echo $employee_info->EmployeeName; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">
                                    <span class="font-weight-bold">Blood Group</span>
                                </div>
                                <div class="col-sm-1">
                                    :
                                </div>
                                <div class="col-sm-6">
                                    <?php echo $employee_info->BloodGroup; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">
                                    <span class="font-weight-bold">Designation</span>
                                </div>
                                <div class="col-sm-1">
                                    :
                                </div>
                                <div class="col-sm-6">
                                    <?php echo $employee_info->DesignationID; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">
                                    <span class="font-weight-bold">Section</span>
                                </div>
                                <div class="col-sm-1">
                                    :
                                </div>
                                <div class="col-sm-6">
                                    <?php echo $employee_info->SectionID; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">
                                    <span class="font-weight-bold">Department</span>
                                </div>
                                <div class="col-sm-1">
                                    :
                                </div>
                                <div class="col-sm-6">
                                    <?php echo $employee_info->DepartmentID; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">
                                    <span class="font-weight-bold">Date of join</span>
                                </div>
                                <div class="col-sm-1">
                                    :
                                </div>
                                <div class="col-sm-6">
                                    <?php echo date_conversion('d-M-Y',$employee_info->DOJ); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-5 ml-3">
                            <?php
                            $path = "uploads/images/";
                            $employee_signature = $path."employee/".$employee_info->EmployeeSignature;
                            $file_dir = upload_path("/images/employee/".$employee_info->EmployeeSignature);
                            if($employee_info->EmployeeSignature && is_file($file_dir)) {?>
                                <img class="img img-fluid rounded EmployeePhoto ml-3" src="<?php echo asset($employee_signature);?>" alt="User Signature" style="width:70px !important;">
                            <?php }?>
                        </div>
                        <div class="col-sm-6">
                            <?php
                            $path = "uploads/images/";
                            $company_signature = $path."company/".$company_info->owner_signature;
                            $file_dir = upload_path("/images/company/".$company_info->owner_signature);
                            if(!$company_info->owner_signature || !is_file($file_dir)) {
                                $company_signature = $path."no-sign.jpg";
                            }
                            ?>
                            <img class="img img-fluid rounded EmployeePhoto ml-4" src="<?php echo asset($company_signature);?>" alt="Company Signature" style="width:70px !important;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5 ml-4">
                            <p>Staff Signature</p>
                        </div>
                        <div class="col-sm-6">
                            <p>Authorized Signature</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-5 col-md-auto">
            <div class="card card-print" style="width: 290px; height: 460px !important;">
                <div class="card-body-x p-3">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-12">
                                    <p>Issue Date: <?php echo $curr_date = date('d-M-Y'); ?> </p>
                                    <p>Valid Date: <?php echo date('d-M-Y',strtotime($curr_date." + 6 Years")); ?> </p>
                                    <?php if(isset($transfer_data->EffectiveDate)): ?>
                                        <p>Transfer Date: <?php echo date_conversion('d-M-Y',$transfer_data->EffectiveDate ?? null) ?? ''; ?> </p>
                                    <?php endif;?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 mt-2">
                                <span class="font-weight-bold">
                                    <?php echo $company_info->name;?>
                                </span><br />
                                    <span><?php echo $company_info->address?></span> <br />
                                    <span>Office Phone: <?php echo $company_info->office_phone; ?></span> <br />
                                    <span>Web: <?php echo $company_info->web_address;?></span> <br /><br />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-10">
                                    <p>Permanent Address: <br /> <?php echo $prm_address_info->Address ?? ''; ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <p>National ID No.: <?php echo $employee_info->NationalIDCardNo; ?> <br /></p>
                                    <p>Employment Nature: <?php
                                        $employment_nature = config('constants.employment_nature');
                                        echo $employment_nature[$employee_info->EmployeeNature] ?? '';
                                        ?></p>
                                </div>
                                <p class="font-weight-bold">উক্ত পরিচয় পত্র হারিয়ে গেলে কর্তৃপক্ষকে জানাতে হবে।</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach;
else:
    echo "<h5 class='text text-danger'>There is no data according to your search.</h5>";
endif;
?>
<style>
    /* override styles when printing */
    @media print {
        .card-print {
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2) !important;
            border-radius: 20px;
        }
    }
</style>
