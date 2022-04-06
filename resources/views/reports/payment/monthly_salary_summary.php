<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content pt-2 pb-0">
        <div class="container-fluid">            
                <div class="row no_print">
                    <div class="col-sm-12 col-xl-12 card card-info card-outline">
                        <div class="d-print-none"><?php echo $title; ?></div>
                    </div> 
                    <div class="col-sm-1">
                        <div class="form-group mb-1">
                            <label class="m-0" for="FromDate">Month</label>
                            <?php
                                echo form_input('Month','text',date('F'),'class="form-control form-control-sm form_month" autocomplete="off" id="Month"');
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="form-group mb-1">
                            <label class="m-0" for="ToDate">Year</label>
                            <?php
                                echo form_input('Year','text',date('Y'),'class="form-control form-control-sm form_year" autocomplete="off" id="Year"');
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <button class="btn btn-sm btn-info float-right btn-get-data mt-3">
                            <i class="fa fa-search"></i> Search
                        </button>
                    </div>                    
                </div>
                <div class="row">
                    <div class="col-md-12 col-xl-12">
                        <!-- card -->
                        <div class="card card-info-x card-outline print-employee-info d-print-block">
                            <div class="card-body-x p-3">
                                <div class="row">
                                    <button class="btn btn-info float-left btn-sm ml-3 btn-export d-print-none">
                                        <i class="fa fa-file-excel fa-x"></i>
                                    </button>
                                    <button class="btn btn-info float-left btn-sm ml-3 btn-print-landscape d-print-none">
                                        <i class="fa fa-print fa-x"></i>
                                    </button>
                                </div>
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
            let Month = $('#Month').val();
            let Year = $('#Year').val();
            let url = "<?php echo route('reports/payment/monthly_salary_summary_result'); ?>";
            $.get(url,{Month, Year },function (data) { console.log(data);
                //hide spinner after data loaded.
                $('div.spinner').hide();
                $('div.content-data').empty().append(data);
            });
        });
    });
</script>