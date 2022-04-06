<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content pt-2 pb-0">
        <div class="container-fluid">
            <div class="d-print-none"><?php echo $title; ?></div>
                <div class="row">
                    <!-- left column -->
                    <div class="col-sm-3 d-print-none">
                        <!-- card -->
                        <div class="card card-info card-outline">
                            <div class="card-body-x p-2">
                                <div class="form-group">
                                    <label class="m-0" for="Department">Department</label>
                                    <?php echo form_select('Department',$department,null,'class="form-control form-control-sm Department" id="Department" placeholder="Department"'); ?>
                                </div>
                                <div class="form-group">
                                    <label class="m-0" for="Designation">Designation</label>
                                    <?php echo form_select('Designation',$designation,null,'class="form-control form-control-sm Designation" id="Designation" placeholder="Designation"'); ?>
                                </div>
                                <div class="form-group">
                                    <label class="m-0" for="Section">Section</label>
                                    <?php echo form_select('Section',$section,null,'class="form-control form-control-sm Section" id="Section" placeholder="Section"'); ?>
                                  </div>
                                <div class="form-group">
                                    <label class="m-0" for="StaffCategory">Staff Category</label>
                                    <?php echo form_select('StaffCategory',$staff_category,null,'class="form-control form-control-sm StaffCategory" id="StaffCategory" placeholder="Staff Category"'); ?>
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
                                <button class="btn btn-sm btn-info float-right btn-get-data">
                                    <i class="fa fa-search"></i> Search
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <!-- card -->
                        <div class="card card-info-x card-outline print-employee-info d-print-block">
                            <div class="card-body-x p-3">
<!--                                <button class="btn btn-info float-right btn-sm ml-3 btn-print d-print-none">-->
<!--                                    <i class="fa fa-print fa-2x"></i>-->
<!--                                </button>-->
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

            let Department = $('.Department').val();
            let Designation = $('.Designation').val();
            let Section = $('.Section').val();
            let StaffCategory = $('.StaffCategory').val();
            let FromDate = $('#FromDate').val();
            let ToDate = $('#ToDate').val();
            let url = "<?php echo route('reports/employee/separated_result'); ?>";
            $.get(url,{Department:Department, Designation:Designation, Section:Section, FromDate:FromDate, ToDate:ToDate, StaffCategory:StaffCategory},function (data) {
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