<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header pt-2 pb-0">
        <div class="container-fluid">
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <?php include_once("employee_search.php");
                $can = 0;
                 if ($perm->hasPerm(['edit-employee'])) {
                     $can = 1;
                 }
                ?>
                <div class="col">
                    <div class="card card-info card-outline">
                        <?php if ($perm->hasPerm(['show-employee','edit-employee'])):?>
                            <ul class="nav nav-tabs p-1" id="custom-content-above-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="general_info-tab" data-toggle="pill" href="#general_info" role="tab" aria-controls="general_info" aria-selected="true">General</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="official_info" data-toggle="pill" href="#custom-content-above-profile" role="tab" aria-controls="custom-content-above-profile" aria-selected="false">Official</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="rule_info-tab" data-toggle="pill" href="#rule_info" role="tab" aria-controls="rule_info" aria-selected="false">Rule</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="education_info-tab" data-toggle="pill" href="#education_info" role="tab" aria-controls="education_info" aria-selected="false">Education</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="family-info-tab" data-toggle="pill" href="#family-info" role="tab" aria-controls="family-info" aria-selected="false">Family</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="nominee_info-tab" data-toggle="pill" href="#nominee_info" role="tab" aria-controls="nominee_info" aria-selected="false">Nominee</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="user_defined-tab" data-toggle="pill" href="#user_defined" role="tab" aria-controls="user_defined" aria-selected="false">User Defined</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="custom-content-above-tabContent">
                                <div class="tab-pane fade show active" id="general_info" role="tabpanel" aria-labelledby="general_info-tab">
                                    <form action="<?php echo route("employee/update/".$employee_info->id);?>" class="role" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="_method" value="PATCH">
                                        <?php echo csrf_field();?>
                                        <div class="card">
                                            <div class="card-group pt-1"><!-- card-deck -->
                                                <!-- left column -->
                                                <div class="col-sm-3">
                                                    <!-- general form elements -->
                                                    <div class="card card-primary">
                                                        <div class="card-body-x p-1">
                                                            <div class="form-group mb-0">
                                                                <label class="m-0" for="inputPhoto">Photo</label>
                                                                <div class="text-center">
                                                                    <?php
                                                                    $path = "uploads/images/";
                                                                    $employee_photo = $path."employee/".$employee_info->EmployeePhoto;
                                                                    $file_dir = upload_path("/images/employee/".$employee_info->EmployeePhoto);
                                                                    if(!$employee_info->EmployeePhoto || !is_file($file_dir)) {
                                                                        $employee_photo = $path."no-image.jpg";
                                                                    }
                                                                    ?>
                                                                    <img class="user-img img-fluid rounded" id="EmployeePhoto" src="<?php echo asset($employee_photo);?>" alt="User profile picture" style="width: 150px; height: 130px;">
                                                                </div>
                                                                <div class="align-text-bottom mb-0">
                                                                    <label for="user_image_files" class="btn btn-xs btn-link float-left">Add Pic</label>
                                                                    <input id="user_image_files" style="visibility:hidden;" type="file" class="mb-0" name="EmployeePhoto" accept="image/jpeg">
                                                                    <?php
                                                                    if(isset($errors['EmployeePhoto'])):?>
                                                                        <span class="text-danger"><?php echo $errors['EmployeePhoto'][0]; ?></span>
                                                                    <?php endif;?>
                                                                    <?php if(isset($errors['EmployeePhoto.error'])):?>
                                                                        <span class="text-danger"><?php echo explode('.', $errors['EmployeePhoto.error'][0])[0]; ?></span>
                                                                    <?php endif;?>
                                                                    <?php if(isset($errors['EmployeePhoto.type'])):?>
                                                                        <span class="text-danger"><?php echo explode('.', $errors['EmployeePhoto.type'][0])[0]; ?></span>
                                                                    <?php endif;?>
                                                                    <?php if(isset($errors['EmployeePhoto.size'])):?>
                                                                        <span class="text-danger"><?php echo explode('.', $errors['EmployeePhoto.size'][0])[0]; ?></span>
                                                                    <?php endif;?>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="EmployeeCode">Employee Code</label>
                                                                <?php echo form_input('EmployeeCode','text', $employee_info->EmployeeCode,'class="form-control form-control-sm input-highlight" id="EmployeeCode" placeholder="Employee Code" readonly'); ?>
                                                                <?php if(isset($errors['EmployeeCode'])):?>
                                                                    <span class="text-danger"><?php echo $errors['EmployeeCode'][0]; ?></span>
                                                                <?php endif;?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputBlood">Employee Status</label>
                                                                <?php
                                                                $status = config('constants.status');
                                                                echo form_select('EmployeeStatus', $status, $employee_info->EmployeeStatus, $attribute='class="form-control form-control-sm" id="inputBlood"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputNationalID">National ID Card No.</label>
                                                                <?php echo form_input('NationalIDCardNo','text', $employee_info->NationalIDCardNo,'class="form-control form-control-sm" id="inputNationalID" placeholder="Type National ID No"'); ?>
                                                                <?php if(isset($errors['name'])):?>
                                                                    <span class="text-danger"><?php echo $errors['NationalIDCardNo'][0]; ?></span>
                                                                <?php endif;?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputPunchCardNo">BadgeNumber</label>
                                                                <?php echo form_input('BadgeNumber','text', $employee_info->BadgeNumber,'class="form-control form-control-sm" id="inputPunchCardNo" placeholder="Type Punch Card No"'); ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputPunchCardNo">Punch Card No</label>
                                                                <?php echo form_input('PunchCardNo','text', $employee_info->PunchCardNo,'class="form-control form-control-sm" id="inputPunchCardNo" placeholder="Type Punch Card No"'); ?>
                                                            </div>
                                                            <!--div class="form-group mb-2">
                                                                <label class="m-0" for="inputEmployeeType">Employee Type</label>
                                                                <div class="input-group">
                                                                    <?php
                                                                    $employee_type = config('constants.employee_type');
                                                                    ?>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" id="inlineCheckbox1" value="1" name="EmpType" <?php if($employee_info->EmpType==1) echo "checked";?>>
                                                                        <label class="form-check-label" for="inlineCheckbox1"><?php echo $employee_type[1]; ?></label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" id="inlineCheckbox2" value="2" name="EmpType" <?php if($employee_info->EmpType!=1) echo "checked";?>>
                                                                        <label class="form-check-label" for="inlineCheckbox2"><?php echo $employee_type[2]; ?></label>
                                                                    </div>
                                                                </div>
                                                            </div-->
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputEmploymentNature">Employee Type</label>
                                                                <?php
                                                                $employee_type = config('constants.employee_type');
                                                                echo form_select('EmpType', $employee_type, $employee_info->EmpType,'class="form-control form-control-sm" id="inputEmploymentType"');
                                                                ?>
                                                            </div>                                                            
                                                            <!--div class="form-group mb-2">
                                                                <label class="m-0" for="inputEmploymentNature">Employment Nature</label>
                                                                <?php
                                                                //$employment_nature = config('constants.employment_nature');
                                                                //echo form_select('EmployeeNature', $employment_nature['en'], $employee_info->EmployeeNature,'class="form-control form-control-sm" id="inputEmploymentNature"');
                                                                ?>
                                                            </div-->
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputPhoto">Signature</label>
                                                                <div class="text-center">
                                                                    <?php
                                                                        $path = "uploads/images/";
                                                                        $employee_signature = $path."employee/".$employee_info->EmployeeSignature;
                                                                        $file_dir = upload_path("/images/employee/".$employee_info->EmployeeSignature);
                                                                        if(!$employee_info->EmployeeSignature || !is_file($file_dir)){
                                                                            $employee_signature = $path."no-sign.jpg";
                                                                        }
                                                                    ?>
                                                                    <img class="profile-user-img-x img-fluid rounded" id="EmployeeSignature" src="<?php echo asset($employee_signature);?>" alt="User Signature" style="width: 150px; height: 70px;">
                                                                </div>
                                                                <div class="align-text-bottom mb-0">
                                                                    <label for="user_signature_files" class="btn btn-xs btn-link float-left">Add Pic</label>
                                                                    <input id="user_signature_files" style="visibility:hidden;" type="file" class="mb-0" name="EmployeeSignature" accept="image/jpeg">
                                                                    <?php
                                                                        if(isset($errors['EmployeeSignature'])):?>
                                                                        <span class="text-danger"><?php echo $errors['EmployeeSignature'][0]; ?></span>
                                                                        <?php endif;?>
                                                                        <?php if(isset($errors['EmployeeSignature.error'])):?>
                                                                        <span class="text-danger"><?php echo explode('.', $errors['EmployeeSignature.error'][0])[0]; ?></span>
                                                                        <?php endif;?>
                                                                        <?php if(isset($errors['EmployeeSignature.type'])):?>
                                                                        <span class="text-danger"><?php echo explode('.', $errors['EmployeeSignature.type'][0])[0]; ?></span>
                                                                        <?php endif;?>
                                                                        <?php if(isset($errors['EmployeeSignature.size'])):?>
                                                                        <span class="text-danger"><?php echo explode('.', $errors['EmployeeSignature.size'][0])[0]; ?></span>
                                                                        <?php endif;?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                    <!-- /.card -->
                                                </div><!--/.col (left) -->
                                                <!-- right column -->
                                                <div class="col-sm-9">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="card">
                                                                <div class="card-body-x p-1">
                                                                    <table class="table table-sm">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>Saluation</th>
                                                                            <th>First Name</th>
                                                                            <th>Middle Name</th>
                                                                            <th>Last Name</th>
                                                                            <th>Name In Local Language</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr>
                                                                            <td>
                                                                                <?php
                                                                                $saluations = config('constants.saluation');
                                                                                echo form_select('Saluation', $saluations, $employee_info->Saluation, $attribute='class="form-control form-control-sm" id="inputSaluation"');
                                                                                ?>
                                                                            </td>
                                                                            <td><input type="text" class="form-control form-control-sm input-highlight" id="inputMiddleName" placeholder="Enter first name" name="FName" value="<?php echo $employee_info->FName;?>"></td>
                                                                            <td><input type="text" class="form-control form-control-sm input-highlight" id="inputMiddleName" placeholder="Enter middle name" name="MName" value="<?php echo $employee_info->MName;?>"></td>
                                                                            <td><input type="text" class="form-control form-control-sm input-highlight" id="inputLastName" placeholder="Enter last name" name="LName" value="<?php echo $employee_info->LName;?>"></td>
                                                                            <td><input type="text" class="form-control form-control-sm keyboard" id="inputLocalName" placeholder="Enter name in local language" name="LocalName" autocomplete="off" data-toggle="modal" data-target="#myModal" value="<?php echo $employee_info->LocalName;?>"></td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <!-- /.card-body -->
                                                            </div>
                                                            <!-- /.card -->
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-9">
                                                            <!-- permanent address -->
                                                            <div class="card">
                                                                <div class="card-header p-1">
                                                                    Permanent Address
                                                                </div>
                                                                <div class="card-body-x p-1">
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="inputPermanentAddress">Address</label>
                                                                        <?php
                                                                        echo form_textarea('PermanentAddress', $address_info[0]->Address ?? '', $attribute='class="form-control" rows="2" placeholder="Enter Address" id="inputPermanentAddress"');
                                                                        ?>
                                                                    </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form-group mb-2">
                                                                                    <label class="m-0" for="inputPermanentPS">P.S.</label>
                                                                                    <?php echo form_input('PermanentCity','text', $address_info[0]->City ?? '','class="form-control form-control-sm" id="inputPermanentPS" placeholder="Police Station"'); ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form-group mb-2">
                                                                                    <label class="m-0" for="inputPermanentPostalCode">Zip/Postal Code</label>
                                                                                    <?php echo form_input('PermanentZipCode','text', $address_info[0]->ZipCode ?? '','class="form-control form-control-sm" id="inputPermanentPostalCode" placeholder="Postal Code"'); ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form-group mb-2">
                                                                                    <label class="m-0" for="inputDistrict">District</label>
                                                                                    <?php
                                                                                    echo form_select('PermanentStateId', $districts ?? [], $address_info[0]->StateId ?? '', $attribute='class="select2 form-control form-control-sm" id="inputDistrict"');
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form-group mb-2">
                                                                                    <label class="m-0" for="PermanentCountryId">Country</label> <?php
                                                                                    echo form_select('PermanentCountryId', $countries ?? [], $address_info[0]->CountryId ?? '19', $attribute='class="select2-district-x form-control form-control-sm" id="PermanentCountryId"');
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group mb-2">
                                                                            <label class="m-0" for="inputPermanentAddressLocal">Address in local language</label>
                                                                            <?php
                                                                            echo form_textarea('PermanentAddressLocal',$address_info[0]->local_address ?? null, $attribute='class="form-control keyboard" rows="2" placeholder="Enter Address" id="PermanentAddressLocal" autocomplete="off" data-toggle="modal" data-target="#myModal"');
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- /.card-body -->
                                                            <!-- /.card -->
                                                            <!-- present address -->
                                                            <div class="card">
                                                                <div class="card-header p-1">
                                                                    Present Address
                                                                    <div class="card-tools">
                                                                        <div class="form-check form-check-inline">
                                                                            <input class="form-check-input" type="checkbox" value="1" id="is_address_same" name="is_address_same" <?php echo ($address_info[0]->is_address_same==1 ? 'checked' : '');?>>
                                                                            <label class="form-check-label" for="is_address_same">Same as present address</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="card-body-x p-1" id="sameAsPresent">
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="inputPresentAddress">Address</label>
                                                                        <?php
                                                                        echo form_textarea('PresentAddress', $address_info[1]->Address ?? null, $attribute='class="form-control" rows="2" placeholder="Enter Address" id="inputPresentAddress"');
                                                                        ?>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group mb-2">
                                                                                <label class="m-0" for="inputPresentPS">P.S.</label>
                                                                                <?php echo form_input('PresentCity','text', $address_info[1]->City ?? null,'class="form-control form-control-sm" id="inputPresentPS" placeholder="Police Station"'); ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group mb-2">
                                                                                <label class="m-0" for="inputPresentPostalCode">Zip/Postal Code</label>
                                                                                <?php echo form_input('PresentZipCode','text', $address_info[1]->ZipCode ?? null,'class="form-control form-control-sm" id="inputPresentPostalCode" placeholder="Postal Code"'); ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group mb-2">
                                                                                <label class="m-0" for="inputPresentDistrict">District</label>
                                                                                <?php
                                                                                echo form_select('PresentStateId', $districts ?? [], $address_info[1]->StateId ?? '','class="select2 form-control form-control-sm" id="inputPresentDistrict"');
                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group mb-2">
                                                                                <label class="m-0" for="PresentCountryId">Country</label> <?php
                                                                                echo form_select('PresentCountryId', $countries ?? [], $address_info[1]->CountryId ?? '19','class="select2-district-x form-control form-control-sm" id="PresentCountryId"');
                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="inputPermanentAddressLocal">Address in local language</label>
                                                                        <?php
                                                                        echo form_textarea('PresentAddressLocal', $address_info[1]->local_address ?? null, $attribute='class="form-control keyboard" rows="2" placeholder="Enter Address" id="PermanentAddressLocal" autocomplete="off"
                                                                         data-toggle="modal" data-target="#myModal"');
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                <!-- /.card-body -->
                                                            </div>
                                                        </div>
                                                            <!-- /.card -->
                                                        <!-- right column -->
                                                        <div class="col-sm-3">
                                                            <div class="card">
                                                                <div class="card-body-x p-1">
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="DOB">Date of birth</label>
                                                                        <div class="input-group">
                                                                            <?php
                                                                                echo form_input('DOB','text',date_conversion('d-m-Y', $employee_info->DOB), $attribute='class="form-control form-control-sm form_date" autocomplete="off" id="DOB" ');
                                                                            ?>
                                                                        </div>
                                                                        <!-- /input-group -->
                                                                    </div>
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="DOB">Age</label>
                                                                        <div class="input-group">
                                                                            <?php
                                                                                $age = date_diff(date_create(), date_create($employee_info->DOB));
                                                                                $age = $age->format("%Y Y,%M M,%d D");
                                                                                echo form_input('age','text',$age, $attribute='class="form-control form-control-sm" autocomplete="off" id="DOB" readonly');
                                                                            ?>
                                                                        </div>
                                                                        <!-- /input-group -->
                                                                    </div>
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="inputGender">Gender</label>
                                                                        <?php
                                                                        $gender = config('constants.gender');
                                                                        echo form_select('Gender', $gender, $employee_info->Gender, $attribute='class="form-control form-control-sm" id="inputGender"');
                                                                        ?>
                                                                    </div>
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="inputReligion">Religion</label>
                                                                        <?php
                                                                        $religion = config('constants.religion');
                                                                        echo form_select('Religion', $religion, $employee_info->Religion, $attribute='class="form-control form-control-sm" id="inputReligion"');
                                                                        ?>
                                                                    </div>
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="Nationality">Nationality</label>
                                                                        <div class="input-group">
                                                                            <?php
                                                                            echo form_input('Nationality','text', $employee_info->Nationality, $attribute='class="form-control form-control-sm" id="Nationality"');
                                                                            ?>
                                                                        </div>
                                                                        <!-- /input-group -->
                                                                    </div>
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="inputBlood">Maritial Status</label>
                                                                        <?php
                                                                        $maritial = config('constants.maritial');
                                                                        echo form_select('MaritalStatus', $maritial, $employee_info->MaritalStatus, $attribute='class="form-control form-control-sm" id="inputMaritalStatus"');
                                                                        ?>
                                                                    </div>
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="inputBlood">Blood Group</label>
                                                                        <?php
                                                                        $blood = config('constants.blood');
                                                                        echo form_select('BloodGroup', $blood['en'], $employee_info->BloodGroup, $attribute='class="form-control form-control-sm" id="inputBlood"');
                                                                        ?>
                                                                    </div>
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="Mobile">Mobile</label>
                                                                        <?php echo form_input('Mobile','text', $employee_info->Mobile,'class="form-control form-control-sm" id="Mobile" placeholder="Mobile No"'); ?>
                                                                    </div>
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="inputEmail">Email</label>
                                                                        <?php echo form_input('EMail','text', $employee_info->email,'class="form-control form-control-sm" id="EMail" placeholder="Email"'); ?>
                                                                    </div>
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="RefAddress">Reff. Address</label>
                                                                        <input type="text" class="form-control form-control-sm" id="RefAddress" name="RefAddress" value="<?php echo $employee_info->RefAddress; ?>">
                                                                    </div>
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="inputPunchCardNo">Personnel Remarks</label>
                                                                        <input type="text" class="form-control form-control-sm" id="inputPunchCardNo" placeholder="Password">
                                                                    </div>
                                                                </div>
                                                                <!-- /.card-body -->
                                                            </div>
                                                        </div><!--/.col (right) -->
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.card-body -->
                                            <div class="card-footer">
                                                <?php if ($can):?>
                                                    <input type="submit" class="btn btn-info float-right" name="basic_info" value="Save" />
                                                <?php endif;?>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="custom-content-above-profile" role="tabpanel" aria-labelledby="official_info">
                                    <form action="<?php echo route("employee/update/".$employee_info->id);?>" class="role" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="EmployeeCode" value="<?php echo $employee_info->EmployeeCode;?>">
                                        <div class="card">
                                            <div class="card-group pt-1"><!-- card-deck -->
                                                <!-- left column -->
                                                <div class="col-sm-4">
                                                    <!-- general form elements -->
                                                    <div class="card card-primary">
                                                        <div class="card-body-x p-1">
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="PositionID">Position</label>
                                                                <?php echo form_select('PositionID',[], $employee_info->PositionID,'class="form-control form-control-sm select2" style="width: 100%;" id="PositionID"'); ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputTemplate">Template ID</label>
                                                                <?php
                                                                $templates = [];
                                                                echo form_select('template_id', $templates,null,'class="form-control form-control-sm" id="inputTemplate"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="UnitID">Unit</label>
                                                                <?php echo form_select('UnitID', $unit, $employee_info->UnitID,'class="form-control form-control-sm" style="width: 100%;" id="UnitID"'); ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="DepartmentID">Department</label>
                                                                <?php
                                                                echo form_select('DepartmentID', $department, $employee_info->DepartmentID,'class="form-control form-control-sm select2" style="width: 100%;" id="DepartmentID"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="SectionID">Section</label>
                                                                <div class="input-highlight">
                                                                    <?php
                                                                    echo form_select('SectionID', $section, $employee_info->SectionID,'class="form-control form-control-sm select2" style="width: 100%;" id="SectionID"');
                                                                    ?>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="StaffCategoryID">Staff Category</label>
                                                                <?php
                                                                    echo form_select('StaffCategoryID', $staff_category, $employee_info->StaffCategoryID,'class="form-control form-control-sm" id="StaffCategoryID"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputEmploymentNature">Skill Category</label>
                                                                <?php
                                                                $employment_nature = config('constants.employment_nature');
                                                                echo form_select('employment_nature',[],null,'class="form-control form-control-sm" id="inputEmploymentNature"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="DOJ">Date of Joining</label>
                                                                <div class="input-highlight">
                                                                    <?php
                                                                        if(isset($employee_info->DOJ)){
                                                                            echo form_input('DOJ','text',date_conversion('d-m-Y', $employee_info->DOJ),'class="form-control form-control-sm" id="DOJ" autocomplete="off" readonly');
                                                                        }else{
                                                                            echo form_input('DOJ','text',date_conversion('d-m-Y', $employee_info->DOJ),'class="form-control form-control-sm form_date" id="DOJ" autocomplete="off"');
                                                                        }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputEmploymentNature">Provision Period</label>
                                                                <?php
                                                                $provision_period = config('constants.provision_period');
                                                                echo form_select('provision_period',$provision_period,$employee_info->provision_period,'class="form-control form-control-sm select2 provision_period" style="width: 100%;" id="inputProvisionPeriod"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputEmploymentNature">Training Period</label>
                                                                <?php
                                                                $training_period = config('constants.training_period');
                                                                echo form_select('training_period',$training_period,$employee_info->training_period,'class="form-control form-control-sm select2 training_period" style="width: 100%;" id="inputTrainingPeriod"');
                                                                ?>
                                                            </div>
                                                            <!--div class="form-group mb-2">
                                                                <label class="m-0" for="inputPosition">Govt. Designation</label>
                                                                <?php //echo form_select('position_id',[],null,'class="form-control form-control-sm select2" style="width: 100%;" id="inputPosition"'); ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputPosition">Logistic Resource</label>
                                                                <?php //echo form_select('position_id',[],null,'class="form-control form-control-sm select2" style="width: 100%;" id="inputPosition"'); ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputPosition">Skill Set</label>
                                                                <?php //echo form_select('position_id',[],null,'class="form-control form-control-sm select2" style="width: 100%;" id="inputPosition"'); ?>
                                                            </div-->
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="DOJ">Resign date</label>
                                                                <div class="input-highlight">
                                                                    <?php echo form_input('resign','text',date_conversion('d-m-Y', $employee_info->resign),'class="form-control form-control-sm form_date" id="resign" autocomplete="off"'); ?>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="DOJ">Resign Confirm date</label>
                                                                <div class="input-highlight">
                                                                    <?php echo form_input('resign_confirm','text',date_conversion('d-m-Y', $employee_info->resign_confirm),'class="form-control form-control-sm form_date" id="resign_confirm" autocomplete="off"'); ?>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="DOJ">Resign Effective date</label>
                                                                <div class="input-highlight">
                                                                    <?php echo form_input('resign_effective','text',date_conversion('d-m-Y', $employee_info->resign_effective),'class="form-control form-control-sm form_date" id="resign_effective" autocomplete="off"'); ?>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="DOS">DOS</label>
                                                                <?php echo form_input('DOS','text',date_conversion('d-m-Y', $employee_info->DOS),'class="form-control form-control-sm form_date" autocomplete="off" id="DOS" placeholder="" readonly'); ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputUnit">Review Dates</label>
                                                                <?php echo form_select('unit_id',[],null,'class="form-control  form-control-sm select2" style="width: 100%;" id="inputUnit"'); ?>
                                                            </div>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                    <!-- /.card -->
                                                </div><!--/.col (left) -->
                                                <!-- center -->
                                                <div class="col-sm-4">
                                                    <!-- general form elements -->
                                                    <div class="card card-primary">
                                                        <div class="card-body-x p-1">
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputNationalID">Position Name</label>
                                                                <?php echo form_input('PositionName','text', $employee_info->PositionName,'class="form-control form-control-sm" id="inputNationalID" placeholder=""'); ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="DesignationID">Given Designation</label>
                                                                <?php echo form_select('DesignationID',[], $employee_info->DesignationID,'class="form-control form-control-sm select2" style="width: 100%;" id="DesignationID"'); ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputEmploymentNature">Posting Place</label>
                                                                <?php
                                                                $posting_place = config('constants.posting_place');
                                                                echo form_select('posting_place',$posting_place,$employee_info->posting_place,'class="form-control form-control-sm select2 posting_place" style="width: 100%;" id="inputPostingPlace"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="DivisionID">Division</label>
                                                                <div class="input-highlight">
                                                                    <?php echo form_select('DivisionID', $division, $employee_info->DivisionID,'class="form-control form-control-sm select2" style="width: 100%; border-color: #3c8dbc; box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);" id="DivisionID"'); ?>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="Designation">Designation</label>
                                                                <div class="input-highlight">
                                                                    <?php  echo form_select('DesignationID', $designation, $employee_info->DesignationID,'class="form-control form-control-sm select2" style="width: 100%;" id="Designation"'); ?>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="SubSectionID">Sub Section</label>
                                                                <?php echo form_select('SubSectionID',[], $employee_info->SubSectionID,'class="form-control form-control-sm select2" style="width: 100%;" id="SubSectionID"'); ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputUnit">Job Location</label>
                                                                <?php echo form_select('unit_id',[],null,'class="form-control form-control-sm select2" style="width: 100%;" id="inputUnit"'); ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputUnit">Operating ID</label>
                                                                <?php echo form_select('unit_id',[],null,'class="form-control  form-control-smselect2" style="width: 100%;" id="inputUnit"'); ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputNationalID">Punch Machine Tagging</label>
                                                                <?php echo form_input('national_id','text',null,'class="form-control form-control-sm form_date" id="inputNationalID" placeholder="" readonly'); ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="DOC">Date of confirmation</label>
                                                                <?php echo form_input('DOC','text',date_conversion('d-m-Y', $employee_info->DOC),'class="form-control form-control-sm form_date" id="DOC" autocomplete="off" readonly'); ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="TCD">Training Complete Date</label>
                                                                <?php echo form_input('TCD','text',date_conversion('d-m-Y', $employee_info->TCD),'class="form-control form-control-sm form_date" autocomplete="off" id="TCD" placeholder="" readonly'); ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputUnit">Cost Center</label>
                                                                <?php echo form_select('unit_id',[],null,'class="form-control form-control-sm select2" style="width: 100%;" id="inputUnit"'); ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputNationalID">Bio Registration No.</label>
                                                                <?php echo form_input('national_id','text',null,'class="form-control form-control-sm" id="inputNationalID" placeholder=""'); ?>
                                                            </div>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                    <!-- /.card -->
                                                </div><!--/.col (center) -->
                                                <!-- right column -->
                                                <div class="col-sm-4">
                                                    <div class="card">
                                                        <div class="card-body-x p-1">
                                                            <!--div class="form-group mb-2">
                                                                <div class="input-group">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="1" name="OT" <?php echo $employee_info->OT ? 'checked':'' ;?>>
                                                                        <label class="form-check-label" for="inlineCheckbox1">Overtime</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <?php echo form_input('OTEntitledDate','text',date_conversion('d-m-Y', $employee_info->OTEntitledDate),'class="form-control form-control-sm form_date" id="inputUnit" autocomplete="off" readonly'); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="1" name="OffDayOT" <?php echo $employee_info->OffDayOT ? 'checked':'' ;?>>
                                                                    <label class="form-check-label" for="inlineCheckbox1">Offday overtime</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="1" name="HolydayBonus" <?php echo $employee_info->HolydayBonus ? 'checked':'' ;?>>
                                                                    <label class="form-check-label" for="inlineCheckbox1">Holiday Bonus</label>
                                                                </div>
                                                            </div-->
                                                            <div class="form-group mb-2">
                                                                <div class="input-group">
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="inputGender">Overtime</label>
                                                                        <?php
                                                                            $ot_array = array('0'=>'Select OT','1'=>'Active','2'=>'DeActive');
                                                                            echo form_select('OT',$ot_array,$employee_info->OT,'class="form-control form-control-sm select2" ');
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <div class="input-group">
                                                                    <div class="form-check form-check-inline">
                                                                        <label class="m-0" for="inputGender">Holiday Bonus</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <?php
                                                                            $ot_array = array('0'=>'Select Holiday Bonus','1'=>'Active','2'=>'DeActive');
                                                                            echo form_select('HolydayBonus',$ot_array,$employee_info->HolydayBonus,'class="form-control form-control-sm select2"');
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-2 dropdown-divider">
                                                                <div class="input-group">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="1" name="PFx">
                                                                        <label class="form-check-label" for="inlineCheckbox1">Provident Fund</label>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group">
                                                                            <label class="m-0" for="PFEntitledDate">PF Entitle Date</label>
                                                                            <?php echo form_select('PFEntitledDatex',[],null,'class="form-control form-control-sm select2" style="width: 100%;" id="PFEntitledDate"'); ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group">
                                                                            <label class="m-0" for="PFAccNo">PF Account No</label>
                                                                            <?php echo form_select('PFAccNox',[],null,'class="form-control form-control-sm select2" style="width: 100%;" id="PFAccNo"'); ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group">
                                                                            <label class="m-0" for="inputUnit">Select Nominee</label>
                                                                            <?php echo form_select('unit_idx',[],null,'class="form-control form-control-sm select2" style="width: 100%;" id="inputUnit"'); ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <div class="input-group">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="1" name="insurancex">
                                                                        <label class="form-check-label" for="inlineCheckbox1">Insurance</label>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group mb-1">
                                                                            <label class="m-0" for="InsuranceCompanyID">Company Name</label>
                                                                            <?php echo form_select('InsuranceCompanyIDx',[],null,'class="form-control form-control-sm select2" style="width: 100%;" id="InsuranceCompanyID"'); ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group mb-1">
                                                                            <label class="m-0" for="InsuranceAccount">Insurance Account No</label>
                                                                            <?php echo form_select('InsuranceAccountx',[],null,'class="form-control form-control-sm select2" style="width: 100%;" id="InsuranceAccount"'); ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group mb-1">
                                                                            <label class="m-0" for="inputUnit">Select Nominee</label>
                                                                            <?php echo form_select('unit_idx',[],null,'class="form-control form-control-sm select2" style="width: 100%;" id="inputUnit"'); ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="">Previous Service Record in the Company</label>
                                                                <div class="input-group">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="1" name="employee_typex">
                                                                        <label class="form-check-label" for="inlineCheckbox1">Consider in the Service length</label>
                                                                    </div>
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="inputGender">Service Length</label>
                                                                        <?php echo form_input('national_idx','text',null,'class="form-control form-control-sm form_date" id="inputNationalID" placeholder="" readonly'); ?>
                                                                    </div>
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="inputGender">Month Year</label>
                                                                        <?php echo form_input('national_idx','text',null,'class="form-control form-control-sm form_date" id="inputNationalID" placeholder="" readonly'); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="">Self Service</label>
                                                                <div class="input-group">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="1" name="employee_typex">
                                                                        <label class="form-check-label" for="inlineCheckbox1">Activate Self Service</label>
                                                                    </div>
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="inputGender">Password</label>
                                                                        <?php echo form_input('national_idx','text',null,'class="form-control form-control-sm form_date" id="inputNationalID" placeholder=""'); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputPresentAddress">Special Medical Note</label>
                                                                <?php
                                                                echo form_textarea('medical_note',$employee_info->medical_note ?? '', $attribute='class="form-control" rows="2" placeholder="Enter Address" id="inputPresentAddress"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputPresentAddress">Separation Cause</label>
                                                                <?php
                                                                echo form_textarea('separation_cause',$employee_info->separation_cause ?? '', $attribute='class="form-control" rows="2" placeholder="Enter Address" id="inputPresentAddress"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputPresentAddress">Separation Note</label>
                                                                <?php
                                                                echo form_textarea('separation_note',$employee_info->separation_note ?? '', $attribute='class="form-control" rows="2" placeholder="Enter Address" id="inputPresentAddress"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="ShiftStartDate">Separation Date</label>
                                                                <?php echo form_input('separation_date','text', date_conversion('d-m-Y', $employee_info->separation_date),'class="form-control form-control-sm ml-1 form_date" autocomplete="off" id="ShiftStartDate" placeholder=""'); ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="ShiftStartDate">Separation Effective Date</label>
                                                                <?php echo form_input('separation_effective_date','text', date_conversion('d-m-Y', $employee_info->separation_effective_date),'class="form-control form-control-sm ml-1 form_date" autocomplete="off" id="ShiftStartDate" placeholder=""'); ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="SupvisorCode">Reporting Person(Func)</label>
                                                                <?php echo form_input('SupvisorCode','text',$employee_info->SupvisorCode,'class="form-control form-control-sm ml-1" autocomplete="off"'); ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="AdminReportingPerson">Reporting Person(Admin)</label>
                                                                <?php echo form_input('AdminReportingPerson','text',$employee_info->AdminReportingPerson,'class="form-control form-control-sm ml-1" autocomplete="off"'); ?>
                                                            </div>
                                                            <!--div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="m-0" for="SupvisorCode">Reporting Person(Func)</label>
                                                                        <?php //echo form_select('SupvisorCode',[], $employee_info->SupervisonCode,'class="form-control form-control-sm select2" style="width: 100%;" id="SupvisorCode"'); ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="m-0" for="AdminReportingPerson">Reporting Person(Admin)</label>
                                                                        <?php //echo form_select('AdminReportingPerson',[], $employee_info->AdminReportingPerson,'class="form-control form-control-sm select2" style="width: 100%;" id="AdminReportingPerson"'); ?>
                                                                    </div>
                                                                </div>
                                                            </div-->
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                </div><!--/.col (right) -->
                                            </div>
                                            <!-- /.card-body -->
                                            <div class="card-footer">
                                                <?php if ($can):?>
                                                    <input type="submit" class="btn btn-info float-right" name="official_info" value="Save" />
                                                <?php endif;?>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="rule_info" role="tabpanel" aria-labelledby="rule_info-tab">
                                    <form action="<?php echo route("employee/update/".$employee_info->id);?>"  enctype="multipart/form-data" class="role" method="post">
                                        <input type="hidden" name="EmployeeCode" value="<?php echo $employee_info->EmployeeCode;?>">
                                        <div class="card">
                                            <div class="card-group pt-1"><!-- card-deck -->
                                                <!-- left column -->
                                                <div class="col-sm-6">
                                                    <!-- general form elements -->
                                                    <div class="card card-primary">
                                                        <div class="card-body-x p-1">
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="LeaveRuleID">Leave Rule</label>
                                                                <div class="input-highlight">
                                                                    <?php
                                                                    echo form_select('LeaveRuleID', $leave_rule, $employee_info->LeaveRuleID,'class="form-control form-control-sm" id="LeaveRuleID"');
                                                                    ?>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="MaternityLeaveRuleID">Maternity Leave Rule</label>
                                                                <?php
                                                                echo form_select('MaternityLeaveRuleID',[],null,'class="form-control form-control-sm ml-1" id="MaternityLeaveRuleID" disabled="true"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputPunchCardNo">Payment Policy Rule</label>
                                                                <?php
                                                                echo form_select('employee_searchx',[],null,'class="form-control form-control-sm ml-1"');
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                    <!-- /.card -->
                                                </div><!--/.col (left) -->
                                                <div class="col-sm-6">
                                                    <div class="card">
                                                        <div class="card-body-x p-1">
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputPunchCardNo">Salary Grade</label>
                                                                <?php
                                                                echo form_select('employee_searchx',[],null,'class="form-control form-control-sm ml-1"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputReligion">Attendance Rule</label>
                                                                <?php
                                                                echo form_select('employee_searchx',[],null,'class="form-control form-control-sm ml-1"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputReligion">Currency Rule</label>
                                                                <?php
                                                                echo form_select('employee_searchx',[],null,'class="form-control form-control-sm ml-1"');
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                </div><!--/.col (right) -->
                                                <!-- right column -->
                                                <div class="col-sm-12">
                                                    <!-- present address -->
                                                    <div class="card">
                                                        <div class="card-header p-1">
                                                            Shift Roaster Rule
                                                        </div>
                                                        <div class="card-body-x p-1">
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input SRA" type="checkbox" id="SRA" value="1" name="SRA" <?php echo $employee_info->SRA==1 ? 'checked': '';?>>
                                                                        <label class="form-check-label" for="SRA">Shift Roasting Applicable</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="DefaultOff">Default off</label>
                                                                        <?php
                                                                        echo form_select('DefaultOff',[], $employee_info->DefaultOff,'class="form-control form-control-sm ml-1" id="DefaultOff"');
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="form-group mb-2 shift_id_div">
                                                                        <label class="m-0" for="ShiftID">Shift Id</label>
                                                                        <div class="input-highlight">
                                                                            <?php
                                                                            echo form_select('ShiftID', $shift, $employee_info->ShiftID,'class="form-control form-control-sm" id="ShiftID"');
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group mb-2 shift_rule_div">
                                                                        <label class="m-0" for="ShiftRuleCode">Shift Rule</label>
                                                                        <?php
                                                                        echo form_select('ShiftRuleCode', $shift_rule, $employee_info->ShiftRuleCode,'class="form-control form-control-sm ml-1" id="ShiftRuleCode"');
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="ShiftStartDate">Shift Start Date</label>
                                                                        <?php echo form_input('ShiftStartDate','text', date_conversion('d-m-Y', $employee_info->ShiftStartDate),'class="form-control form-control-sm ml-1 form_date" autocomplete="off" id="ShiftStartDate" placeholder=""'); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                    <!-- /.card -->
                                                    <!-- permanent address -->
                                                    <div class="card">
                                                        <div class="card-header p-1">
                                                            Bank Information
                                                        </div>
                                                        <div class="card-body-x p-1">
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="BankID">Bank Name</label>
                                                                        <?php
                                                                        echo form_select('BankID',[], $employee_info->BankId,'class="form-control form-control-sm ml-1" id="BankID"');
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="BankAccNo">Acc. No</label>
                                                                        <?php
                                                                        echo form_select('BankAccNo',[], $employee_info->BankAccNo,'class="form-control form-control-sm ml-1" id="BankAccNo"');
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="BranchName">Branch Name</label>
                                                                        <?php
                                                                        echo form_select('BranchName',[], $employee_info->BranchName,'class="form-control form-control-sm ml-1" id="BranchName"');
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="inputReligion">Bank Ref. Emp</label>
                                                                        <?php
                                                                        echo form_select('employee_searchx',[],null,'class="form-control form-control-sm ml-1"');
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                    <!-- /.card -->
                                                </div><!--/.col (center) -->
                                            </div>
                                            <!-- /.card-body -->
                                            <div class="card-footer">
                                                <?php if ($can):?>
                                                    <input type="submit" class="btn btn-info float-right" name="rule_info" value="Save" />
                                                <?php endif;?>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="education_info" role="tabpanel" aria-labelledby="education_info-tab">
                                    <form action="<?php echo route("employee/update/".$employee_info->id);?>"  enctype="multipart/form-data" class="role" method="post">
                                        <input type="hidden" name="EmployeeCode" value="<?php echo $employee_info->EmployeeCode;?>">
                                        <div class="card">
                                            <div class="card-group pt-1"><!-- card-deck -->
                                                <!-- left column -->
                                                <div class="col-sm-12">
                                                    <!-- general form elements -->
                                                    <div class="card card-primary">
                                                        <div class="card-body-x p-1">
                                                            <table class="table">
                                                                <tbody>
                                                                    <tr>
                                                                        <!--td>&#10003;</td-->
                                                                        <th class="no_padding" style="width: 210px !important;">Institute</th>
                                                                        <th class="no_padding" style="width: 110px !important;">Board</th>
                                                                        <th class="no_padding" style="width: 90px !important;">Exam Title</th>
                                                                        <th class="no_padding" style="width: 90px !important;">Group</th>
                                                                        <th class="no_padding" style="width: 70px !important;">P. Year</th>
                                                                        <th class="no_padding" style="width: 70px !important;">Duration</th>
                                                                        <th class="no_padding" style="width: 80px !important;">Result</th>
                                                                        <th class="no_padding" style="width: 70px !important;">Certificate</th>
                                                                    </tr>
                                                                    <?php
                                                                        if(!empty($employee_education)){
                                                                            foreach($employee_education as $edu){ ?>
                                                                                <tr>
                                                                                    <!--td><button type="button" class="btn-xs btn-danger remove_row">X</button></td-->
                                                                                    <td class="no_padding"><input type="text" class="form-control form-control-sm" name="institute[]" value="<?php echo $edu['institute'];?>" autocomplete="off" ></td>
                                                                                    <td class="no_padding">
                                                                                        <input type="text" class="form-control form-control-sm" name="board[]" value="<?php echo $edu['board'];?>" autocomplete="off" >
                                                                                    </td>
                                                                                    <td class="no_padding">
                                                                                        <input type="text" class="form-control form-control-sm" name="exam_title[]" value="<?php echo $edu['exam_title'];?>" autocomplete="off">
                                                                                    </td>
                                                                                    <td class="no_padding">
                                                                                        <input type="text" class="form-control form-control-sm" name="group[]" value="<?php echo $edu['group'];?>" autocomplete="off">
                                                                                    </td>
                                                                                    <td class="no_padding"><input type="text" class="form-control form-control-sm" name="p_year[]" value="<?php echo $edu['p_year'];?>" autocomplete="off"></td>
                                                                                    <td class="no_padding">
                                                                                        <input type="text" class="form-control form-control-sm" name="duration[]" value="<?php echo $edu['duration'];?>" autocomplete="off">
                                                                                    </td>
                                                                                    <td class="no_padding"><input type="text" class="form-control form-control-sm" name="result[]" value="<?php echo $edu['result'];?>" autocomplete="off"></td>
                                                                                    <td class="no_padding"><input type="text" class="form-control form-control-sm" name="certificate[]" value="<?php echo $edu['certificate'];?>" autocomplete="off"></td>
                                                                                </tr>
                                                                            <?php }
                                                                        }
                                                                    ?>
                                                                    <tr>
                                                                        <!--td><button type="button" class="btn-xs btn-danger remove_row">X</button></td-->
                                                                        <td class="no_padding"><input type="text" class="form-control form-control-sm" name="institute[]"  autocomplete="off" ></td>
                                                                        <td class="no_padding">
                                                                            <input type="text" class="form-control form-control-sm" name="board[]" autocomplete="off" >
                                                                        </td>
                                                                        <td class="no_padding">
                                                                            <input type="text" class="form-control form-control-sm" name="exam_title[]" autocomplete="off">
                                                                        </td>
                                                                        <td class="no_padding">
                                                                            <input type="text" class="form-control form-control-sm" name="group[]" autocomplete="off">
                                                                        </td>
                                                                        <td class="no_padding"><input type="text" class="form-control form-control-sm" name="p_year[]" autocomplete="off"></td>
                                                                        <td class="no_padding">
                                                                            <input type="text" class="form-control form-control-sm" name="duration[]" autocomplete="off">
                                                                        </td>
                                                                        <td class="no_padding"><input type="text" class="form-control form-control-sm" name="result[]" autocomplete="off"></td>
                                                                        <td class="no_padding"><input type="text" class="form-control form-control-sm" name="certificate[]" autocomplete="off"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <!--td><button type="button" class="btn-xs btn-danger remove_row">X</button></td-->
                                                                        <td class="no_padding"><input type="text" class="form-control form-control-sm" name="institute[]"  autocomplete="off" ></td>
                                                                        <td class="no_padding">
                                                                            <input type="text" class="form-control form-control-sm" name="board[]" autocomplete="off" >
                                                                        </td>
                                                                        <td class="no_padding">
                                                                            <input type="text" class="form-control form-control-sm" name="exam_title[]" autocomplete="off">
                                                                        </td>
                                                                        <td class="no_padding">
                                                                            <input type="text" class="form-control form-control-sm" name="group[]" autocomplete="off">
                                                                        </td>
                                                                        <td class="no_padding"><input type="text" class="form-control form-control-sm" name="p_year[]" autocomplete="off"></td>
                                                                        <td class="no_padding">
                                                                            <input type="text" class="form-control form-control-sm" name="duration[]" autocomplete="off">
                                                                        </td>
                                                                        <td class="no_padding"><input type="text" class="form-control form-control-sm" name="result[]" autocomplete="off"></td>
                                                                        <td class="no_padding"><input type="text" class="form-control form-control-sm" name="certificate[]" autocomplete="off"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <!--td><button type="button" class="btn-xs btn-danger remove_row">X</button></td-->
                                                                        <td class="no_padding"><input type="text" class="form-control form-control-sm" name="institute[]"  autocomplete="off" ></td>
                                                                        <td class="no_padding">
                                                                            <input type="text" class="form-control form-control-sm" name="board[]" autocomplete="off" >
                                                                        </td>
                                                                        <td class="no_padding">
                                                                            <input type="text" class="form-control form-control-sm" name="exam_title[]" autocomplete="off">
                                                                        </td>
                                                                        <td class="no_padding">
                                                                            <input type="text" class="form-control form-control-sm" name="group[]" autocomplete="off">
                                                                        </td>
                                                                        <td class="no_padding"><input type="text" class="form-control form-control-sm" name="p_year[]" autocomplete="off"></td>
                                                                        <td class="no_padding">
                                                                            <input type="text" class="form-control form-control-sm" name="duration[]" autocomplete="off">
                                                                        </td>
                                                                        <td class="no_padding"><input type="text" class="form-control form-control-sm" name="result[]" autocomplete="off"></td>
                                                                        <td class="no_padding"><input type="text" class="form-control form-control-sm" name="certificate[]" autocomplete="off"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <!--td><button type="button" class="btn-xs btn-danger remove_row">X</button></td-->
                                                                        <td class="no_padding"><input type="text" class="form-control form-control-sm" name="institute[]"  autocomplete="off" ></td>
                                                                        <td class="no_padding">
                                                                            <input type="text" class="form-control form-control-sm" name="board[]" autocomplete="off" >
                                                                        </td>
                                                                        <td class="no_padding">
                                                                            <input type="text" class="form-control form-control-sm" name="exam_title[]" autocomplete="off">
                                                                        </td>
                                                                        <td class="no_padding">
                                                                            <input type="text" class="form-control form-control-sm" name="group[]" autocomplete="off">
                                                                        </td>
                                                                        <td class="no_padding"><input type="text" class="form-control form-control-sm" name="p_year[]" autocomplete="off"></td>
                                                                        <td class="no_padding">
                                                                            <input type="text" class="form-control form-control-sm" name="duration[]" autocomplete="off">
                                                                        </td>
                                                                        <td class="no_padding"><input type="text" class="form-control form-control-sm" name="result[]" autocomplete="off"></td>
                                                                        <td class="no_padding"><input type="text" class="form-control form-control-sm" name="certificate[]" autocomplete="off"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <!--td><button type="button" class="btn-xs btn-danger remove_row">X</button></td-->
                                                                        <td class="no_padding"><input type="text" class="form-control form-control-sm" name="institute[]"  autocomplete="off" ></td>
                                                                        <td class="no_padding">
                                                                            <input type="text" class="form-control form-control-sm" name="board[]" autocomplete="off" >
                                                                        </td>
                                                                        <td class="no_padding">
                                                                            <input type="text" class="form-control form-control-sm" name="exam_title[]" autocomplete="off">
                                                                        </td>
                                                                        <td class="no_padding">
                                                                            <input type="text" class="form-control form-control-sm" name="group[]" autocomplete="off">
                                                                        </td>
                                                                        <td class="no_padding"><input type="text" class="form-control form-control-sm" name="p_year[]" autocomplete="off"></td>
                                                                        <td class="no_padding">
                                                                            <input type="text" class="form-control form-control-sm" name="duration[]" autocomplete="off">
                                                                        </td>
                                                                        <td class="no_padding"><input type="text" class="form-control form-control-sm" name="result[]" autocomplete="off"></td>
                                                                        <td class="no_padding"><input type="text" class="form-control form-control-sm" name="certificate[]" autocomplete="off"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <!--td><button type="button" class="btn-xs btn-danger remove_row">X</button></td-->
                                                                        <td class="no_padding"><input type="text" class="form-control form-control-sm" name="institute[]"  autocomplete="off" ></td>
                                                                        <td class="no_padding">
                                                                            <input type="text" class="form-control form-control-sm" name="board[]" autocomplete="off" >
                                                                        </td>
                                                                        <td class="no_padding">
                                                                            <input type="text" class="form-control form-control-sm" name="exam_title[]" autocomplete="off">
                                                                        </td>
                                                                        <td class="no_padding">
                                                                            <input type="text" class="form-control form-control-sm" name="group[]" autocomplete="off">
                                                                        </td>
                                                                        <td class="no_padding"><input type="text" class="form-control form-control-sm" name="p_year[]" autocomplete="off"></td>
                                                                        <td class="no_padding">
                                                                            <input type="text" class="form-control form-control-sm" name="duration[]" autocomplete="off">
                                                                        </td>
                                                                        <td class="no_padding"><input type="text" class="form-control form-control-sm" name="result[]" autocomplete="off"></td>
                                                                        <td class="no_padding"><input type="text" class="form-control form-control-sm" name="certificate[]" autocomplete="off"></td>
                                                                    </tr>
                                                                </tbody>
                                                                <style>
                                                                    .no_padding{padding-left:0rem !important;padding-right:0rem !important;}
                                                                </style>
                                                            </table>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                    <!-- /.card -->
                                                </div><!--/.col (left) -->
                                            </div>
                                            <!-- /.card-body -->
                                            <div class="card-footer">
                                                <?php if ($can):?>
                                                    <input type="submit" class="btn btn-info float-right" name="education_info" value="Save" />
                                                <?php endif;?>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="family-info" role="tabpanel" aria-labelledby="family-info-tab">
                                    <form action="<?php echo route("employee/update/".$employee_info->id);?>"  enctype="multipart/form-data" class="role" method="post">
                                        <input type="hidden" name="EmployeeCode" value="<?php echo $employee_info->EmployeeCode;?>">
                                        <div class="card">
                                            <div class="card-group pt-1"><!-- card-deck -->
                                                <!-- left column -->
                                                <div class="col-sm-4">
                                                    <!-- general form elements -->
                                                    <div class="card card-primary">
                                                        <div class="card-body-x p-1">
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="GradeInfoID">Father's Name</label>
                                                                <?php
                                                                echo form_input('father_name','text', $family_info->father_name ?? null,'class="form-control form-control-sm " id="father_name"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="GradeInfoID">Mother's Name</label>
                                                                <?php
                                                                echo form_input('mother_name','text', $family_info->mother_name ?? null,'class="form-control form-control-sm " id="mother_name"');
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                    <!-- /.card -->
                                                </div><!--/.col (left) -->
                                                <div class="col-sm-4">
                                                    <div class="card">
                                                        <div class="card-body-x p-1">
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="GradeInfoID">Spouse Name</label>
                                                                <?php
                                                                echo form_input('spouse_name','text', $family_info->spouse_name ?? null,'class="form-control form-control-sm " id="spouse_name"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="num_of_child">Num. of child</label>
                                                                <?php
                                                                echo form_input('num_of_child','text', $family_info->num_of_child ?? null,'class="form-control form-control-sm " id="num_of_child"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="contact_number">Contact Number</label>
                                                                <?php
                                                                echo form_input('contact_number','text', $family_info->contact_number ?? null,'class="form-control form-control-sm " id="contact_number"');
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                </div><!--/.col (right) -->
                                            </div>
                                            <!-- /.card-body -->
                                            <div class="card-footer">
                                                <?php if ($can):?>
                                                    <input type="submit" class="btn btn-info float-right" name="family_info" value="Save" />
                                                <?php endif;?>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="nominee_info" role="tabpanel" aria-labelledby="nominee_info-tab">
                                    <form action="<?php echo route("employee/update/".$employee_info->id);?>"  enctype="multipart/form-data" class="role" method="post">
                                        <input type="hidden" name="EmployeeCode" value="<?php echo $employee_info->EmployeeCode;?>">
                                            <div class="card">
                                                <div class="card-group pt-1"><!-- card-deck -->
                                                    <!-- left column -->
                                                    <div class="col-sm-12">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="card">
                                                                    <div class="card-body-x p-1">
                                                                        <div class="row">
                                                                            <div class="form-inline">
                                                                                <div class="form-check ml-2">
                                                                                    <label class="form-check-label" for="PF">
                                                                                        <input class="form-check-input" type="checkbox" name="PF" value="1" <?php echo $employee_info->PF ? 'checked' : '';?> > Provident Fund
                                                                                    </label>
                                                                                </div>
                                                                                <div class="form-inline ml-4">
                                                                                    <label class="form-check-label" for="PFEntitledDate">PF Entitlement Date</label>
                                                                                    <?php echo form_input('PFEntitledDate','text',date_conversion('Y-m-d', $employee_info->PFEntitledDate),'class="form-control form-control-sm ml-1 form_date" id="PFEntitledDate" autocomplete="off"'); ?>
                                                                                </div>
                                                                                <div class="form-inline ml-4">
                                                                                    <label class="form-check-label" for="PFAccNo">PF Account No</label>
                                                                                    <?php echo form_input('PFAccNo','text', $employee_info->PFAccNo,'class="form-control form-control-sm ml-1" id="PFAccNo" placeholder=""'); ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <table class="table table-sm">
                                                                                <thead>
                                                                                <tr>
                                                                                    <th>Nominee Name</th>
                                                                                    <th>DOB</th>
                                                                                    <th>Father Name</th>
                                                                                    <th>Mother Name</th>
                                                                                    <th>Relation</th>
                                                                                    <th>Address</th>
                                                                                    <th>NID</th>
                                                                                    <th>Distribution</th>
                                                                                    <th>Picture</th>
                                                                                    <th>Add</th>
                                                                                    <th>Remove</th>
                                                                                    <th>Local</th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="NomineeName" placeholder="Enter first name" name="NomineeName[]" value="<?php echo $nominee_info[0]['NomineeName'] ?? ''; ?>"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm form_date" id="DOB" name="DOB[]" autocomplete="off" value="<?php echo isset($nominee_info[0]) ? date_conversion('d-m-Y', $nominee_info[0]['DOB']): date('d-m-Y'); ?>"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="FatherName" placeholder="Enter father name" name="FatherName[]" value="<?php echo $nominee_info[0]['FatherName'] ?? ''; ?>"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="MotherName" placeholder="Enter mother name" name="MotherName[]" value="<?php echo $nominee_info[0]['MotherName'] ?? ''; ?>"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="Relationship" placeholder="Enter Relationship" name="Relationship[]" value="<?php echo $nominee_info[0]['Relationship'] ?? ''; ?>"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="Address" placeholder="Enter Address" name="Address[]" value="<?php echo $nominee_info[0]['Address'] ?? ''; ?>"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="NationalIDCardNo" placeholder="Enter NationalIDCardNo" name="NationalIDCardNo[]" value="<?php echo $nominee_info[0]['NationalIDCardNo'] ?? ''; ?>"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="Distribution" placeholder="Enter Distribution" name="Distribution[]" value="<?php echo $nominee_info[0]['Distribution'] ?? ''; ?>"></td>
                                                                                        <td>
                                                                                            <?php
                                                                                            $path = "uploads/images/";
                                                                                            $nominee_photo = $path."no-image.jpg";
                                                                                            if(isset($nominee_info[0]['NomineeImage'])) {
                                                                                                $nominee_photo = $path."employee/".$nominee_info[0]['NomineeImage'];
                                                                                            }
                                                                                            ?>
                                                                                            <img class="nominee-img img-fluid" id="user_image" src="<?php echo asset($nominee_photo);?>" alt="Nominee picture" width="45">
                                                                                            <label for="pfNomineeImage" class="btn btn-xs btn-link">Change
                                                                                                <input style="visibility:hidden; width: 1px; height: 1px;" class="m-0 p-1" id="pfNomineeImage" type="file" name="NomineeImage[]">
                                                                                            </label>
                                                                                        </td>
                                                                                        <td>...</td>
                                                                                        <td><label>x</label></td>
                                                                                        <td>...</td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                    <!-- /.card-body -->
                                                                </div>
                                                                <!-- /.card -->
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="card">
                                                                    <div class="card-body-x p-1">
                                                                        <div class="row">
                                                                            <div class="form-inline">
                                                                                <div class="form-check ml-2">
                                                                                    <label class="form-check-label">
                                                                                        <input class="form-check-input" type="checkbox" name="IsInsuranceEntitled" value="1" <?php echo $employee_info->IsInsuranceEntitled ? 'checked' : '';?> > Insurance
                                                                                    </label>
                                                                                </div>
                                                                                <div class="form-inline ml-4">
                                                                                    <label class="form-check-label" for="inlineCheckbox1">Company Name</label>
                                                                                    <?php
                                                                                    echo form_input('InsuranceCompanyID','text', $employee_info->InsuranceCompanyID,'class="form-control form-control-sm ml-1"');
                                                                                    ?>
                                                                                </div>
                                                                                <div class="form-inline ml-4">
                                                                                    <label class="form-check-label" for="inlineCheckbox1">Insurance Account No</label>
                                                                                    <?php echo form_input('InsuranceAccount','text', $employee_info->InsuranceAccount,'class="form-control form-control-sm ml-1" id="inputNationalID" placeholder=""'); ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <table class="table table-sm table-bordered">
                                                                                <thead>
                                                                                <tr>
                                                                                    <th>Nominee Name</th>
                                                                                    <th>DOB</th>
                                                                                    <th>Father Name</th>
                                                                                    <th>Mother Name</th>
                                                                                    <th>Relation</th>
                                                                                    <th>Address</th>
                                                                                    <th>NID</th>
                                                                                    <th>Distribution</th>
                                                                                    <th>Picture</th>
                                                                                    <th>Add</th>
                                                                                    <th>Remove</th>
                                                                                    <th>Local</th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="NomineeName" placeholder="Enter first name" name="NomineeName[]" value="<?php echo $nominee_info[1]['NomineeName'] ?? ''; ?>"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm form_date" id="DOB" name="DOB[]" autocomplete="off" value="<?php echo isset($nominee_info[0]) ? date_conversion('d-m-Y', $nominee_info[1]['DOB']): date('d-m-Y');; ?>"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="FatherName" placeholder="Enter father name" name="FatherName[]" value="<?php echo $nominee_info[1]['FatherName'] ?? ''; ?>"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="MotherName" placeholder="Enter mother name" name="MotherName[]" value="<?php echo $nominee_info[1]['MotherName'] ?? ''; ?>"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="Relationship" placeholder="Enter Relationship" name="Relationship[]" value="<?php echo $nominee_info[1]['Relationship'] ?? ''; ?>"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="Address" placeholder="Enter Address" name="Address[]" value="<?php echo $nominee_info[1]['Address'] ?? ''; ?>"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="NationalIDCardNo" placeholder="Enter NationalIDCardNo" name="NationalIDCardNo[]" value="<?php echo $nominee_info[1]['NationalIDCardNo'] ?? ''; ?>"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="Distribution" placeholder="Enter Distribution" name="Distribution[]" value="<?php echo $nominee_info[1]['Distribution'] ?? ''; ?>"></td>
                                                                                        <td>
                                                                                            <?php
                                                                                            $path = "uploads/images/";
                                                                                            $nominee_photo = $path."no-image.jpg";
                                                                                            if(isset($nominee_info[1]['NomineeImage'])){
                                                                                                $nominee_photo = $path."employee/".$nominee_info[1]['NomineeImage'];
                                                                                            }
                                                                                            ?>
                                                                                            <img class="nominee-img img-fluid" id="user_image" src="<?php echo asset($nominee_photo);?>" alt="Nominee picture" width="45">
                                                                                            <label for="insuranceNomineeImage" class="btn btn-xs btn-link">Change
                                                                                                <input style="visibility:hidden; width: 1px; height: 1px;" class="m-0 p-1" id="insuranceNomineeImage" type="file" name="NomineeImage[]">
                                                                                            </label>
                                                                                        </td>
                                                                                        <td>...</td>
                                                                                        <td><label>x</label></td>
                                                                                        <td>...</td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                    <!-- /.card-body -->
                                                                </div>
                                                                <!-- /.card -->
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="card">
                                                                    <div class="card-body-x p-1">
                                                                        <div class="row">
                                                                            <div m-1>Medical Nominee Detail Information</div>
                                                                            <table class="table table-sm">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>Nominee Name</th>
                                                                                        <th>DOB</th>
                                                                                        <th>Father Name</th>
                                                                                        <th>Mother Name</th>
                                                                                        <th>Relation</th>
                                                                                        <th>Address</th>
                                                                                        <th>NID</th>
                                                                                        <th>Distribution</th>
                                                                                        <th>Picture</th>
                                                                                        <th>Add</th>
                                                                                        <th>Remove</th>
                                                                                        <th>Local</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="NomineeName" placeholder="Enter first name" name="NomineeName[]" value="<?php echo $nominee_info[2]['NomineeName'] ?? ''; ?>"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm form_date" id="DOB" name="DOB[]" autocomplete="off" value="<?php echo isset($nominee_info[0]) ? date_conversion('d-m-Y', $nominee_info[2]['DOB']): date('d-m-Y'); ?>"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="FatherName" placeholder="Enter father name" name="FatherName[]" value="<?php echo $nominee_info[2]['FatherName'] ?? ''; ?>"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="MotherName" placeholder="Enter mother name" name="MotherName[]" value="<?php echo $nominee_info[2]['MotherName'] ?? ''; ?>"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="Relationship" placeholder="Enter Relationship" name="Relationship[]" value="<?php echo $nominee_info[2]['Relationship'] ?? ''; ?>"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="Address" placeholder="Enter Address" name="Address[]" value="<?php echo $nominee_info[2]['Address'] ?? ''; ?>"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="NationalIDCardNo" placeholder="Enter NationalIDCardNo" name="NationalIDCardNo[]" value="<?php echo $nominee_info[2]['NationalIDCardNo'] ?? ''; ?>"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="Distribution" placeholder="Enter Distribution" name="Distribution[]" value="<?php echo $nominee_info[2]['Distribution'] ?? ''; ?>"></td>
                                                                                        <td>
                                                                                            <?php
                                                                                            $path = "uploads/images/";
                                                                                            $nominee_photo = $path."no-image.jpg";
                                                                                            if(isset($nominee_info[2]['NomineeImage'])){
                                                                                                $nominee_photo = $path."employee/".$nominee_info[2]['NomineeImage'];
                                                                                            }
                                                                                            ?>
                                                                                            <img class="nominee-img img-fluid" id="user_image" src="<?php echo asset($nominee_photo);?>" alt="Nominee picture" width="45">
                                                                                            <label for="medicalNomineeImage" class="btn btn-xs btn-link">Change
                                                                                                <input style="visibility:hidden; width: 1px; height: 1px;" class="m-0 p-1" id="medicalNomineeImage" type="file" name="NomineeImage[]">
                                                                                            </label>
                                                                                        </td>
                                                                                        <td>...</td>
                                                                                        <td><label>x</label></td>
                                                                                        <td>...</td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                    <!-- /.card-body -->
                                                                </div>
                                                                <!-- /.card -->
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="card">
                                                                    <div class="card-body-x p-1">
                                                                        <div m-1>Gratuity Nominee Detail Information</div>
                                                                        <div class="row">
                                                                            <table class="table table-sm">
                                                                                <thead>
                                                                                <tr>
                                                                                    <th>Nominee Name</th>
                                                                                    <th>DOB</th>
                                                                                    <th>Father Name</th>
                                                                                    <th>Mother Name</th>
                                                                                    <th>Relation</th>
                                                                                    <th>Address</th>
                                                                                    <th>NID</th>
                                                                                    <th>Distribution</th>
                                                                                    <th>Picture</th>
                                                                                    <th>Add</th>
                                                                                    <th>Remove</th>
                                                                                    <th>Local</th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="NomineeName" placeholder="Enter first name" name="NomineeName[]" value="<?php echo $nominee_info[3]['NomineeName'] ?? ''; ?>"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm form_date" id="DOB" name="DOB[]" autocomplete="off" value="<?php echo isset($nominee_info[0]) ? date_conversion('d-m-Y', $nominee_info[3]['DOB']): date('d-m-Y'); ?>"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="FatherName" placeholder="Enter father name" name="FatherName[]" value="<?php echo $nominee_info[3]['FatherName'] ?? ''; ?>"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="MotherName" placeholder="Enter mother name" name="MotherName[]" value="<?php echo $nominee_info[3]['MotherName'] ?? ''; ?>"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="Relationship" placeholder="Enter Relationship" name="Relationship[]" value="<?php echo $nominee_info[3]['Relationship'] ?? ''; ?>"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="Address" placeholder="Enter Address" name="Address[]" value="<?php echo $nominee_info[3]['Address'] ?? ''; ?>"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="NationalIDCardNo" placeholder="Enter NationalIDCardNo" name="NationalIDCardNo[]" value="<?php echo $nominee_info[3]['NationalIDCardNo'] ?? ''; ?>"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="Distribution" placeholder="Enter Distribution" name="Distribution[]" value="<?php echo $nominee_info[3]['Distribution'] ?? ''; ?>"></td>
                                                                                        <td>
                                                                                            <?php
                                                                                            $path = "uploads/images/";
                                                                                            $nominee_photo = $path."no-image.jpg";
                                                                                            if(isset($nominee_info[3]['NomineeImage'])){
                                                                                                $nominee_photo = $path."employee/".$nominee_info[3]['NomineeImage'];
                                                                                            }
                                                                                            ?>
                                                                                            <img class="nominee-img img-fluid" id="user_image" src="<?php echo asset($nominee_photo);?>" alt="Nominee picture" width="45">
                                                                                            <label for="gratuityNomineeImage" class="btn btn-xs btn-link">Change
                                                                                                <input style="visibility:hidden; width: 1px; height: 1px;" class="m-0 p-1" id="gratuityNomineeImage" type="file" name="NomineeImage[]">
                                                                                            </label>
                                                                                        </td>
                                                                                        <td>...</td>
                                                                                        <td><label>x</label></td>
                                                                                        <td>...</td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                    <!-- /.card-body -->
                                                                </div>
                                                                <!-- /.card -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /.card-body -->
                                                <div class="card-footer">
                                                    <?php if ($can):?>
                                                        <input type="submit" class="btn btn-info float-right" name="nominee_info" value="Save" />
                                                    <?php endif;?>
                                                </div>
                                            </div>
                                        </form>
                                </div>
                                <div class="tab-pane fade" id="user_defined" role="tabpanel" aria-labelledby="user_defined-tab">
                                    <form action="<?php echo route("employee/update/".$employee_info->id);?>"  enctype="multipart/form-data" class="role" method="post">
                                        <input type="hidden" name="EmployeeCode" value="<?php echo $employee_info->EmployeeCode;?>">
                                        <div class="card">
                                            <div class="card-group pt-1"><!-- card-deck -->
                                                <!-- left column -->
                                                <div class="col-sm-4">
                                                    <!-- general form elements -->
                                                    <div class="card card-primary">
                                                        <div class="card-body-x p-1">
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="GradeInfoID">Grade Info</label>
                                                                <?php
                                                                echo form_select('GradeInfoID',[1,2,3,4,5,6], $employee_info->GradeInfoID,'class="form-control form-control-sm ml-1" id="GradeInfoID"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="MaternityLeaveRuleID">Transport</label>
                                                                <?php
                                                                echo form_select('xx',[],null,'class="form-control form-control-sm ml-1" id="MaternityLeaveRuleID"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="EmployeeNatureID">Employee Nature</label>
                                                                <?php
                                                                echo form_select('EmployeeNatureID',[], $employee_info->EmployeeNatureID,'class="form-control form-control-sm ml-1" id="EmployeeNatureID"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="NomineeSpous">Nominee Spouse</label>
                                                                <?php
                                                                echo form_input('NomineeSpous','text', $employee_info->NomineeSpous,'class="form-control form-control-sm ml-1" id="NomineeSpous"');
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                    <!-- /.card -->
                                                </div><!--/.col (left) -->
                                                <div class="col-sm-4">
                                                    <div class="card">
                                                        <div class="card-body-x p-1">
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="LineInfoID">Line Info</label>
                                                                <?php
                                                                echo form_select('LineInfoID',['-- Select --','1','2','3','4','5','6'], $employee_info->LineInfoID,'class="form-control form-control-sm ml-1" id="LineInfoID"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="AttenBonusID">Attendance Bonus</label>
                                                                <?php
                                                                echo form_select('AttenBonusID',[], $employee_info->AttenBonusID,'class="form-control form-control-sm ml-1" id="AttenBonusID"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="AssignWorkID">Assign Work</label>
                                                                <?php
                                                                echo form_select('AssignWorkID',[], $employee_info->AssignWorkID,'class="form-control form-control-sm ml-1" id="AssignWorkID"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="NomineePhone">Nominee Phone</label>
                                                                <?php
                                                                echo form_input('NomineePhone','text', $employee_info->NomineePhone,'class="form-control form-control-sm ml-1" id="NomineePhone"');
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                </div><!--/.col (right) -->
                                                <div class="col-sm-4">
                                                    <div class="card">
                                                        <div class="card-body-x p-1">
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputPunchCardNo">Lunch</label>
                                                                <?php
                                                                echo form_select('employee_searchx',[],null,'class="form-control form-control-sm ml-1"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="BonusDesignationID">Bonus Designation</label>
                                                                <?php
                                                                echo form_select('BonusDesignationID',['Proportionate','Skill Emp','Unskill Emp'], $employee_info->BonusDesignationID,'class="form-control form-control-sm ml-1" id="BonusDesignationID"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="OffDayID">Offday</label>
                                                                <?php
                                                                echo form_select('OffDayID',['Friday'], $employee_info->OffDayID,'class="form-control form-control-sm ml-1" id="OffDayID"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="NomineeOcupassion">Nominee Occupation</label>
                                                                <?php
                                                                echo form_input('NomineeOcupassion','text', $employee_info->NomineeOcupassion,'class="form-control form-control-sm ml-1" id="NomineeOcupassion"');
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                </div><!--/.col (right) -->
                                            </div>
                                            <!-- /.card-body -->
                                            <div class="card-footer">
                                                <?php if ($can):?>
                                                    <input type="submit" class="btn btn-info float-right" name="user_defined" value="Save" />
                                                <?php endif;?>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<script>
    $(function () {
        let sra = $('.SRA').is(':checked');
        sra_visibility(sra);

        $('.SRA').click(function () {
            sra = $(this).is(':checked');
            sra_visibility(sra);
        });
        function sra_visibility(sra) {
            if (sra) {
                $('.shift_id_div').hide();
                $('.shift_rule_div').show();
            } else {
                $('.shift_id_div').show();
                $('.shift_rule_div').hide();
            }
        }

        let is_address_same = $('#is_address_same').is(':checked');
        same_address_visibility(is_address_same);

        $('#is_address_same').on('click', function () {
            let is_address_same = $(this).is(':checked');
            same_address_visibility(is_address_same);
        });

        function same_address_visibility(is_address_same) {
            if (is_address_same) {
                $('#sameAsPresent').hide();
            } else {
                $('#sameAsPresent').show();
            }
        }
        $('.provision_period,.training_period').change(function(){
            let join_date = $('#DOJ').val();
            let attr = $(this).attr('id');         
            join_date = join_date.split("-"); 
            var days = parseInt(join_date['0']);
            var month = parseInt(join_date['1'])+parseInt($(this).val());
            var year = parseInt(join_date['2']);
            if (attr=='inputProvisionPeriod') {
                date_calculate(days,month,year,'DOC');
            }
            if (attr=='inputTrainingPeriod') {
               date_calculate(days,month,year,'TCD');
            }            
        });
        function date_calculate(days,month,year,attr) { 
            if (month>12) {
                month = month-12;
                if (month<10) {
                    month = '0'+month;
                }
                year = year+1;
                if (days>30) {
                   if (month=='04' || month=='06' || month=='09' || month=='11') {
                        days = 30;
                    }
                    if (month=='02') {
                        if ((year%4)==0) {
                           days = 29;
                        }else{                                
                         days = 28;
                        }
                    }
                }
            }
            $('#'+attr).val(days+'-'+month+'-'+year);
        }
    });
</script>

<?php echo view('includes/virtual_keyboard',[],false); ?>