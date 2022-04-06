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
                            <div class="card-body-x p-1">
                                <div class="form-group">
                                    <label class="m-0" for="EmployeeCode">Employee Code</label>
                                    <?php echo form_input('EmployeeCode','text',null,'class="form-control form-control-sm EmployeeCode" id="EmployeeCode" placeholder="Type Employee Code" required'); ?>
                                </div>
                                <div class="form-group mb-0">
                                    <label class="m-0" for="inputEmployeeType">Local Type</label>
                                    <div class="input-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input local_type" type="radio" id="local_type_en" value="en" name="local_type" checked>
                                            <label class="form-check-label" for="local_type_en">En</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input local_type" type="radio" id="local_type_bn" value="bn" name="local_type">
                                            <label class="form-check-label" for="local_type_bn">Bn</label>
                                        </div>
                                    </div>
                                    <!-- /input-group -->
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
                                <button class="btn btn-info float-right btn-sm ml-3 btn-print d-print-none">
                                    <i class="fa fa-print fa-2x"></i>
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

            let EmployeeCode = $('.EmployeeCode').val();
            let LocalType = $('.local_type:checked').val();

            let url = "<?php echo route('reports/employee/id_card_result'); ?>";
            $.get(url,{EmployeeCode, LocalType},function (data) {
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