
    <div class="container-fluid salary-sheet-full mt-5">
        <div class="row page-heading">
            <div class="col-sm-12 col-xl-12">
                <div class="row page-header">
                    <div class="col-sm-4 col-xl-5">
                        <?php echo view('includes/company_logo',compact('company_info'),false); ?>
                    </div>
                    <div class="col-sm-8 col-xl-7">
                        <h4><?php echo $company_info->name?></h4>
                        <p><?php echo $company_info->address?></p>
                        <p class="font-weight-bold"><?php echo $title?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-sm-12 salary-sheet">
                <table class="table table-striped table-bordered dataTable FixedHeader">
                    <thead>                        
                        <tr class="table-success">
                            <th>S.L</th>
                            <th>Employee Code</th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Department</th>
                            <th>Section</th>
                            <th>Staff Category</th>
                            <th>WorkDate</th>
                            <th>InTime</th>
                            <th>OutTime</th>
                            <th>Remarks</th>
                            <th>Updated Date</th>
                            <!--th>Updated By</th-->
                        </tr>                                    
                    </thead>
                    <tbody>
                        <?php
                        if(!empty($manual_attn)){ $i=0;
                            foreach($manual_attn as $key => $row){  
                                ?>
                                <tr>
                                    <td><?php echo ++$i; ?></td>
                                    <td><?php echo $row['EmployeeCode']; ?></td>
                                    <td><?php echo $row['EmployeeName']; ?></td>
                                    <td><?php echo $row['Designation']; ?></td>
                                    <td><?php echo $row['Department']; ?></td>
                                    <td><?php echo $row['Section']; ?></td>
                                    <td><?php echo $row['StaffCategory']; ?></td>
                                    <td><?php echo $row['WorkDate']; ?></td>
                                    <td><?php echo $row['InTime']; ?></td>
                                    <td><?php echo $row['OutTime']; ?></td>
                                    <td><?php echo $row['Remarks']; ?></td>
                                    <td><?php echo $row['DateAdded']; ?></td>
                                    <!--td><?php //echo $row['AddedBy']; ?></td-->
                                </tr>
                                <?php                            
                            }
                        }
                        ?>                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body {
                /*zoom:100%; /*or whatever percentage you need, play around with this number */
                width: auto !important;
                margin: 0 5px 0 0 !important;
                font-size: 8px !important;
                /*height: auto !important;*/
            }
            .page-header {
                margin-left: 30% !important;
            }
            table.table-borderless tr,table.table-borderless td {
                border: none;
                margin: auto;
            }
            table {page-break-after:always}
        }
    </style>
    <script>
        $('.btn-export').on('click',function () {
            let uri = 'data:application/vnd.ms-excel;base64,';
            let template = $('div.salary-sheet-full').html();
            window.location.href = uri + btoa(template);
        });
        $("table tr").hover(function() {
            $(this).addClass("table-danger");
        }, function() {
            $(this).removeClass("table-danger");
        });
        $("table tbody tr").click(function(){
            $(this).toggleClass("table-warning");
        });   
        
        $(function() {
            let pageHeader = $('.page-heading').html();
            // not work forr colspan
            $('.dataTable').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        messageTop: 'Moanual attendance from'
                    },
                    {
                        extend: 'pdf',
                        messageTop: 'Moanual attendance from'
                    },
                    {
                        extend: 'print',
                        messageTop: pageHeader,
                        title: ''
                    },
                ],
                paging: false,
                bInfo: false
            });
        });
    </script>


