
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
                <table class="table table-striped table-bordered dataTable">
                    <thead>                        
                        <tr class="table-success">
                            <th>S.L<?php $serial=1;?></th>
                                <th>Employee Code<?php $serial+=1;?></th>
                                <th>Name<?php $serial+=1;?></th>
                                <th>Designation<?php $serial+=1;?></th>
                                <th>Department<?php $serial+=1;?></th>
                                <th>Section<?php $serial+=1;?></th>
                                <th>Staff Category<?php $serial+=1;?></th>
                                <th>Month<?php $serial+=1;?></th>
                                <th>Year<?php $serial+=1;?></th>
                            <?php if($pf):?>
                                <th>PF<?php $serial+=1;?></th>
                                <?php $pf_index = 1;?>
                            <?php endif;?>
                            <?php if($advance):?>
                                <th>Advance<?php $serial+=1;?></th>
                                <?php $advance_index = 1;?>
                            <?php endif;?>
                            <?php if($loan):?>
                                <th>Loan<?php $serial+=1;?></th>
                                <?php $loan_index = 1;?>
                            <?php endif;?>
                        </tr>                                    
                    </thead>
                    <tbody>
                        <?php
                        if(!empty($deduction_info)){ 
                            $section_name_old = null;$prev_rowspan=null; $dept = null; $i=0;
                            $tot_pf = 0;$tot_advance = 0;$tot_loan = 0;
                            foreach($deduction_info as $key => $row){
                                $section_name = $row['Section'];
                                if ($section_name != $section_name_old) { 
                                    $section_name_old = $section_name;
                                    if ( $key != 0 ) {
                                        ?><tr class ='row_index table-warning'>
                                            <td style="font-weight:bold;" colspan="9"><?php echo 'Department : '.$dept.'<br/> Section : '.$prev_rowspan;?></td>
                                            <td class ='pf_index' style="font-weight:bold;"><?php echo $tot_sec_pf;?></td>
                                            <td class ='advance_index' style="font-weight:bold;"><?php echo $tot_sec_advance;?></td>
                                            <td class ='loan_index' style="font-weight:bold;"><?php echo $tot_sec_loan;?></td>
                                        </tr><?php                                
                                        $tot_pf += $tot_sec_pf;$tot_advance += $tot_sec_advance;$tot_loan += $tot_sec_loan;
                                    }                                         
                                    $tot_sec_pf = 0;$tot_sec_advance = 0;$tot_sec_loan = 0;
                                }
    
                                $no = $key+1;
                                $EmployeeCode = $row['EmployeeCode'];
                                $EmployeeName = $row['EmployeeName'];
                                $designation = $row['Designation'];
                                $department = $row['Department'];
                                $Section = $row['Section'];
                                $staff_category = $row['StaffCategory'];
                                $pf_amt = ($row['PF']);
                                $advance_amt = ($row['Advance']);
                                $loan_amt = ($row['Loan']);
                                
                                $tot_sec_pf += $pf_amt;$tot_sec_advance += $advance_amt;$tot_sec_loan += $loan_amt;                            
                                $tr_rowspan = $count_section[$row['Section']];
                                ?>
                                <tr>
                                    <td><?php echo ++$i; ?></td>
                                        <td><?php echo $EmployeeCode; ?></td>
                                        <td><?php echo $EmployeeName; ?></td>
                                        <td><?php echo $designation; ?></td>
                                        <td><?php echo $Section; ?></td>
                                        <td><?php echo $department; ?></td>
                                        <td><?php echo $staff_category; ?></td>
                                        <td><?php echo $month_names[$row['MonthNo']]; ?></td>
                                        <td><?php echo $row['YearNo']; ?></td>
                                    <?php if($pf):?>
                                        <td class="pf_amt"><?php echo $pf_amt; ?></td>
                                    <?php endif;?>
                                    <?php if($advance):?>
                                        <td class="advance_amt"><?php echo $advance_amt; ?></td>
                                    <?php endif;?>
                                    <?php if($loan):?>
                                        <td class="loan_amt"><?php echo $loan_amt; ?></td>
                                    <?php endif;?>
                                </tr>
                                <?php 
                                $prev_rowspan=$row['Section'];$dept=$row['Department'];                            
                            }
                            ?>
                            <tr class ='row_index table-warning'>
                                <td style="font-weight:bold;" colspan="9"><?php echo 'Department : '.$dept.'<br/> Section : '.$prev_rowspan;?></td>
                                <td  class ='pf_index' style="font-weight:bold;"><?php echo $tot_sec_pf;?></td>
                                <td class ='advance_index' style="font-weight:bold;"><?php echo $tot_sec_advance;?></td>
                                <td class ='loan_index' style="font-weight:bold;"><?php echo $tot_sec_loan;?></td>
                            </tr>
                            <tr class="table-info">
                                <td style="font-weight:bold;" colspan="9">Total</td>
                                <td class="tot_pf pf_index" style="font-weight:bold;"></td>
                                <td class="tot_advance advance_index" style="font-weight:bold;"></td>
                                <td class="tot_loan loan_index" style="font-weight:bold;"></td>
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
        $('.tot_sec_pf').each(function(){
            if($(this).text()==0){ 
                $(this).closest('tr').hide();
            }
        });
        $("table tr").hover(function() {
            $(this).addClass("table-danger");
        }, function() {
            $(this).removeClass("table-danger");
        });
        $("table tbody tr").click(function(){
            $(this).toggleClass("table-warning");
        });        
		total_calculate('pf_amt','tot_pf');        
		total_calculate('advance_amt','tot_advance');        
		total_calculate('loan_amt','tot_loan');     
        function total_calculate(parm,tot_parm){
            var sum_total = 0;
            $('.'+parm).each(function(){
                if($(this).text() !='' && !isNaN($(this).text())) {
                     //console.log(parseFloat($(this).text())+'->');
                     sum_total = parseFloat($(this).text())+sum_total; 
                }
            });
            $('.'+tot_parm).html(sum_total);
        }
        let pf_index = '<?php echo $pf_index;?>';
        let advance_index = '<?php echo $advance_index;?>';
        let loan_index = '<?php echo $loan_index;?>';
        if (pf_index==='0') {
            $('.pf_index').hide();
        }
        if (advance_index==='0') {
            $('.advance_index').hide();
        }
        if (loan_index==='0') {
            $('.loan_index').hide();
        }
        
    $(function() {
        let pageHeader = $('.page-heading').html();
        // Append a caption to the table before the DataTables initialisation
        //$('.dataTable').append('<caption style="caption-side: bottom">Printed at 15.20pm.</caption>');
        // not work forr colspan
        $('.dataTable').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    messageTop: 'Monthly Salary'
                },
                /*{
                    extend: 'pdf',
                    messageTop: 'Monthly Salary'
                },*/
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


