<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content pt-2 pb-0">
        <div class="container-fluid">
            <div class="d-print-none"><?php echo $title; ?></div>
                <div class="row">
                    <!-- left column -->
                    <div class="col-sm-3 d-print-none">
                        <form action="" class="role" method="get" name="employee_search">
                            <!-- card -->
                            <div class="card card-info card-outline">
                                <div class="card-body-x p-2">
                                    <div class="form-group">
                                        <label class="m-0" for="Department">Department</label>
                                        <?php echo form_select('Department',$department,null,'class="form-control form-control-sm Department" id="Department" placeholder="Department"'); ?>
                                    </div>                                    
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group mb-1">
                                                <label class="m-0" for="FromDate">From Date</label>
                                                <?php
                                                echo form_input('FromDate','text',null,'class="form-control form-control-sm form_date" autocomplete="off" id="FromDate" readonly');
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group mb-1">
                                                <label class="m-0" for="ToDate">To Date</label>
                                                <?php
                                                echo form_input('ToDate','text',null,'class="form-control form-control-sm form_date" autocomplete="off" id="ToDate" readonly');
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <input type="button" class="btn btn-sm btn-info float-right btn-get-data" value="Search" />
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-9">
                        <!-- card -->
                        <div class="card card-info-x card-outline print-employee-info d-print-block">
                            <div class="card-body-x p-3">
<!--                                <div class="row">-->
<!--                                    <div class="col-sm-3 offset-sm-9">-->
<!--                                        <a class="btn btn-info float-right btn-sm ml-3 btn-export d-print-none" href="--><?php //echo route('reports/employee/export_as_excel'); ?><!--">-->
<!--                                            <i class="fa fa-file-excel fa-x"></i>-->
<!--                                        </a>-->
<!--                                        <button class="btn btn-info float-right btn-sm ml-3 btn-print d-print-none">-->
<!--                                            <i class="fa fa-print fa-x"></i>-->
<!--                                        </button>-->
<!--                                    </div>-->
<!--                                </div>-->
                                <div class="row content-data">
                                </div>
                                <div class="row d-print-none">
                                    <div class="text-center p-3 spinner" style="display: none;">
                                        <strong>Loading ...</strong>
                                        <div class="spinner-border text-info" role="status"> </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->
                </div>
                <!-- /.card-body -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<script>
    $(function () {
        $('.btn-get-data').on('click',function () {
            //show spinner after btn click at process startup.
            //console.log("Hellow Checking");           
            $('div.spinner').show();
           
            let url = "<?php echo route('reports/leave/department_leave_result'); ?>";
            let form = $('form').serialize();
           
            $.get(url,form,function (data) {
                //hide spinner after data loaded.
                $('div.spinner').hide();
                $('div.content-data').empty().append(data);
            });
        });
    });
</script>