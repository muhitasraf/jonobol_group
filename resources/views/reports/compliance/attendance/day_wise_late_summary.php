<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content pt-2 pb-0">
        <div class="container-fluid">
            <div class="d-print-none"><?php echo $title; ?></div>
                <div class="row">
                    <!-- left column -->
                    <div class="col-sm-3 d-print-none">
                        <form action="">
                            <!-- card -->
                            <div class="card card-info card-outline">
                                <div class="card-body-x p-1">
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <div class="form-group mb-1">
                                                <label class="m-0" for="ToDate">On Date</label>
                                                <?php
                                                echo form_input('OnDate','text',date('d-m-Y'),'class="form-control form-control-sm form_date OnDate" autocomplete="off" id="OnDate" readonly');
                                                ?>
                                            </div>
                                            <div class="form-group p-1 mb-1">
                                                <label class="m-0" for="Department">Department</label>
                                                <?php echo form_select('Department',$department,null,'class="form-control form-control-sm Department" id="Department" placeholder="Department"'); ?>
                                            </div>
                                            <div class="form-group p-1 mb-1">
                                                <label class="m-0" for="Designation">Designation</label>
                                                <?php echo form_select('Designation',$designation,null,'class="form-control form-control-sm Designation" id="Designation" placeholder="Designation"'); ?>
                                            </div>
                                            <div class="form-group p-1 mb-1">
                                                <label class="m-0" for="Section">Section</label>
                                                <?php echo form_select('Section',$section,null,'class="form-control form-control-sm Section" id="Section" placeholder="Section"'); ?>
                                            </div>
                                            <div class="form-group p-1 mb-1">
                                                <label class="m-0" for="StaffCategory">Staff Category</label>
                                                <?php echo form_select('StaffCategory',$staff_category,null,'class="form-control form-control-sm StaffCategory" id="StaffCategory" placeholder="Staff Category"'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-sm btn-info float-right btn-get-data" type="button">
                                        <i class="fa fa-search"></i> Search
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-9">
                        <!-- card -->
                        <div class="card card-info-x card-outline print-employee-info d-print-block">
                            <div class="card-body-x p-3">
                                <a class="btn btn-info float-right btn-sm ml-3 btn-export d-print-none" href="<?php echo route('reports/employee/export_as_excel'); ?>">
                                    <i class="fa fa-file-excel fa-x"></i>
                                </a>
                                <button class="btn btn-info float-right btn-sm ml-3 btn-print d-print-none">
                                    <i class="fa fa-print fa-x"></i>
                                </button>
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
            $('div.spinner').show();

            let form = $('form').serialize();
            let url = "<?php echo route('reports/attendance/day_wise_late_summary_result'); ?>";
            $.get(url,form,function (data) {
                //hide spinner after data loaded.
                $('div.spinner').hide();
                $('div.content-data').empty().append(data);
            });
        });

        $('.btn-print').on('click',function () {
            window.print();
        });
    });
</script>