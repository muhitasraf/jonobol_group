
    <div class="container-fluid salary-sheet-full">
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
        <?php $pf_index=0;$advance_index=0;$loan_index=0;?>
        <div class="row mt-1">
            <div class="col-sm-12 salary-sheet">
                <table class="table table-striped table-bordered table-sm dataTable FixedHeader" cellspacing="0" width="100%">
                    <thead>                        
                        <tr class="table-success">
                            <th>S.L<?php $serial=1;?></th>
                            <th>Section<?php $serial+=1;?></th>
                            <th>Staff<?php $serial+=1;?></th>
                            <th>Worker<?php $serial+=1;?></th>
                            <th>Total<br>Manpower<?php $serial+=1;?></th>
                            <th>Staff Salary<?php $serial+=1;?></th>
                            <th>Worker Salary<?php $serial+=1;?></th>
                            <th>Total Salary<?php $serial+=1;?></th>
                            <th>Staff OT<?php $serial+=1;?></th>
                            <th>Worker OT<?php $serial+=1;?></th>
                            <th>Total OT<?php $serial+=1;?></th>
                            <th>Attendance Bonus<?php $serial+=1;?></th>   <!-- new add -->
                            <th>Area<?php $serial+=1;?></th>  <!-- new add -->
                            <!-- <th>Payable Salary?php $serial+=1;?></th> -->
                            <th>Total Payable Salary<?php $serial+=1;?></th>
                            <th>Deduction<?php $serial+=1;?></th>   <!-- new add -->
                            <th>Net Payable Salary<?php $serial+=1;?></th>  <!-- new add -->
                            <th>Remarks<?php $serial+=1;?></th>
                        </tr>                                    
                    </thead>
                    <tbody>
                        <?php
                        if(!empty($salary_summary_info)){ 
                            $i=0;
                            foreach($salary_summary_info as $key => $row){
                                $absenteeism = round($row['Absenteeism']);
                                $pf = ($row['PF']);
                                $advance = ($row['ADVANCE']);
                                $stamp =  $row['STAMP'];
                                $tax = ($row['TAX']);
                                $food = ($row['FOOD']);
                                $gross = ($row['orgGROSS']);
                                $ARREAR = ($row['ARREAR']);
                                $deduction = round($absenteeism+$pf+$advance+$stamp+$tax+$food);
                                $attendanceBonus =  ($row['ATTENDANCEBONUS']);
                                $payable = round($gross - $deduction);
                                $OTAmount = round($row['OT']);
                                $totalPayable = ($payable+$OTAmount+$attendanceBonus+$ARREAR);
                                ?>
                                <tr>
                                    <td><?php echo ++$i; ?></td>
                                    <td><?php echo $row['section']; ?></td>
                                    <td class="emp_staff_manpower"><?php echo $row['Staff']; ?></td>
                                    <td class="emp_worker_manpower"><?php echo $row['Worker']; ?></td>
                                    <td class="emp_total_manpower"><?php echo $row['Staff']+$row['Worker']; ?></td>
                                    <td class="emp_staff_salary"><?php echo $row['StaffGross']; ?></td>
                                    <td class="emp_worker_salary"><?php echo $row['WorkerGross']; ?></td>
                                    <td class="emp_total_salary"><?php echo $row['StaffGross']+$row['WorkerGross']; ?></td>
                                    <td class="emp_staff_ot"><?php echo $row['StaffOT']; ?></td>
                                    <td class="emp_worker_ot"><?php echo $row['WorkerOT']; ?></td>
                                    <td class="emp_total_ot"><?php echo $row['StaffOT']+$row['WorkerOT']; ?></td>
                                    <td class="emp_attendance_bonus"><?php echo $row['ATTENDANCEBONUS']; ?></td> <!-- new add -->
                                    <td class="emp_area"><?php echo $row['ARREAR']; ?></td> <!-- new add -->
                                    <!-- <td class="emp_payable">?php echo $row['StaffGross']+$row['WorkerGross']+$row['StaffOT']+$row['WorkerOT']; ?></td> -->
                                    <!-- <td class="emp_total_payable">?php echo $row['StaffGross']+$row['WorkerGross']+$row['StaffOT']+$row['WorkerOT']; ?></td> -->
                                    <td class="emp_total_payable"><?php echo  $totalPayable = round($totalPayable, 2); ?></td>
                                    <td class="emp_deduction"><?php 
                                    echo $deduction = round($absenteeism+$pf+$advance+$stamp+$tax+$food); 
                                    ?></td> <!-- new add -->
                                    <td class="emp_net_payable_salary"><?php echo ($deduction = $totalPayable-round($absenteeism+$pf+$advance+$stamp+$tax+$food)); ?></td> <!-- new add -->
                                    <td></td>
                                </tr>
                                <?php                             
                            }
                            ?>
                            <tr class="table-info">
                                <td style="font-weight:bold;" colspan="2">Total</td>
                                <td class="tot_staff" style="font-weight:bold;"></td>
                                <td class="tot_worker" style="font-weight:bold;"></td>
                                <td class="tot_emp" style="font-weight:bold;"></td>
                                <td class="tot_staff_salary" style="font-weight:bold;"></td>
                                <td class="tot_worker_salary" style="font-weight:bold;"></td>
                                <td class="tot_salary" style="font-weight:bold;"></td>
                                <td class="tot_staff_ot" style="font-weight:bold;"></td>
                                <td class="tot_worker_ot" style="font-weight:bold;"></td>
                                <td class="tot_ot" style="font-weight:bold;"></td>
                                <td class="attendance_bonus" style="font-weight:bold;"></td> <!-- add this -->
                                <td class="area" style="font-weight:bold;"></td> <!-- add this -->
                                <!-- <td class="tot_payable" style="font-weight:bold;"></td> -->
                                <td class="tot_payable_salary" style="font-weight:bold;"></td>
                                <td class="deduction" style="font-weight:bold;"></td>
                                <td class="net_payable_salary" style="font-weight:bold;"></td>
                                <td style="font-weight:bold;"></td>
                            </tr>
                            <?php
                        }
                        ?>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        body {
            width: max-content !important;
        }
        .col-sm-3 {
            -ms-flex: 0 0 25%;
            flex: 0 0 25%;
            max-width: 6% !important;
        }
        .page-header {
            margin-left: 15% !important;
        }
        @media print {
            body {
                /*zoom:100%; /*or whatever percentage you need, play around with this number */
                width: auto !important;
                margin: 0 5px 0 0 !important;
                font-size: 8px !important;
                /*height: auto !important;*/
            }
            .page-header {
                margin-left: 25% !important;
                
            }
            .no_print{display:none;}
        }
    </style>
    <script>
        $(function() {
            total_calculate('emp_staff_manpower','tot_staff');        
            total_calculate('emp_worker_manpower','tot_worker');        
            total_calculate('emp_total_manpower','tot_emp');        
            total_calculate('emp_staff_salary','tot_staff_salary');        
            total_calculate('emp_worker_salary','tot_worker_salary');        
            total_calculate('emp_total_salary','tot_salary');        
            total_calculate('emp_staff_ot','tot_staff_ot');        
            total_calculate('emp_worker_ot','tot_worker_ot');        
            total_calculate('emp_total_ot','tot_ot');        
            total_calculate('emp_attendance_bonus','attendance_bonus');    //add this    
            total_calculate('emp_area','area');    //add this    
            // total_calculate('emp_payable','tot_payable');
            total_calculate('emp_total_payable','tot_payable_salary');         
            total_calculate('emp_deduction','deduction'); //add this     
            total_calculate('emp_net_payable_salary','net_payable_salary'); //add this     
           
            function total_calculate(parm,tot_parm){
                var sum_total = 0;
                $('.'+parm).each(function(){
                    if($(this).text() !='' && !isNaN($(this).text())) {
                         sum_total = parseFloat($(this).text())+sum_total; 
                    }
                });
                $('.'+tot_parm).html(sum_total);
            }
            
            
            let pageHeader = $('.page-heading').html();
            // Append a caption to the table before the DataTables initialisation
            //$('.dataTable').append('<caption style="caption-side: bottom">Printed at 15.20pm.</caption>');
            
            $("table tbody tr").hover(function() {
                $(this).addClass("table-danger");
            }, function() {
                $(this).removeClass("table-danger");
            });
            $("table tbody tr").click(function(){
                $(this).toggleClass("table-warning");
            });
            /*$('.dataTable').dataTable( {
                fixedHeader: true,
                paging: false,
            } );*/
             
            $('.dataTable').DataTable( {
                dom: 'Bfrtip',
                //fixedHeader: true,
                paging: false,
                buttons: [
                    {
                        extend: 'csv',
                        messageTop: 'Monthly Attendance',
                        exportOptions: {
                            trim: false,
                            stripHtml: false,
                            format: {
                                body: function ( data, row, column, node ) {
                                    console.log('data:'+data);
                                    data = data.replace(/(<([^>]+)>)/ig, '|');
                                    //console.log('data tag remove:'+data);
                                    data = data.replace(/\s{2,}/g,'');
                                    //console.log('data replace sp by null :'+data);
                                    data = data.replace(/\|{2,}/g,', ');
                                    //console.log('data replace | by comma :'+data);
                                    data = data.replace(/^\|/,'');
                                    //console.log('data replace first | by null :'+data);
                                    data = data.replace(/\|$/,'');
                                    ///console.log('data replace last | by null :'+data);
                                    data = data.replace(/\|/ig,',  ');
                                    ///console.log('data replace | by ,  :'+data);
                                    data = data.replace(/(,|-)$/,'');
                                    //console.log('data replace | by null  :'+data);
                                    return data;
                                }
                            }
                        }
                    },
                    {
                        extend: 'excel',
                        messageTop: RemoveHTMLTags(pageHeader),
                        orientation: 'landscape',
                        exportOptions: {
                            trim: false,
                            stripHtml: false,
                            format: {
                                body: function ( data, row, column, node ) {
                                    console.log('data:'+data);
                                    data = data.replace(/(<([^>]+)>)/ig, '|');
                                    //console.log('data tag remove:'+data);
                                    data = data.replace(/\s{2,}/g,'');
                                    //console.log('data replace sp by null :'+data);
                                    data = data.replace(/\|{2,}/g,', ');
                                    //console.log('data replace | by comma :'+data);
                                    data = data.replace(/^\|/,'');
                                    //console.log('data replace first | by null :'+data);
                                    data = data.replace(/\|$/,'');
                                    ///console.log('data replace last | by null :'+data);
                                    data = data.replace(/\|/ig,',  ');
                                    ///console.log('data replace | by ,  :'+data);
                                    data = data.replace(/(,|-)$/,'');
                                    //console.log('data replace | by null  :'+data);
                                    return data;
                                }
                            }
                        }
                    },
                    {
                        extend: 'pdf',
                        messageTop: 'Monthly Attendence',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        customize: function(doc) {
                            doc.defaultStyle.fontSize = 5; 
                         }
                    },                   
            
                    {
                        extend: 'print',
                        messageTop: pageHeader,
                        action: function ( e, dt, node, config ) {
                            removeDataTable();
                            printLandscape();
                            window.print();
                        }
                    },
                ],
                paging: false,
                bInfo: false
            });
        });
    </script>


