<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content pt-2 pb-0">
        <div class="container-fluid">
            <div class="row">
                <?php include_once("employee_search.php") ?>
                <div class="col">
                    <div class="card card-info card-outline">
                        <?php if ($perm->hasPerm(['create-employee'])):?>
                            <ul class="nav nav-tabs p-1" id="custom-content-above-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="general_info-tab" data-toggle="pill" href="#general_info" role="tab" aria-controls="general_info" aria-selected="true">General Information</a>
                                </li>
                                <li class="nav-item d-none">
                                    <a class="nav-link" id="official_info" data-toggle="pill" href="#custom-content-above-profile" role="tab" aria-controls="custom-content-above-profile" aria-selected="false">Official Information</a>
                                </li>
                                <li class="nav-item d-none">
                                    <a class="nav-link" id="rule_info-tab" data-toggle="pill" href="#rule_info" role="tab" aria-controls="rule_info" aria-selected="false">Rule Information</a>
                                </li>
                                <li class="nav-item d-none">
                                    <a class="nav-link" id="user_defined-tab" data-toggle="pill" href="#user_defined" role="tab" aria-controls="user_defined" aria-selected="false">User Defined</a>
                                </li>
                                <li class="nav-item d-none">
                                    <a class="nav-link" id="nominee_info-tab" data-toggle="pill" href="#nominee_info" role="tab" aria-controls="nominee_info" aria-selected="false">Nominee Information</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="custom-content-above-tabContent">
                                <div class="tab-pane fade show active" id="general_info" role="tabpanel" aria-labelledby="general_info-tab">
                                    <form action="<?php echo route("employee/save");?>" class="role" method="post" enctype="multipart/form-data">
                                        <div class="card">
                                            <div class="card-group pt-1">
                                                <!-- left column -->
                                                <div class="col-sm-3">
                                                    <!-- general form elements -->
                                                    <div class="card card-primary">
                                                        <div class="card-body-x p-1">
                                                            <div class="form-group mb-0">
                                                                <label class="m-0" for="inputPhoto">Photo</label>
                                                                <div class="text-center">
                                                                    <img class="user-img img-fluid rounded" id="EmployeePhoto" src="<?php echo asset('uploads/images/no-image.jpg')?>" alt="User profile picture" style="width: 150px; height: 130px;">
                                                                </div>
                                                                <div class="align-text-bottom mb-0">
                                                                    <label for="user_image_files" class="btn btn-xs btn-link float-left">Add Pic</label>
                                                                    <input id="user_image_files" style="visibility:hidden;" type="file" class="mb-0" name="EmployeePhoto" accept="image/jpeg">
                                                                    <?php
                                                                    if(isset($errors['EmployeePhoto'])):?>
                                                                        <span class="text-danger"><?php echo $errors['EmployeePhoto'][0]; ?></span>
                                                                    <?php endif;?>
                                                                    <?php if(isset($errors['EmployeePhoto.error'])):?>
                                                                        <span class="text-danger"><?php echo explode('.',$errors['EmployeePhoto.error'][0])[0]; ?></span>
                                                                    <?php endif;?>
                                                                    <?php if(isset($errors['EmployeePhoto.type'])):?>
                                                                        <span class="text-danger"><?php echo explode('.',$errors['EmployeePhoto.type'][0])[0]; ?></span>
                                                                    <?php endif;?>
                                                                    <?php if(isset($errors['EmployeePhoto.size'])):?>
                                                                        <span class="text-danger"><?php echo explode('.',$errors['EmployeePhoto.size'][0])[0]; ?></span>
                                                                    <?php endif;?>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="EmployeeCode">Employee Code</label>
                                                                <?php echo form_input('EmployeeCode','text',old($inputs,'EmployeeCode'),'class="form-control form-control-sm input-highlight" id="EmployeeCode" placeholder="Employee Code"'); ?>
                                                                <?php if(isset($errors['EmployeeCode'])):?>
                                                                    <span class="text-danger"><?php echo $errors['EmployeeCode'][0]; ?></span>
                                                                <?php endif;?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputEmployeeStatus">Employee Status</label>
                                                                <?php
                                                                $status = config('constants.status');
                                                                echo form_select('EmployeeStatus',$status,null,$attribute='class="form-control form-control-sm" id="inputEmployeeStatus"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputNationalID">National ID Card No.</label>
                                                                <?php echo form_input('NationalIDCardNo','text',old($inputs,'NationalIDCardNo'),'class="form-control form-control-sm" id="inputNationalID" placeholder="Type National ID No"'); ?>
                                                                <?php if(isset($errors['name'])):?>
                                                                    <span class="text-danger"><?php echo $errors['NationalIDCardNo'][0]; ?></span>
                                                                <?php endif;?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputPunchCardNo">BadgeNumber</label>
                                                                <?php echo form_input('BadgeNumber','text',null,'class="form-control form-control-sm" id="inputPunchCardNo" placeholder="Type BadgeNumber"'); ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputPunchCardNo">Punch Card No</label>
                                                                <?php echo form_input('PunchCardNo','text',null,'class="form-control form-control-sm" id="inputPunchCardNo" placeholder="Type Punch Card No"'); ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputEmploymentNature">Employee Type</label>
                                                                <?php
                                                                $employee_type = config('constants.employee_type');
                                                                echo form_select('EmpType', $employee_type, '','class="form-control form-control-sm select2" style="width:100%;" id="inputEmploymentType"');
                                                                ?>
                                                            </div> 
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="OffDayID">Offday</label>
                                                                <?php
                                                                echo form_select('OffDay',['friday'=>'Friday','saturday'=>'Saturday','sunday'=>'Sunday','monday'=>'Monday','tuesday'=>'Tuesday','wednesday'=>'Wednesday','thursday'=>'Thursday'], NULL,'class="form-control form-control-sm ml-1" id="OffDayID"');
                                                                ?>
                                                            </div>  
                                                            <!--div class="form-group mb-2">
                                                                <label class="m-0" for="inputEmployeeType">Employee Type</label>
                                                                <div class="input-group">
                                                                    <?php
                                                                    //$employee_type = config('constants.employee_type');
                                                                    ?>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" id="inlineCheckbox1" value="1" name="EmpType" checked>
                                                                        <label class="form-check-label" for="inlineCheckbox1"><?php //echo $employee_type[1]; ?></label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" id="inlineCheckbox2" value="2" name="EmpType">
                                                                        <label class="form-check-label" for="inlineCheckbox2"><?php //echo $employee_type[2]; ?></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputEmploymentNature">Employment Nature</label>
                                                                <?php
                                                                $employment_nature = config('constants.employment_nature');
                                                                echo form_select('EmployeeNature',$employment_nature['en'],null,'class="form-control form-control-sm" id="inputEmploymentNature"');
                                                                ?>
                                                            </div-->
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputPhoto">Signature</label>
                                                                <div class="text-center">
                                                                    <img class="profile-user-img-x img-fluid rounded" id="EmployeeSignature" src="<?php echo asset('uploads/images/no-sign.jpg')?>" alt="User Signature" style="width: 150px; height: 70px;">
                                                                </div>
                                                                <div class="align-text-bottom mb-0">
                                                                    <label for="user_signature_files" class="btn btn-xs btn-link float-left">Add Pic</label>
                                                                    <input id="user_signature_files" style="visibility:hidden;" type="file" class="mb-0" name="EmployeeSignature" accept="image/jpeg">
                                                                    <?php
                                                                    if(isset($errors['EmployeeSignature'])):?>
                                                                        <span class="text-danger"><?php echo $errors['EmployeeSignature'][0]; ?></span>
                                                                    <?php endif;?>
                                                                    <?php if(isset($errors['EmployeeSignature.error'])):?>
                                                                        <span class="text-danger"><?php echo explode('.',$errors['EmployeeSignature.error'][0])[0]; ?></span>
                                                                    <?php endif;?>
                                                                    <?php if(isset($errors['EmployeeSignature.type'])):?>
                                                                        <span class="text-danger"><?php echo explode('.',$errors['EmployeeSignature.type'][0])[0]; ?></span>
                                                                    <?php endif;?>
                                                                    <?php if(isset($errors['EmployeeSignature.size'])):?>
                                                                        <span class="text-danger"><?php echo explode('.',$errors['EmployeeSignature.size'][0])[0]; ?></span>
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
                                                                <div class="row p-1">
                                                                    <div class="col-sm-3">
                                                                        <div class="form-inline mb-3">
                                                                            <label class="m-0" for="inputSaluation">Saluation</label>
                                                                            <?php $saluations = config('constants.saluation');
                                                                                echo form_select('Saluation',$saluations,null,$attribute='class="form-control form-control-sm" id="inputSaluation"'); ?>
                                                                        </div> 
                                                                    </div>
                                                                    <div class="col-sm-9">
                                                                        <div class="form-group mb-2">
                                                                            <label class="m-0" for="EmployeeName">Name</label>
                                                                            <input type="text" class="form-control form-control-sm" placeholder="Enter Name" id="EmployeeName" name="EmployeeName" value="<?php echo old($inputs,'EmployeeName');?>">
                                                                        </div>
                                                                    </div>                                                               
                                                                </div>
                                                                <div class="row p-1">                                                                    
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group mb-2">
                                                                            <label class="m-0" for="FatherName">Father Name</label>
                                                                            <input type="text" class="form-control form-control-sm" placeholder="Enter Father Name" id="FatherName" name="FatherName" value="<?php echo old($inputs,'FatherName');?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group mb-2">
                                                                            <label class="m-0" for="MotherName">Mother Name</label>
                                                                            <input type="text" class="form-control form-control-sm" placeholder="Enter Mother Name" id="MotherName" name="MotherName" value="<?php echo old($inputs,'MotherName');?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group mb-2">
                                                                            <label class="m-0" for="SpouseName">Spouse Name</label>
                                                                            <input type="text" class="form-control form-control-sm" placeholder="Enter Spouse Name" id="SpouseName" name="SpouseName" value="<?php echo old($inputs,'SpouseName');?>">
                                                                        </div>
                                                                    </div>                                                                    
                                                                </div>
                                                                <div class="card-body-x p-1">
                                                                    <!-- <table class="table table-sm">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>Saluation</th>
                                                                            <th>First Name</th>
                                                                            <th>Middle Name</th>
                                                                            <th>Last Name</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr>
                                                                            <td>
                                                                                <?php
                                                                                $saluations = config('constants.saluation');
                                                                                echo form_select('Saluation',$saluations,null,$attribute='class="form-control form-control-sm" id="inputSaluation"');
                                                                                ?>
                                                                            </td>
                                                                            <td><input type="text" class="form-control form-control-sm input-highlight" id="inputMiddleName" placeholder="Enter first name" name="FName" value="<?php echo old($inputs,'FName');?>"></td>
                                                                            <td><input type="text" class="form-control form-control-sm input-highlight" id="inputMiddleName" placeholder="Enter middle name" name="MName"></td>
                                                                            <td><input type="text" class="form-control form-control-sm input-highlight" id="inputLastName" placeholder="Enter last name" name="LName"></td>
                                                                        </tr>
                                                                        </tbody>
                                                                        <thead>
                                                                            <tr>
                                                                                <th>নামঃ</th>
                                                                                <th>পিতার নামঃ</th>
                                                                                <th>মাতার নামঃ</th>
                                                                                <th>স্বামী/স্ত্রীর নামঃ</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr>
                                                                            <td><input type="text" class="form-control form-control-sm" name="employeeName" id="employeeName" placeholder="নাম লিখুন" value=""></td>
                                                                            <td><input type="text" class="form-control form-control-sm" name="FatherName" id="FatherName" placeholder="পিতার নাম লিখুন" value=""></td>
                                                                            <td><input type="text" class="form-control form-control-sm" name="MotherName" id="MotherName" placeholder="মাতার নাম লিখুন" value=""></td>
                                                                            <td><input type="text" class="form-control form-control-sm" name="SpouseName" id="SpouseName" placeholder="স্বামী/স্ত্রীর নাম লিখুন" value=""></td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table> -->
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
                                                                        echo form_textarea('PermanentAddress',null,$attribute='class="form-control" rows="2" placeholder="Enter Address" id="inputPermanentAddress"');
                                                                        ?>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group mb-2">
                                                                                <label class="m-0" for="inputPermanentPS">P.S.</label>
                                                                                <?php echo form_input('PermanentCity','text',old($inputs,'PermanentCity'),'class="form-control form-control-sm" id="inputPermanentPS" placeholder="Police Station"'); ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group mb-2">
                                                                                <label class="m-0" for="inputPermanentPostalCode">Zip/Postal Code</label>
                                                                                <?php echo form_input('PermanentZipCode','text',null,'class="form-control form-control-sm" id="inputPermanentPostalCode" placeholder="Postal Code"'); ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group mb-2">
                                                                                <label class="m-0" for="inputDistrict">District</label>
                                                                                <?php
                                                                                echo form_select('PermanentStateId',$districts ?? [],null,$attribute='class="select2 form-control form-control-sm" id="inputDistrict"');
                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group mb-2">
                                                                                <label class="m-0" for="PermanentCountryId">Country</label> <?php
                                                                                echo form_select('PermanentCountryId',$countries ?? [],null,$attribute='class="select2-district-x form-control form-control-sm" id="PermanentCountryId"');
                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>                                                                    
                                                                </div>
                                                                <!-- /.card-body -->
                                                            </div>
                                                            <!-- /.card -->
                                                            <!-- present address -->
                                                            <div class="card">
                                                                <div class="card-header p-1">
                                                                    Present Address
                                                                    <div class="card-tools">
                                                                        <div class="form-check form-check-inline">
                                                                            <input class="form-check-input" type="checkbox" value="1" id="is_address_same" checked name="is_address_same" data-toggle="collapse" data-target="#sameAsPresent">
                                                                            <label class="form-check-label" for="is_address_same">Same as above</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="card-body-x p-1 collapse" id="sameAsPresent">
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="inputPresentAddress">Address</label>
                                                                        <?php
                                                                        echo form_textarea('PresentAddress',null,$attribute='class="form-control" rows="2" placeholder="Enter Address" id="inputPresentAddress"');
                                                                        ?>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group mb-2">
                                                                                <label class="m-0" for="inputPresentPS">P.S.</label>
                                                                                <?php echo form_input('PresentCity','text',old($inputs,'PresentCity'),'class="form-control form-control-sm" id="inputPresentPS" placeholder="Police Station"'); ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group mb-2">
                                                                                <label class="m-0" for="inputPresentPostalCode">Zip/Postal Code</label>
                                                                                <?php echo form_input('PresentZipCode','text',null,'class="form-control form-control-sm" id="inputPresentPostalCode" placeholder="Postal Code"'); ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group mb-2">
                                                                                <label class="m-0" for="inputPresentDistrict">District</label>
                                                                                <?php
                                                                                echo form_select('PresentStateId',$districts ?? [],null, $attribute='class="select2 form-control form-control-sm" id="inputPresentDistrict"');
                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group mb-2">
                                                                                <label class="m-0" for="PresentCountryId">Country</label> <?php
                                                                                echo form_select('PresentCountryId',$countries ?? [],null,$attribute='class="select2-district-x form-control form-control-sm" id="PresentCountryId"');
                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>                                                                    
                                                                </div>
                                                                <!-- /.card-body -->
                                                            </div>
                                                            <!-- /.card -->
                                                        </div><!--/.col (center) -->
                                                        <!-- right column -->
                                                        <div class="col-sm-3">
                                                            <div class="card">
                                                                <div class="card-body-x p-1">
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="DOB">Date of birth</label>
                                                                        <div class="input-group">
                                                                            <?php
                                                                            echo form_input('DOB','text',null,$attribute='class="form-control form-control-sm form_date" autocomplete="off" id="DOB" ');
                                                                            ?>
                                                                        </div>
                                                                        <!-- /input-group -->
                                                                    </div>
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="inputGender">Gender</label>
                                                                        <?php
                                                                        $gender = config('constants.gender');
                                                                        echo form_select('Gender',$gender,null,$attribute='class="form-control form-control-sm" id="inputGender"');
                                                                        ?>
                                                                    </div>
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="inputReligion">Religion</label>
                                                                        <?php
                                                                        $religion = config('constants.religion');
                                                                        echo form_select('Religion',$religion,null,$attribute='class="form-control form-control-sm" id="inputReligion"');
                                                                        ?>
                                                                    </div>
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="Nationality">Nationality</label>
                                                                        <div class="input-group">
                                                                            <?php
                                                                            echo form_input('Nationality','text','Bangladeshi', $attribute='class="form-control form-control-sm" id="Nationality"');
                                                                            ?>
                                                                        </div>
                                                                        <!-- /input-group -->
                                                                    </div>
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="inputBlood">Maritial Status</label>
                                                                        <?php
                                                                        $maritial = config('constants.maritial');
                                                                        echo form_select('MaritalStatus',$maritial,null,$attribute='class="form-control form-control-sm" id="inputMaritalStatus"');
                                                                        ?>
                                                                    </div>
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="inputBlood">Blood Group</label>
                                                                        <?php
                                                                        $blood = config('constants.blood');
                                                                        echo form_select('BloodGroup',$blood['en'],null,$attribute='class="form-control form-control-sm" id="inputBlood"');
                                                                        ?>
                                                                    </div>
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="Mobile">Mobile</label>
                                                                        <?php echo form_input('Mobile','text',null,'class="form-control form-control-sm" id="Mobile" placeholder="Mobile No"'); ?>
                                                                    </div>
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="inputEmail">Email</label>
                                                                        <?php echo form_input('EMail','email',null,'class="form-control form-control-sm" id="inputEmail" placeholder="Email"'); ?>
                                                                    </div>
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="RefAddress">Reff. Address</label>
                                                                        <input type="text" class="form-control form-control-sm" id="RefAddress" name="RefAddress">
                                                                    </div>
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="identification">Personnel Remarks</label>
                                                                        <input type="text" class="form-control form-control-sm" name="identification" id="identification" placeholder="Personal Remark">
                                                                    </div>
                                                                </div>
                                                                <!-- /.card-body -->
                                                            </div>
                                                        </div><!--/.col (right) -->
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-9">
                                                        <div class="card">
                                                            <div class="card-header p-1">
                                                               Bangla Information. 
                                                            </div>
                                                            <div class="card-body-x p-1">
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group mb-2">
                                                                            <label class="m-0" for="name_bangla">নামঃ</label>
                                                                            <input type="text" class="form-control form-control-sm" name="name_bangla" id="name_bangla" placeholder="আপনার নাম লিখুন" value="">
                                                                        </div> 
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group mb-2">
                                                                            <label class="m-0" for="fathers_name_bangla">পিতার নামঃ</label>
                                                                            <input type="text" class="form-control form-control-sm" name="fathers_name_bangla" id="fathers_name_bangla" placeholder="আপনার পিতার নাম লিখুন" value="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group mb-2">
                                                                            <label class="m-0" for="mothers_name_bangla">মাতার নামঃ</label>
                                                                            <input type="text" class="form-control form-control-sm" name="mothers_name_bangla" id="mothers_name_bangla" placeholder="আপনার মাতার নাম লিখুন" value="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group mb-2">
                                                                            <label class="m-0" for="spouse_name_bangla">স্বামী/স্ত্রীর নামঃ</label>
                                                                            <input type="text" class="form-control form-control-sm" name="spouse_name_bangla" id="spouse_name_bangla" placeholder="আপনার স্বামী/স্ত্রীর নাম লিখুন" value="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group mb-2">
                                                                            <label class="m-0" for="permanent_address_bangla">স্থায়ী ঠিকানা</label>
                                                                            <?php echo form_textarea('permanent_address_bangla',null,$attribute='class="form-control keyboard" rows="2" placeholder="স্থায়ী ঠিকানা" name="permanent_address_bangla" id="permanent_address_bangla" data-toggle="modal" data-target="#myModal" autocomplete="off"'); ?>
                                                                        </div>                                                                    
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group mb-2">
                                                                            <label class="m-0" for="present_address_bangla">বর্তমান ঠিকানা</label>
                                                                            <?php echo form_textarea('present_address_bangla',null,$attribute='class="form-control keyboard" rows="2" placeholder="বর্তমান ঠিকানা" name="present_address_bangla" id="present_address_bangla" data-toggle="modal" data-target="#myModal" autocomplete="off"'); ?>
                                                                        </div>                                                                    
                                                                    </div>                                                                    
                                                                </div>
                                                            </div>
                                                        </div>                                                        
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="card">
                                                            <div class="card-header p-1">
                                                                Other Info
                                                            </div>
                                                            <div class="card-body-x p-1">                                                                
                                                                <div class="form-group mb-2">
                                                                    <label class="m-0" for="weight">ওজন</label>
                                                                    <input type="text" class="form-control form-control-sm" name="weight" id="weight" placeholder="ওজন" value="">
                                                                </div>
                                                                <div class="form-group mb-2">
                                                                    <label class="m-0" for="height">উচ্চতা</label>
                                                                    <input type="text" class="form-control form-control-sm" name="height" id="height"  placeholder="উচ্চতা" value="">
                                                                </div>
                                                                <div class="form-group mb-2">
                                                                    <label class="m-0" for="bodyCapability">দৈহিক সক্ষমতা</label>
                                                                    <input type="text" class="form-control form-control-sm" name="bodyCapability" id="bodyCapability" placeholder="দৈহিক সক্ষমতা" value="">
                                                                </div>
                                                                <div class="form-group mb-2">
                                                                    <label class="m-0" for="noochild">সন্তান সংখ্যা</label>
                                                                    <input type="number" class="form-control form-control-sm" name="noochild" id="noochild" placeholder="সন্তান সংখ্যা">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>                                                
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="card">
                                                            <div class="card-header p-1">
                                                                আমাকে চেনে এবং জানে এরুপ দুজন ব্যক্তির নাম ও ঠিকানাঃ <br>
                                                                প্রথম।
                                                            </div>
                                                            <div class="card-body-x p-1">
                                                                <div class="row">
                                                                    <div class="col-sm-2">
                                                                        <div class="form-group mb-2">
                                                                            <label class="m-0" for="rf1name">নামঃ</label>
                                                                            <input type="text" class="form-control form-control-sm" class="select2 form-control form-control-sm" name="rf1name" id="rf1name" placeholder="নামঃ" value="">
                                                                        </div> 
                                                                    </div>
                                                                    <div class="col-sm-2">
                                                                        <div class="form-group mb-2">
                                                                            <label class="m-0" for="rf1v">গ্রাম</label>
                                                                            <input type="text" class="form-control form-control-sm" name="rf1v" id="rf1v" placeholder="গ্রাম" value="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-2">
                                                                        <div class="form-group mb-2">
                                                                            <label class="m-0" for="rf1po">ডাকঘর</label>
                                                                            <input type="text" class="form-control form-control-sm" name="rf1po" id="rf1po" placeholder="ডাকঘর" value="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-2">
                                                                        <div class="form-group mb-2">
                                                                            <label class="m-0" for="rf1ps">থানা</label>
                                                                            <input type="text" class="form-control form-control-sm" name="rf1ps" id="rf1ps" placeholder="থানা" value="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-2">
                                                                        <div class="form-group mb-2">
                                                                            <label class="m-0" for="rf1d">জেলা</label>
                                                                            <input type="text" class="form-control form-control-sm" name="rf1d" id="rf1d" placeholder="জেলা" value="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-2">
                                                                        <div class="form-group mb-2">
                                                                            <label class="m-0" for="rf1m">মোবাইল নং</label>
                                                                            <input type="text" class="form-control form-control-sm" name="rf1m" id="rf1m" placeholder="মোবাইল নং" value="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card">
                                                            <div class="card-header p-1">
                                                                দ্বিতীয়।
                                                            </div>
                                                            <div class="card-body-x p-1">
                                                                <div class="row">
                                                                    <div class="col-sm-2">
                                                                        <div class="form-group mb-2">
                                                                            <label class="m-0" for="rf2name">নামঃ</label>
                                                                            <input type="text" class="form-control form-control-sm" class="select2 form-control form-control-sm" name="rf2name" id="rf2name" placeholder="নামঃ" value="">
                                                                        </div> 
                                                                    </div>
                                                                    <div class="col-sm-2">
                                                                        <div class="form-group mb-2">
                                                                            <label class="m-0" for="rf2v">গ্রাম</label>
                                                                            <input type="text" class="form-control form-control-sm" name="rf2v" id="rf2v" placeholder="গ্রাম" value="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-2">
                                                                        <div class="form-group mb-2">
                                                                            <label class="m-0" for="rf2po">ডাকঘর</label>
                                                                            <input type="text" class="form-control form-control-sm" name="rf2po" id="rf2po" placeholder="ডাকঘর" value="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-2">
                                                                        <div class="form-group mb-2">
                                                                            <label class="m-0" for="rf2ps">থানা</label>
                                                                            <input type="text" class="form-control form-control-sm" name="rf2ps" id="rf2ps" placeholder="থানা" value="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-2">
                                                                        <div class="form-group mb-2">
                                                                            <label class="m-0" for="rf2d">জেলা</label>
                                                                            <input type="text" class="form-control form-control-sm" name="rf2d" id="rf2d" placeholder="জেলা" value="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-2">
                                                                        <div class="form-group mb-2">
                                                                            <label class="m-0" for="rf2m">মোবাইল নং</label>
                                                                            <input type="text" class="form-control form-control-sm" name="rf2m" id="rf2m" placeholder="মোবাইল নং" value="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.card-body -->
                                            <div class="card-footer">
                                                <input type="submit" class="btn btn-info float-right" name="employee_basic_info" value="Submit" />
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="custom-content-above-profile" role="tabpanel" aria-labelledby="official_info">
                                    <form action="<?php echo route("employee/save");?>" class="role" method="post">
                                        <div class="card">
                                            <div class="card-group pt-1"><!-- card-deck -->
                                                <!-- left column -->
                                                <div class="col-sm-4">
                                                    <!-- general form elements -->
                                                    <div class="card card-primary">
                                                        <div class="card-body-x p-1">
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="PositionID">Position</label>
                                                                <?php echo form_select('PositionID',[],null,'class="form-control form-control-sm select2" style="width: 100%;" id="PositionID"'); ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputTemplate">Template ID</label>
                                                                <?php
                                                                $templates = [];
                                                                echo form_select('template_id',$templates,null,'class="form-control form-control-sm" id="inputTemplate"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="UnitID">Unit</label>
                                                                <?php echo form_select('UnitID',$blood,null,'class="form-control form-control-sm select2" style="width: 100%;" id="UnitID"'); ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="DepartmentID">Department</label>
                                                                <?php
                                                                echo form_select('DepartmentID',[],null,'class="form-control form-control-sm" id="DepartmentID"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="SectionID">Section</label>
                                                                <?php
                                                                echo form_select('SectionID',[],null,'class="form-control form-control-sm" id="SectionID"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="StaffCategoryID">Staff Category</label>
                                                                <?php
                                                                echo form_select('StaffCategoryID',[],null,'class="form-control form-control-sm" id="StaffCategoryID"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputSkillCategory">Skill Category</label>
                                                                <?php
                                                                echo form_select('employment_nature',[],null,'class="form-control form-control-sm" id="SkillCategory"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="DOJ">Date of Joining</label>
                                                                <?php echo form_input('DOJ','text',null,'class="form-control form-control-sm form_date" id="DOJ" autocomplete="off" readonly'); ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputPosition">Govt. Designation</label>
                                                                <?php echo form_select('position_id',[],null,'class="form-control form-control-sm select2" style="width: 100%;" id="inputPosition"'); ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputPosition">Logistic Resource</label>
                                                                <?php echo form_select('position_id',[],null,'class="form-control form-control-sm select2" style="width: 100%;" id="inputPosition"'); ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputPosition">Skill Set</label>
                                                                <?php echo form_select('position_id',[],null,'class="form-control form-control-sm select2" style="width: 100%;" id="inputPosition"'); ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="DOS">DOS</label>
                                                                <?php echo form_input('DOS','text',null,'class="form-control form-control-sm form_date" id="DOS" autocomplete="off" readonly'); ?>
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
                                                                <?php echo form_input('PositionID','text',null,'class="form-control form-control-sm" id="inputNationalID" placeholder=""'); ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="DesignationID">Given Designation</label>
                                                                <?php echo form_select('DesignationID',[],null,'class="form-control form-control-sm select2" style="width: 100%;" id="DesignationID"'); ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="DivisionID">Division</label>
                                                                <?php echo form_select('DivisionID',[],null,'class="form-control form-control-sm select2" style="width: 100%;" id="DivisionID"'); ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="Designation">Designation</label>
                                                                <?php echo form_select('Designation',[],null,'class="form-control form-control-sm select2" style="width: 100%;" id="Designation"'); ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="SubSectionID">Sub Section</label>
                                                                <?php echo form_select('SubSectionID',[],null,'class="form-control form-control-sm select2" style="width: 100%;" id="SubSectionID"'); ?>
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
                                                                <?php echo form_input('national_idx','text',null,'class="form-control form-control-sm form_datex" id="inputNationalID" placeholder=""'); ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputUnit">Review Dates</label>
                                                                <?php echo form_select('unit_id',[],null,'class="form-control  form-control-sm select2" style="width: 100%;" id="inputUnit"'); ?>
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
                                                        <span class="bg-info">Entitlement</span>
                                                        <div class="card-body-x p-1">
                                                            <div class="form-group mb-2">
                                                                <div class="input-group">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox22" value="1" name="OT">
                                                                        <label class="form-check-label" for="inlineCheckbox1">Overtime</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <?php echo form_select('OTEntitledDate',[],null,'class="form-control form-control-sm select2" style="width: 100%;" id="inputUnit"'); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox20" value="1" name="OffDayOT">
                                                                    <label class="form-check-label" for="inlineCheckbox1">Offday overtime</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="1" name="HolydayBonus">
                                                                    <label class="form-check-label" for="inlineCheckbox1">Holiday Bonus</label>
                                                                </div>
                                                            </div>

                                                            <div class="form-group mb-2 dropdown-divider">
                                                                <div class="input-group">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox4" value="1" name="PFx">
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
                                                                            <?php echo form_select('unit_id',[],null,'class="form-control form-control-sm select2" style="width: 100%;" id="inputUnit"'); ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <div class="input-group">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox5" value="1" name="employee_type">
                                                                        <label class="form-check-label" for="inlineCheckbox1">Insurance</label>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group mb-1">
                                                                            <label class="m-0" for="InsuranceCompanyID">Company Name</label>
                                                                            <?php echo form_select('InsuranceCompanyID',[],null,'class="form-control form-control-sm select2" style="width: 100%;" id="InsuranceCompanyID"'); ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group mb-1">
                                                                            <label class="m-0" for="InsuranceAccount">Insurance Account No</label>
                                                                            <?php echo form_select('InsuranceAccount',[],null,'class="form-control form-control-sm select2" style="width: 100%;" id="InsuranceAccount"'); ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group mb-1">
                                                                            <label class="m-0" for="inputUnit">Select Nominee</label>
                                                                            <?php echo form_select('unit_id',[],null,'class="form-control form-control-sm select2" style="width: 100%;" id="inputUnit"'); ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-2 dropdown-divider">
                                                                <div class="input-group">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox6" value="1" name="employee_type">
                                                                        <label class="form-check-label" for="inlineCheckbox1">Consider Service Length</label>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label class="m-0" for="inputUnit">Service Length</label>
                                                                            <?php echo form_select('unit_id',[],null,'class="form-control form-control-sm select2" style="width: 100%;" id="inputUnit"'); ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label class="m-0" for="inputUnit">Month/Year</label>
                                                                            <?php echo form_select('unit_id',[],null,'class="form-control form-control-sm select2" style="width: 100%;" id="inputUnit"'); ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="">Self Service</label>
                                                                <div class="input-group">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox7" value="1" name="employee_type">
                                                                        <label class="form-check-label" for="inlineCheckbox1">Activate Self Service</label>
                                                                    </div>
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="inputGender">Password</label>
                                                                        <?php echo form_input('national_idx','text',null,'class="form-control form-control-sm form_datex" id="inputNationalID" placeholder=""'); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputPresentAddress">Special Medical Note</label>
                                                                <?php
                                                                echo form_textarea('present_address',null,$attribute='class="form-control" rows="2" placeholder="Enter Address" id="inputPresentAddress"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputPresentAddress">Separation Cause</label>
                                                                <?php
                                                                echo form_textarea('present_address',null,$attribute='class="form-control" rows="2" placeholder="Enter Address" id="inputPresentAddress"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputPresentAddress">Separation Note</label>
                                                                <?php
                                                                echo form_textarea('present_address',null,$attribute='class="form-control" rows="2" placeholder="Enter Address" id="inputPresentAddress"');
                                                                ?>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="m-0" for="SupvisorCode">Reporting Person(Func)</label>
                                                                        <?php echo form_select('SupvisorCode',[],null,'class="form-control form-control-sm select2" style="width: 100%;" id="SupvisorCode"'); ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="m-0" for="AdminReportingPerson">Reporting Person(Admin)</label>
                                                                        <?php echo form_select('AdminReportingPerson',[],null,'class="form-control form-control-sm select2" style="width: 100%;" id="AdminReportingPerson"'); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                </div><!--/.col (right) -->
                                            </div>
                                            <!-- /.card-body -->
                                            <div class="card-footer">
                                                <input type="submit" class="btn btn-info float-right" name="employee_official_info" value="Submit" />
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="rule_info" role="tabpanel" aria-labelledby="rule_info-tab">
                                    <form action="<?php echo route("employee/save");?>" class="role" method="post" name="employee_rule_info">
                                        <div class="card">
                                            <div class="card-group pt-1"><!-- card-deck -->
                                                <!-- left column -->
                                                <div class="col-sm-6">
                                                    <!-- general form elements -->
                                                    <div class="card card-primary">
                                                        <div class="card-body-x p-1">
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="LeaveRuleID">Leave Rule</label>
                                                                <?php
                                                                echo form_select('LeaveRuleID',[],null,'class="form-control form-control-sm ml-1" id="LeaveRuleID"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="MaternityLeaveRuleID">Maternity Leave Rule</label>
                                                                <?php
                                                                echo form_select('MaternityLeaveRuleID',[],null,'class="form-control form-control-sm ml-1" id="MaternityLeaveRule" disabled="true"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputPunchCardNo">Payment Policy Rule</label>
                                                                <?php
                                                                echo form_select('employee_search',[],null,'class="form-control form-control-sm ml-1"');
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
                                                                echo form_select('employee_search',[],null,'class="form-control form-control-sm ml-1"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputReligion">Attendance Rule</label>
                                                                <?php
                                                                echo form_select('employee_search',[],null,'class="form-control form-control-sm ml-1"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="inputReligion">Currency Rule</label>
                                                                <?php
                                                                echo form_select('employee_search',[],null,'class="form-control form-control-sm ml-1"');
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
                                                                        <input class="form-check-input" type="radio" id="sameAsPresent2" value="1" name="SRA">
                                                                        <label class="form-check-label" for="sameAsPresent">Shift Roasting Applicable</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="ShiftRuleCode">Default off</label>
                                                                        <?php
                                                                        echo form_select('ShiftRuleCode',[],null,'class="form-control form-control-sm ml-1" id="ShiftRuleCode"');
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="ShiftID">Shift Rule</label>
                                                                        <?php
                                                                        echo form_select('ShiftID',[],null,'class="form-control form-control-sm ml-1" id="ShiftID"');
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="ShiftStartDate">Start Date</label>
                                                                        <?php echo form_input('ShiftStartDate','text',null,'class="form-control form-control-sm ml-1 form_date" id="ShiftStartDate"  autocomplete="off" readonly'); ?>
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
                                                                        echo form_select('BankID',[],null,'class="form-control form-control-sm ml-1" id="BankID"');
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="BankAccNo">Acc. No</label>
                                                                        <?php
                                                                        echo form_select('BankAccNo',[],null,'class="form-control form-control-sm ml-1" id="BankAccNo"');
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="BranchName">Branch Name</label>
                                                                        <?php
                                                                        echo form_select('BranchName',[],null,'class="form-control form-control-sm ml-1" id="BranchName"');
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group mb-2">
                                                                        <label class="m-0" for="inputReligion">Bank Ref. Emp</label>
                                                                        <?php
                                                                        echo form_select('employee_search',[],null,'class="form-control form-control-sm ml-1"');
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
                                                <input type="submit" class="btn btn-info float-right" name="employee_rule_info" value="Submit" />
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="user_defined" role="tabpanel" aria-labelledby="user_defined-tab">
                                    <form action="<?php echo route("employee/add");?>"  enctype="multipart/form-data" class="role" method="post">
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
                                                                echo form_select('GradeInfoID',[],null,'class="form-control form-control-sm ml-1" id="GradeInfoID"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="MaternityLeaveRuleID">Transport</label>
                                                                <?php
                                                                echo form_select('xx',[],null,'class="form-control form-control-sm ml-1" id="Transport"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="EmployeeNatureID">Employee Nature</label>
                                                                <?php
                                                                echo form_select('EmployeeNatureID',[],null,'class="form-control form-control-sm ml-1" id="EmployeeNatureID"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="NomineeSpous">Nominee Spouse</label>
                                                                <?php
                                                                echo form_input('NomineeSpous','text',null,'class="form-control form-control-sm ml-1" id="NomineeSpous"');
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
                                                                echo form_select('LineInfoID',[],null,'class="form-control form-control-sm ml-1" id="LineInfoID"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="AttenBonusID">Attendance Bonus</label>
                                                                <?php
                                                                echo form_select('AttenBonusID',[],null,'class="form-control form-control-sm ml-1" id="AttenBonusID"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="AssignWorkID">Assign Work</label>
                                                                <?php
                                                                echo form_select('AssignWorkID',[],null,'class="form-control form-control-sm ml-1" id="AssignWorkID"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="NomineePhone">Nominee Phone</label>
                                                                <?php
                                                                echo form_input('NomineePhone','text',null,'class="form-control form-control-sm ml-1" id="NomineePhone"');
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
                                                                echo form_select('BonusDesignationID',[],null,'class="form-control form-control-sm ml-1" id="BonusDesignationID"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="OffDayID">Offday</label>
                                                                <?php
                                                                echo form_select('OffDayID',[],null,'class="form-control form-control-sm ml-1" id="OffDayID"');
                                                                ?>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label class="m-0" for="NomineeOcupassion">Nominee Occupation</label>
                                                                <?php
                                                                echo form_input('NomineeOcupassion','text',null,'class="form-control form-control-sm ml-1" id="NomineeOcupassion"');
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                </div><!--/.col (right) -->
                                            </div>
                                            <!-- /.card-body -->
                                            <div class="card-footer">
                                                <input type="submit" class="btn btn-info float-right" name="user_defined" value="Submit" />
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="nominee_info" role="tabpanel" aria-labelledby="nominee_info-tab">
                                    <form action="<?php echo route("employee/save");?>" class="role" method="post" name="employee_nominee_info">
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
                                                                                        <input class="form-check-input" type="checkbox" name="PF"> Provident Fund
                                                                                    </label>
                                                                                </div>
                                                                                <div class="form-inline ml-4">
                                                                                    <label class="form-check-label" for="PFEntitledDate">PF Entitlement Date</label>
                                                                                    <?php echo form_input('PFEntitledDate','text',null,'class="form-control form-control-sm ml-1 form_date" id="PFEntitledDate2" autocomplete="off" readonly'); ?>
                                                                                </div>
                                                                                <div class="form-inline ml-4">
                                                                                    <label class="form-check-label" for="PFAccNo">PF Account No</label>
                                                                                    <?php echo form_input('PFAccNo','text',null,'class="form-control form-control-sm ml-1" id="PFAccNo2" placeholder=""'); ?>
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
                                                                                        <td><input type="text" class="form-control form-control-sm" id="NomineeNamePF" placeholder="Enter first name" name="NomineeName[]"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm form_date" id="DOBPF" name="DOB[]" autocomplete="off" readonly></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="FatherNamePF" placeholder="Enter father name" name="FatherName[]"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="MotherNamePF" placeholder="Enter mother name" name="MotherName[]"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="RelationshipPF" placeholder="Enter Relationship" name="Relationship[]"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="AddressPF" placeholder="Enter Address" name="Address[]"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="NationalIDCardNoPF" placeholder="Enter NationalIDCardNo" name="NationalIDCardNo[]"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="DistributionPF" placeholder="Enter Distribution" name="Distribution[]"></td>
                                                                                        <td>
                                                                                            <label for="NomineeImage" class="btn btn-xs btn-link">Pic
                                                                                                <input style="visibility:hidden; width: 1px; height: 1px;" class="m-0 p-1" id="NomineeImagePF" type="file" name="NomineeImage[]">
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
                                                                                        <input class="form-check-input" type="checkbox" name="remember"> Insurance
                                                                                    </label>
                                                                                </div>
                                                                                <div class="form-inline ml-4">
                                                                                    <label class="form-check-label" for="inlineCheckbox1">Company Name</label>
                                                                                    <?php
                                                                                    echo form_select('employee_search',[],null,'class="form-control form-control-sm ml-1"');
                                                                                    ?>
                                                                                </div>
                                                                                <div class="form-inline ml-4">
                                                                                    <label class="form-check-label" for="inlineCheckbox1">Insurance Account No</label>
                                                                                    <?php echo form_input('national_idx','text',null,'class="form-control form-control-sm ml-1 form_datex" id="inputNationalID" placeholder=""'); ?>
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
                                                                                        <td><input type="text" class="form-control form-control-sm" id="NomineeNameInsurance" placeholder="Enter first name" name="NomineeName[]"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm form_date" id="DOBInsurance" name="DOB[]" autocomplete="off" readonly></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="FatherNameInsurance" placeholder="Enter father name" name="FatherName[]"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="MotherNameInsurance" placeholder="Enter mother name" name="MotherName[]"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="RelationshipInsurance" placeholder="Enter Relationship" name="Relationship[]"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="AddressInsurance" placeholder="Enter Address" name="Address[]"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="NationalIDCardNoInsurance" placeholder="Enter NationalIDCardNo" name="NationalIDCardNo[]"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="DistributionInsurance" placeholder="Enter Distribution" name="Distribution[]"></td>
                                                                                        <td>
                                                                                            <label for="NomineeImage" class="btn btn-xs btn-link">Pic
                                                                                                <input style="visibility:hidden; width: 1px; height: 1px;" class="m-0 p-1" id="NomineeImageInsurance" type="file" name="NomineeImage[]">
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
                                                                                        <td><input type="text" class="form-control form-control-sm" id="NomineeNameMedical" placeholder="Enter first name" name="NomineeName[]"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm form_date" id="DOBMedical" name="DOB[]" autocomplete="off" readonly></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="FatherNameMedical" placeholder="Enter father name" name="FatherName[]"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="MotherNameMedical" placeholder="Enter mother name" name="MotherName[]"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="Relationship" placeholder="Enter Relationship" name="Relationship[]"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="AddressMedical" placeholder="Enter Address" name="Address[]"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="NationalIDCardNoMedical" placeholder="Enter NationalIDCardNo" name="NationalIDCardNo[]"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="DistributionMedical" placeholder="Enter Distribution" name="Distribution[]"></td>
                                                                                        <td>
                                                                                            <label for="NomineeImage" class="btn btn-xs btn-link">Pic
                                                                                                <input style="visibility:hidden; width: 1px; height: 1px;" class="m-0 p-1" id="NomineeImageMedical" type="file" name="NomineeImage[]">
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
                                                                                        <td><input type="text" class="form-control form-control-sm" id="NomineeNameGratuity" placeholder="Enter first name" name="NomineeName[]"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm form_date" id="DOBGratuity" name="DOB[]" autocomplete="off" readonly></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="FatherNameGratuity" placeholder="Enter father name" name="FatherName[]"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="MotherNameGratuity" placeholder="Enter mother name" name="MotherName[]"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="RelationshipGratuity" placeholder="Enter Relationship" name="Relationship[]"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="AddressGratuity" placeholder="Enter Address" name="Address[]"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="NationalIDCardNoGratuity" placeholder="Enter NationalIDCardNo" name="NationalIDCardNo[]"></td>
                                                                                        <td><input type="text" class="form-control form-control-sm" id="DistributionGratuity" placeholder="Enter Distribution" name="Distribution[]"></td>
                                                                                        <td>
                                                                                            <label for="NomineeImage" class="btn btn-xs btn-link">Pic
                                                                                                <input style="visibility:hidden; width: 1px; height: 1px;" class="m-0 p-1" id="NomineeImageGratuity" type="file" name="NomineeImage[]">
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
                                                    <input type="submit" class="btn btn-info float-right" name="employee_nominee_info" value="Submit" <?php echo $perm->hasPerm('create-employee') ? "":"disabled"; ?> />
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

<?php echo view('includes/virtual_keyboard',[],false); ?>