<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content pt-2 pb-0">
        <div class="container-fluid">
            <h5 class=""><?php echo $title; ?></h5>
            <form action="<?php echo route("company/update/".$company->id);?>" class="role" enctype="multipart/form-data" method="post">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-10">
                        <!-- card -->
                        <div class="card card-info card-outline">
                            <!--                            <div class="card-header p-1">-->
                            <!--                                <span class="card-title">User Information</span>-->
                            <!--                            </div>-->
                            <div class="card-body">
                                <div class="form-group mb-2">
                                    <label class="m-0" for="CompanyName">Company Name</label> <span class="text-danger font-weight-bold">*</span>
                                    <?php echo form_input('name','text',$company->name,'class="form-control form-control-sm" id="CompanyName" placeholder="Type name" required'); ?>
                                    <?php if(isset($errors['name'])):?>
                                        <span class="text-danger"><?php echo $errors['name'][0]; ?></span>
                                    <?php endif;?>
                                </div>
                                <div class="form-group mb-2">
                                    <label class="m-0" for="address">Address</label> <span class="text-danger font-weight-bold">*</span>
                                    <textarea name="address" class="form-control form-control-sm" rows="2" id="address" placeholder="Type address" required><?php echo $company->address; ?></textarea>
                                    <?php if(isset($errors['address'])):?>
                                        <span class="text-danger"><?php echo $errors['address'][0]; ?></span>
                                    <?php endif;?>
                                </div>
                                <div class="form-group mb-2">
                                    <label class="m-0" for="Logo">Logo</label> <span class="text-danger font-weight-bold">*</span>
                                    <?php
                                        $path = "uploads/images/";
                                        $logo = $path."company/".$company->logo;
                                        if(!$company->logo){
                                            $logo = $path."no-image.jpg";
                                        }
                                    ?>
                                    <img src="<?php echo asset($logo); ?>" alt="Logo" width="75">
                                    <?php
                                        echo form_input('logo','file',null,$attribute='class="form-control" placeholder="Attach logo" id="logo" accept="image/jpg"');
                                    ?>
                                    <?php
                                    if(isset($errors['logo'])):?>
                                        <span class="text-danger"><?php echo $errors['logo'][0]; ?></span>
                                    <?php endif;?>
                                    <?php if(isset($errors['logo.error'])):?>
                                        <span class="text-danger"><?php echo explode('.',$errors['logo.error'][0])[0]; ?></span>
                                    <?php endif;?>
                                    <?php if(isset($errors['logo.type'])):?>
                                        <span class="text-danger"><?php echo explode('.',$errors['logo.type'][0])[0]; ?></span>
                                    <?php endif;?>
                                    <?php if(isset($errors['logo.size'])):?>
                                        <span class="text-danger"><?php echo explode('.',$errors['logo.size'][0])[0]; ?></span>
                                    <?php endif;?>
                                </div>
                                <div class="form-group mb-2">
                                    <label class="m-0" for="local_name">Company Local Name</label>
                                    <?php echo form_input('local_name','text',$company->local_name,'class="form-control form-control-sm keyboard" id="local_name" placeholder="Type local name" autocomplete="off" data-toggle="modal" data-target="#myModal"'); ?>
                                    <?php if(isset($errors['local_name'])):?>
                                        <span class="text-danger"><?php echo $errors['local_name'][0]; ?></span>
                                    <?php endif;?>
                                </div>
                                <div class="form-group mb-2">
                                    <label class="m-0" for="local_address">Local Address</label>
                                    <textarea name="local_address" class="form-control form-control-sm keyboard" rows="2" id="local_address" placeholder="Type local address" autocomplete="off" data-toggle="modal" data-target="#myModal"><?php echo $company->local_address; ?></textarea>
                                    <?php if(isset($errors['local_address'])):?>
                                        <span class="text-danger"><?php echo $errors['local_address'][0]; ?></span>
                                    <?php endif;?>
                                </div>
                                <div class="form-group mb-2">
                                    <label class="m-0" for="user_name">Owner Name</label>
                                    <?php echo form_input('owner_name','text',$company->owner_name,'class="form-control form-control-sm" id="owner_name" placeholder="Type owner name"'); ?>
                                    <?php if(isset($errors['owner_name'])):?>
                                        <span class="text-danger"><?php echo $errors['owner_name'][0]; ?></span>
                                    <?php endif;?>
                                </div>
                                <div class="form-group mb-2">
                                    <label class="m-0" for="owner_signature">Owner Signature</label>
                                    <?php
                                    $path = "uploads/images/";
                                    $signature = $path."company/".$company->owner_signature;
                                    if(!$company->owner_signature){
                                        $signature = $path."no-image.jpg";
                                    }
                                    ?>
                                    <img src="<?php echo asset($signature); ?>" alt="Logo" width="75">
                                    <?php
                                        echo form_input('owner_signature','file',old('owner_signature'),$attribute='class="form-control" placeholder="Attach owner signature" id="owner_signature" accept="image/jpg"');
                                    ?>
                                    <?php
                                    if(isset($errors['owner_signature'])):?>
                                        <span class="text-danger"><?php echo $errors['owner_signature'][0]; ?></span>
                                    <?php endif;?>
                                    <?php if(isset($errors['owner_signature.error'])):?>
                                        <span class="text-danger"><?php echo explode('.',$errors['owner_signature.error'][0])[0]; ?></span>
                                    <?php endif;?>
                                    <?php if(isset($errors['owner_signature.type'])):?>
                                        <span class="text-danger"><?php echo explode('.',$errors['owner_signature.type'][0])[0]; ?></span>
                                    <?php endif;?>
                                    <?php if(isset($errors['owner_signature.size'])):?>
                                        <span class="text-danger"><?php echo explode('.',$errors['owner_signature.size'][0])[0]; ?></span>
                                    <?php endif;?>
                                </div>
                                <div class="form-group mb-2">
                                    <label class="m-0" for="user_name">Office Phone</label>
                                    <?php echo form_input('office_phone','text',$company->office_phone,'class="form-control form-control-sm" id="office_phone" placeholder="Type office phone"'); ?>
                                </div>
                                <div class="form-group mb-2">
                                    <label class="m-0" for="user_name">Web Address</label>
                                    <?php echo form_input('web_address','text',$company->web_address,'class="form-control form-control-sm" id="web_address" placeholder="Type web address"'); ?>
                                </div>
                                <div class="form-group mb-2">
                                    <label class="m-0" for="from_date">Leave Year</label>
                                </div>
                                <div class="form-group mb-2">
                                    <label class="m-0" for="from_date">Start Date</label> <span class="text-danger font-weight-bold">*</span>
                                    <?php
                                    echo form_input('from_date','text',date_conversion('d-m-Y',$company->from_date) ,$attribute='class="form-control-sm form_date mr-2" placeholder="Leave Year Start Date" id="from_date" autocomplete="off" readonly');
                                    ?>
                                    <?php if(isset($errors['from_date'])):?>
                                        <span class="text-danger"><?php echo $errors['from_date'][0]; ?></span>
                                    <?php endif;?>
                                    <label class="m-0" for="from_date">End Date</label> <span class="text-danger font-weight-bold">*</span>
                                    <?php
                                    echo form_input('to_date','text',date_conversion('d-m-Y',$company->to_date),$attribute='class="form-control-sm form_date" placeholder="Leave Year End Date" id="to_date" autocomplete="off" readonly');
                                    ?>
                                    <?php if(isset($errors['to_date'])):?>
                                        <span class="text-danger"><?php echo $errors['to_date'][0]; ?></span>
                                    <?php endif;?>
                                </div>
                                <div class="form-group mb-2 row">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input is_active" id="IsActive" value="1" name="IsActive" <?php echo $company->is_active==1 ? 'checked':'';?> >
                                            <label class="form-check-label mb-0" for="IsActive">Is active</label>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <input type="submit" class="btn btn-info float-right" value="Submit" />
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->
                </div>
                <!-- /.card-body -->
                <!-- /.row -->
            </form>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<?php echo view('includes/virtual_keyboard',[],false); ?>

