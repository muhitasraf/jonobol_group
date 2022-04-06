
        <!-- /.content-wrapper -->
        <footer class="main-footer d-print-none">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0.0
            </div>
            <strong>Copyright &copy;<?php echo date('Y') ?> HAMKO ICT.</strong> All rights
            reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
     <!-- ./wrapper -->
    <!-- jQuery moved to header-->
    <!-- Bootstrap 4 -->
    <script src="<?php echo asset('plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo asset('dist/js/adminlte.min.js'); ?>"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo asset('dist/js/demo.js'); ?>"></script>
    <!--plugins js-->
    <script src="<?php echo asset('plugins/select2/js/select2.min.js'); ?>"></script>
    <script src="<?php echo asset('plugins/toastr/toastr.min.js'); ?>"></script>
    <link href="<?php echo asset('plugins/toastr/toastr.css');?>" rel="stylesheet">
    <script src="<?php echo asset('plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js'); ?>"></script>
    <link href="<?php echo asset('plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css');?>" rel="stylesheet" media="screen">
    <script src="<?php echo asset('dist/js/custom.js'); ?>"></script>
    <script>
        $(function () {
            // search district
            $('.select2-district').select2({
                    placeholder: "Search District...",
                    //minimumInputLength: 2,
                    ajax: {
                        url: '<?php echo route("settings/search_district")?>',
                        dataType: 'json',
                        delay: 200,
                        data: function (params) {
                            return {
                                searchTerm: params.term
                            };
                        },
                        processResults: function (data) {
                            return {
                                results: data
                            };
                        },
                        cache: true
                    }
                });

            // search country
            $('.select2-country').select2({
                placeholder: "Search Country...",
                minimumInputLength: 2,
                ajax: {
                    url: '<?php echo route("settings/search_country")?>',
                    dataType: 'json',
                    delay: 200,
                    data: function (params) {
                        return {
                            searchTerm: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            });
        });
    </script>   
    <style>
        .FixedHeader {
          overflow-y: auto;
        }
        .FixedHeader thead th {
          position: sticky;
          top: 0;
        }
    </style>
    <style>
        /*pagination and delete button css*/
        a.paginate_button {
            padding: 5px;
            cursor: pointer;
        }
        form.delete_btn {
            margin-top: -22px;
            margin-left: 35px;
        }
    </style>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.23/b-1.6.5/b-html5-1.6.5/b-print-1.6.5/datatables.min.css"/>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.23/b-1.6.5/b-html5-1.6.5/b-print-1.6.5/datatables.min.js"></script>

        <script>
        $(document).ready(function() {
            //employee search
            $dtable = $('.employee-table').DataTable({
                "scrollY":        "450px",
                "scrollCollapse": true,
                "paging":         true, //false for only scrolling
                "bLengthChange": false,
                "bInfo" : false,
                "processing": true,
                "serverSide": true,
                //"ajax": '<php echo route("dtable_search_employee");?>',
                "ajax": {
                    "url": "<?php echo route("employee/dtable_search");?>",
                    "data": function (data) {
                        data.forward_url = "<?php echo route("employee/edit");?>";
                    }
                },
                "deferLoading": 57
            });
            $selected_employee = "<?php echo $employee_info->EmployeeCode ?? '';?>";
            // value populated
            $dtable.search($selected_employee).draw();
        });

        //employee leave form area
        $(document).ready(function() {
            //employee search
            $dtable = $('.employee-leave-table').DataTable({
                "scrollY":        "450px",
                "scrollCollapse": true,
                "paging":         true, //false for only scrolling
                "bLengthChange": false,
                "bInfo" : false,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?php echo route("employee/dtable_search");?>",
                    "data": function (data) {
                        data.forward_url = "<?php echo route("apply_leave/edit");?>";
                    }
                },
            });
            $dtable1 = $('.employee-absent-table').DataTable({
                "scrollY":        "450px",
                "scrollCollapse": true,
                "paging":         true, //false for only scrolling
                "bLengthChange": false,
                "bInfo" : false,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?php echo route("employee/dtable_search");?>",
                    "data": function (data) {
                        data.forward_url = "<?php echo route("absent/edit");?>";
                    }
                },
            });
            $selected_employee = "<?php echo $employee_info->EmployeeCode ?? '';?>";
            // value populated
            $dtable.search($selected_employee).draw();
        } );

        //employee leave allocation area
        $(document).ready(function() {
            //employee search
            $dtable = $('.employee-leave-allocation-table').DataTable({
                "scrollY":        "450px",
                "scrollCollapse": true,
                "paging":         true, //false for only scrolling
                "bLengthChange": false,
                "bInfo" : false,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?php echo route("employee/dtable_search");?>",
                    "data": function (data) {
                        data.forward_url = "<?php echo route("leave_allocation/show");?>";
                    }
                },
            });
            $selected_employee = "<?php echo $employee_info->EmployeeCode ?? '';?>";
            // value populated
            $dtable.search($selected_employee).draw();
        } );

        //employee leave allocation area
        $(document).ready(function() {
            //employee search
            $dtable = $('.employee-bank-table').DataTable({
                "scrollY":        "450px",
                "scrollCollapse": true,
                "paging":         true, //false for only scrolling
                "bLengthChange": false,
                "bInfo" : false,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?php echo route("employee/dtable_search");?>",
                    "data": function (data) {
                        data.forward_url = "<?php echo route("employee_bank/edit");?>";
                    }
                },
            });
            $selected_employee = "<?php echo $employee_info->EmployeeCode ?? '';?>";
            // value populated
            $dtable.search($selected_employee).draw();
        } );

        //employee out off office
        $(document).ready(function() {
            //employee search
            $dtable = $('.employee-out-off-office-table').DataTable({
                "scrollY":        "450px",
                "scrollCollapse": true,
                "paging":         true, //false for only scrolling
                "bLengthChange": false,
                "bInfo" : false,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?php echo route("employee/dtable_search");?>",
                    "data": function (data) {
                        data.forward_url = "<?php echo route("out_of_office/create");?>";
                    }
                },
            });
            $selected_employee = "<?php echo $employee_info->EmployeeCode ?? '';?>";
            // value populated
            $dtable.search($selected_employee).draw();
        } );

        //employee salary
        $(document).ready(function() {
            //employee search
            $dtable = $('.employee-dtable-salary').DataTable({
                "scrollY":        "450px",
                "scrollCollapse": true,
                "paging":         true, //false for only scrolling
                "bLengthChange": false,
                "bInfo" : false,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?php echo route("employee/dtable_search");?>",
                    "data": function (data) {
                        data.forward_url = "<?php echo route("salary/edit");?>";
                    }
                },
            });
            $selected_employee = "<?php echo $employee_info->EmployeeCode ?? '';?>";
            // value populated
            $dtable.search($selected_employee).draw();
        } );

        //employee transfer
        $(document).ready(function() {
            //employee search
            $dtable = $('.employee-dtable-transfer').DataTable({
                "scrollY":        "450px",
                "scrollCollapse": true,
                "paging":         true, //false for only scrolling
                "bLengthChange": false,
                "bInfo" : false,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?php echo route("employee/dtable_search");?>",
                    "data": function (data) {
                        data.forward_url = "<?php echo route("transfer/edit");?>";
                    }
                },
            });
            $selected_employee = "<?php echo $employee_info->EmployeeCode ?? '';?>";
            // value populated
            $dtable.search($selected_employee).draw();
        });

        // general datatable creating
        //dataTablePlaceHolder();
        function dataTablePlaceHolder($selector = '.dataTable', $object = null) {
            // creating datatable on selector
            if ($object == null) {
                $object = {
                    "paging":         false,
                    "bLengthChange": false,
                    "bInfo" : false,
                };
            }
            $($selector).DataTable($object);
        }
    </script>

    <?php include_once(View.'includes/'.'notification.php');?>
</body>
</html>
