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
                $employee_info->DesignationID = $designation->local_name ?? '';
            }
            $department = $this_object->employee->table("settings_master",$employee_info->DepartmentID);//->fetch();
            if ($department) {
                $employee_info->DepartmentID = $department->local_name ?? '';
            }
            $section = $this_object->employee->table("settings_master",$employee_info->SectionID);//->fetch();
            if (isset($section->name)) {
                $employee_info->SectionID = $section->local_name;
            }

            $employee_info->BloodGroup = $employee_info->BloodGroup > 0 ? config('constants.blood')['bn'][$employee_info->BloodGroup] : null;
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
                                    <h5 class="ml-4"><?php echo $company_info->local_name; ?></h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8 offset-sm-3">
                                    <span class="font-weight-bold ml-4">পরিচয় পত্র</span>
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
                                    <span class="font-weight-bold">আইডি নং</span>
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
                                    <span class="font-weight-bold">নাম</span>
                                </div>
                                <div class="col-sm-1">
                                    :
                                </div>
                                <div class="col-sm-6">
                                    <?php echo $employee_info->LocalName; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">
                                    <span class="font-weight-bold">রক্তের গ্রুপ</span>
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
                                    <span class="font-weight-bold">পদবী</span>
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
                                    <span class="font-weight-bold">শাখা</span>
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
                                    <span class="font-weight-bold">বিভাগ</span>
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
                                    <span class="font-weight-bold">যোগদানের তারিখ</span>
                                </div>
                                <div class="col-sm-1">
                                    :
                                </div>
                                <div class="col-sm-6">
                                    <?php echo translate_number(date_conversion('d-m-Y',$employee_info->DOJ), 'bn'); ?>
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
                            <img class="img img-fluid rounded EmployeePhoto ml-0" src="<?php echo asset($company_signature);?>" alt="Company Signature" style="width:70px !important;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5 ml-4">
                            <p>কর্মীর স্বাক্ষর</p>
                        </div>
                        <div class="col-sm-6">
                            <p>কর্তৃপক্ষ</p>
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
                                    <p>ইস্যুর তারিখ: <?php $curr_date = date('d-m-Y'); echo translate_number($curr_date,'bn') ?> </p>
                                    <p>মেয়াদ: <?php echo translate_number(date('d-m-Y',strtotime($curr_date." + 6 Years")), 'bn'); ?> </p>
                                    <?php if(isset($transfer_data->EffectiveDate)): ?>
                                        <p>স্থানান্তর তারিখ: <?php echo translate_number(date_conversion('d-m-Y',$transfer_data->EffectiveDate ?? null) ?? '', 'bn'); ?> </p>
                                    <?php endif;?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 mt-2">
                                <span class="font-weight-bold">
                                    <?php echo $company_info->local_name;?>
                                </span><br />
                                    <span><?php echo $company_info->local_address?></span> <br />
                                    <span>ফোন (অফিস): <?php echo $company_info->office_phone; ?></span> <br />
                                    <span>ওয়েবসাইট: <?php echo $company_info->web_address;?></span> <br /><br />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-10">
                                    <p>স্থায়ী ঠিকানা: <br /> <?php echo $prm_address_info->local_address ?? ''; ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <p>জাতীয় পরিচয় পত্র নং: <?php echo translate_number($employee_info->NationalIDCardNo,'bn'); ?> <br /></p>
                                    <p>কাজের ধরন: <?php
                                        $employment_nature = config('constants.employment_nature')['bn'];
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
