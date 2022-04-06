<div class="col-sm-3">
    <div class="card">
        <div class="card-header d-none">
            <div class="card-tools-x row">
                <div class="input-group">
                    <?php
                    echo form_select('EmployeeCode',[$employee_select2 ?? ''],$employee_info->id ?? '','class="employee-select2-url form-control" id="EmployeeNatureID" style="width: 100%";"');
                    ?>
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-2">
            <table class="table table-bordered-x table-sm table-responsive table-hover display employee-table" id="employee-table" class="display" style="width:100%">
                <thead>
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Punch Card</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    <!-- /.card -->
</div>
<!-- /.col -->