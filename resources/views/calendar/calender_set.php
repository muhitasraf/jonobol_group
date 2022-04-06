<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content pt-2 pb-0">
        <div class="container-fluid">
            <div class=""><h5><?php echo $title; ?></h5></div>
            <form action="<?php echo route("attendance/save_device_data");?>" class="role" method="post" enctype="multipart/form-data">
                <div class="row">
                    <!-- left column -->
                    <div class="col-sm-4 d-print-none">                          
                        <!-- card -->
                        <div class="card card-info card-outline">
                            <div class="card-header p-1">
                                <span class="card-title-x text text-center"><h6>Calender Set For Attendence Data.</h6></span>
                            </div>
                            <div class="card-body-x p-1">
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label class="m-0" for="ShiftRuleCode">Emp.Code</label>
                                        <?php echo form_input('EmployeeCode','text',null,'class="form-control form-control-sm EmployeeCode" placeholder="Emp. Code" autocomplete="off" '); ?>
                                        <?php if(isset($errors['EmployeeCode'])):?>
                                            <span class="text-danger"><?php echo $errors['EmployeeCode'][0]; ?></span>
                                        <?php endif;?>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label class="m-0" for="ShiftRuleCode">From Date</label>
                                        <?php echo form_input('FromDate','text',date('d-m-Y'),'class="form-control form-control-sm form_date FromDate" autocomplete="off" readonly required'); ?>
                                        <?php if(isset($errors['FromDate'])):?>
                                            <span class="text-danger"><?php echo $errors['FromDate'][0]; ?></span>
                                        <?php endif;?>
                                    </div>

                                    <div class="form-group col-sm-4">
                                        <label class="m-0" for="ShiftRuleCode">To Date</label>
                                        <?php echo form_input('ToDate','text',date('d-m-Y'),'class="form-control form-control-sm form_date ToDate" autocomplete="off" readonly required'); ?>
                                        <?php if(isset($errors['ToDate'])):?>
                                            <span class="text-danger"><?php echo $errors['ToDate'][0]; ?></span>
                                        <?php endif;?>
                                    </div>
                                </div>
                                <div class="card-body-x p-3 scroll-div"><h2 style="font-weight:bold;color:green;"  class="calender_set"></h2>
                                </div>
                            </div>
                            <div class="card-footer">
                                <input type="button" class="btn btn-sm btn-info float-right btn-get-data" value="Calender Set" />
                            </div>
                        </div>
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

<script>
    $(function () {
        $('.btn-get-data').on('click',function () {
            $('div.spinner').show();
            let FormDate = $('.FromDate').val();
            let ToDate = $('.ToDate').val();
            let EmployeeCode = $('.EmployeeCode').val();
            let calender_set = {
                'FormDate' : FormDate,
                'ToDate': ToDate,
                'EmployeeCode' : EmployeeCode
            };
            let url = "<?php echo route('calender/calender_set_save'); ?>";
            $.post(url,calender_set,function (data) {
                console.log(data);
                $('div.spinner').hide();
                $('.calender_set').html(data);
            });
        });  
    });
</script>