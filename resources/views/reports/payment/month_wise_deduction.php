<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content pt-2 pb-0">
        <div class="container-fluid">            
                <div class="row">
                    <div class="col-sm-12 col-xl-12 card card-info card-outline">
                        <div class="d-print-none"><?php echo $title; ?></div>
                    </div>
                    <div class="col-sm-2 col-xl-2 d-print-none">
                        <div class="form-group">
                            <label class="m-0" for="Department">Employee Code</label>
                            <?php echo form_input('EmployeeCode','text',null,'class="form-control form-control-sm EmployeeCode" id="EmployeeCode" placeholder="Employee Code"'); ?>
                        </div>
                    </div>
                    <div class="col-sm-2 col-xl-2 d-print-none">
                        <div class="form-group">
                            <label class="m-0" for="Department">Department</label>
                            <?php echo form_select('Department',$department,null,'class="form-control form-control-sm Department" id="Department" placeholder="Department"'); ?>
                        </div>
                    </div>
                    <div class="col-sm-2 col-xl-2 d-print-none">
                        <div class="form-group">
                            <label class="m-0" for="Designation">Designation</label>
                            <?php echo form_select('Designation',$designation,null,'class="form-control form-control-sm Designation" id="Designation" placeholder="Designation"'); ?>
                        </div>
                    </div>
                    <div class="col-sm-2 col-xl-2 d-print-none">
                        <div class="form-group">
                            <label class="m-0" for="Section">Section</label>
                            <?php echo form_select('Section',$section,null,'class="form-control form-control-sm Section" id="Section" placeholder="Section"'); ?>
                        </div>
                    </div>
                    <div class="col-sm-2 col-xl-2 d-print-none">
                        <div class="form-group p-1 mb-1">
                            <label class="m-0" for="StaffCategory">Staff Category</label>
                            <?php echo form_select('StaffCategory',$staff_category,null,'class="form-control form-control-sm StaffCategory" id="StaffCategory" placeholder="Staff Category"'); ?>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="form-group mb-1">
                            <label class="m-0" for="FromDate">Month</label>
                            <select class="form-control form-control-sm" id="Month" name="Month">
                                <option value="0">All</option>
                                <option value="01">Jan</option>
                                <option value="02">Feb</option>
                                <option value="03">Mar</option>
                                <option value="04">Apr</option>
                                <option value="05">May</option>
                                <option value="06">Jun</option>
                                <option value="07">Jul</option>
                                <option value="08">Aug</option>
                                <option value="09">Sep</option>
                                <option value="10">Oct</option>
                                <option value="11">Nov</option>
                                <option value="12">Dec</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="form-group mb-1">
                            <label class="m-0" for="ToDate">Year</label>
                            <select class="form-control form-control-sm" id="Year" name="Year">
                                <option value="0">All</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                                <option value="2027">2027</option>
                                <option value="2028">2028</option>
                                <option value="2029">2029</option>
                                <option value="2030">2030</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group mb-1">
                            <label class="m-0" for="">Display In Report</label>
                            <div class="form-check-inline">
                                <div class="form-check-inline ml-3">
                                    <input class="form-check-input pf" type="checkbox" id="pf" value="1" name="pf" checked>
                                    <label class="form-check-label" for="pf">PF</label>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-check-input advance" type="checkbox" id="advance" value="1" name="advance" checked>
                                    <label class="form-check-label" for="advance">Advance</label>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-check-input loan" type="checkbox" id="loan" value="1" name="loan" checked>
                                    <label class="form-check-label" for="loan">Loan</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <button class="btn btn-sm btn-info float-right btn-get-data">
                            <i class="fa fa-search"></i> Search
                        </button>
                    </div>
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
            //let deductionType =('.deductionType').val();
            let EmployeeCode = $('.EmployeeCode').val();
            let Department = $('.Department').val();
            let Designation = $('.Designation').val();
            let Section = $('.Section').val();
            let StaffCategory = $('.StaffCategory').val();
            let Month = $('#Month').val();
            let Year = $('#Year').val();

            let pf = $('#pf:checked').val();
            let advance = $('#advance:checked').val();
            let loan = $('#loan:checked').val();

            let url = "<?php echo route('reports/payment/month_wise_deduction_result'); ?>";
            $.get(url,{EmployeeCode,Department, Designation, Section,StaffCategory, Month, Year, pf, advance, loan },function (data) {
                console.log(data);
                //hide spinner after data loaded.
                $('div.spinner').hide();
                $('div.content-data').empty().append(data);
            });
        });
    });
</script>