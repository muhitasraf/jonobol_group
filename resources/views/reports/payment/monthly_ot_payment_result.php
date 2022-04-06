<?php
$exportable_data = [];
if ($employee_info):
    $head_array[] = 'No.';
    if($cb_code)
        $head_array[] = 'Code';
    if($cb_name)
        $head_array[] = 'Name';
    if($cb_doj)
        $head_array[] = 'DOJ';
    if($cb_designation)
        $head_array[] = 'Designation';
    if($cb_section)
        $head_array[] = 'Section';
    if($cb_department)
        $head_array[] = 'Department';
    if($cb_staffcat)
        $head_array[] = 'Staff Category';

    $header = [
        'Basic', 'Total Payable',  'Signature and Stamp'
    ];
    $header = array_merge($head_array,$header);
    // $exportable_data[] = $header;
    ?>
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
        <div class="row mt-1">
            <div class="col-sm-12 salary-sheet">
                <table class="table table-striped table-bordered dataTable FixedHeader">
                    <thead>                        
                        <tr class="table-success">
                            <th class="rotated-text"><div><span>S.L</span></div><?php $serial=1;?></th>
                            <?php if($cb_code):?>
                                <th class="rotated-text"><div><span>Employee Code</span></div><?php $serial+=1;?></th>
                            <?php endif;?>
                            <?php if($cb_name):?>
                                <th class="rotated-text"><div><span>Name</span></div><?php $serial+=1;?></th>
                            <?php endif;?>
                            <?php if($cb_doj):?>
                                <th class="rotated-text"><div><span>DOJ</span></div><?php $serial+=1;?></th>
                            <?php endif;?>
                            <?php if($cb_designation):?>
                                <th class="rotated-text"><div><span>Designation</span></div><?php $serial+=1;?></th>
                            <?php endif;?>
                            <?php if($cb_section):?>
                                <th class="rotated-text"><div><span>Section</span></div><?php $serial+=1;?></th>
                            <?php endif;?>
                            <?php if($cb_department):?>
                                <th class="rotated-text"><div><span>Department</span></div><?php $serial+=1;?></th>
                            <?php endif;?>
                            <?php if($cb_staffcat):?>
                                <th class="rotated-text"><div><span>Staff Category</span></div><?php $serial+=1;?></th>
                            <?php endif;?>
                            <th class="rotated-text"><div><span>Basic</span></div><?php $serial+=1;?></th>
                            <th class="rotated-text"><div><span>OT Rate</span></div><?php $serial+=1;?></th>
                            <th class="rotated-text"><div><span>Total OT Hour</span></div><?php $serial+=1;?></th>
                            <th class="rotated-text"><div><span>Total OT Payment</span></div><?php $serial+=1;?></th>
                            <th class="rotated-text"><div><span>Total Payable</span></div><?php $serial+=1;?></th>
                            <th>Signature and Stamp<?php $serial+=1;?></th>
                        </tr>                                    
                    </thead>
                    <tbody>
                        <?php
                        $section_name_old = null;$prev_rowspan=null; $dept = null; $i=0;
                        $tot_basic = 0;$tot_pay = 0;$tot_tot_ot_hour = 0;$tot_ot_pay = 0;
                        foreach($employee_info as $key => $row):
                            $section_name = $row['Section'];
                            if ($section_name != $section_name_old) { 
                                $section_name_old = $section_name;
                                if ( $key != 0 ) {
                                    ?><tr class ='row_index table-warning'>
                                        <td colspan="<?php echo $serial-6;?>" style="font-weight:bold;"><?php echo 'Department : '.$dept.'<br/> Section : '.$prev_rowspan;?></td>
                                        <td style="font-weight:bold;"><?php echo $tot_sec_basic;?></td>
                                        <td style="font-weight:bold;"></td>
                                        <td style="font-weight:bold;"><?php echo $tot_sec_tot_ot_hour;?></td>
                                        <td style="font-weight:bold;"><?php echo $tot_sec_ot_pay;?></td>
                                        <td style="font-weight:bold;"><?php echo $tot_sec_pay;?></td>
                                        <td></td>
                                    </tr>
                                    <!--/tbody>
                                    </table--> <?php                                
                                    $tot_basic += $tot_sec_basic;$tot_tot_ot_hour += $tot_sec_tot_ot_hour;
                                    $tot_ot_pay += $tot_sec_ot_pay;$tot_pay += $tot_sec_pay;
                                } ?>
                                <!--table class="table table-bordered table-sm dataTablex" cellspacing="0" width="100%"> <tbody--> <?php                                        
                                $tot_sec_basic = 0;$tot_sec_tot_ot_hour = 0;$tot_sec_ot_pay = 0;$tot_sec_pay = 0;
                            }
                            $leave_type = explode(',',$row['LeaveType']);
                            $leave_days = explode(',',$row['LeaveDays']);
                            $leave_data = array_combine($leave_type,$leave_days);

                            $no = $key+1;
                            $EmployeeCode = $row['EmployeeCode'];
                            $EmployeeName = $row['EmployeeName'];
                            $DOJ = date_conversion('d-m-Y',$row['DOJ']);
                            $designation = $row['Designation'];
                            $department = $row['Department'];
                            $Section = $row['Section'];
                            $staff_category = $row['StaffCategory'];
                            $BASIC = ($row['orgBASIC']);
                            $OT_HOUR = CEIL($row['MergeOT']);
                            $OT_PER_HOUR = $row['OT_PER_HOUR'];
                            $OTAmount = round(($OT_PER_HOUR*CEIL($row['MergeOT'])));
                            $tot_sec_basic += $BASIC;$tot_sec_tot_ot_hour += $OT_HOUR;$tot_sec_ot_pay += $OTAmount;$tot_sec_pay += $OTAmount;
                            
                                $data_array[] = $no;
                                if($cb_code)
                                    $data_array[] = $EmployeeCode;
                                if($cb_name)
                                    $data_array[] = $EmployeeName;
                                if($cb_doj)
                                    $data_array[] = $DOJ;
                                if($cb_designation)
                                    $data_array[] = $designation;
                                if($cb_section)
                                    $data_array[] = $Section;
                                if($cb_department)
                                    $data_array[] = $department;
                                if($cb_staffcat)
                                    $data_array[] = $staff_category;
                                    
                                $exportable_data[] = array_merge($data_array,[$BASIC,$OTAmount,$OTAmount]);
                                unset($data_array);
                                $tr_rowspan = $count_section[$row['Section']];
                            ?>
                            <tr>                                
                                <td><?php echo ++$i; ?></td>
                                <?php if($cb_code):?>
                                    <td><?php echo $EmployeeCode; ?></td>
                                <?php endif;?>
                                <?php if($cb_name):?>
                                    <td><?php echo $EmployeeName; ?></td>
                                <?php endif;?>
                                <?php if($cb_doj):?>
                                    <td><?php echo $DOJ; ?></td>
                                <?php endif;?>
                                <?php if($cb_designation):?>
                                    <td><?php echo $designation; ?></td>
                                <?php endif;?>
                                <?php if($cb_section):?>
                                    <td><?php echo $Section; ?></td>
                                <?php endif;?>
                                <?php if($cb_department):?>
                                    <td><?php echo $department; ?></td>
                                <?php endif;?>
                                <?php if($cb_staffcat):?>
                                    <td><?php echo $staff_category; ?></td>
                                <?php endif;?>
                                <td class="emp_basic"><?php echo $BASIC;?></td>
                                <td class="emp_ot_per_hour"><?php echo $OT_PER_HOUR;?></td>
                                <td class="emp_ot_hour"><?php echo $OT_HOUR;?></td>
                                <td class="emp_ot_amt"><?php echo $OTAmount;?></td>
                                <td class="emp_tot_pay"><?php echo ceil($OTAmount);?></td>
                                <td><?php ;?></td>
                            </tr>
                            <?php 
                            $prev_rowspan=$row['Section'];$dept=$row['Department'];                            
                        endforeach; ?>
                        <tr class ='row_index table-warning'>
                                        <td colspan="<?php echo $serial-6;?>" style="font-weight:bold;"><?php echo 'Department : '.$dept.'<br/> Section : '.$prev_rowspan;?></td>
                                        <td style="font-weight:bold;"><?php echo $tot_sec_basic;?></td>
                                        <td style="font-weight:bold;"></td>
                                        <td style="font-weight:bold;"><?php echo $tot_sec_tot_ot_hour;?></td>
                                        <td style="font-weight:bold;"><?php echo $tot_sec_ot_pay;?></td>
                                        <td style="font-weight:bold;"><?php echo $tot_sec_pay;?></td>
                                        <td></td>
                                    </tr>
                        <tr class="table-info">
                            <td colspan="<?php echo $serial-6;?>" style="font-weight:bold;">Total</td>
                            <td class="tot_basic" style="font-weight:bold;"></td>
                            <td class="tot_ot_rate" style="font-weight:bold;"></td>
                            <td class="tot_ot_hour" style="font-weight:bold;"></td>
                            <td class="tot_ot_pay" style="font-weight:bold;"></td>
                            <td class="tot_pay" style="font-weight:bold;"></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <style>
        th.rotated-text {
            height: 140px;
            white-space: nowrap;
            padding: 0px 0px 10px 0px !important;
            position:relative;
        }        
        th.rotated-text > div {
            transform:
                translate(0px, 0px)
                rotate(270deg);
            width: 20px;
        }
        body {
            width: max-content !important;
        }
        .col-sm-3 {
            -ms-flex: 0 0 25%;
            flex: 0 0 25%;
            max-width: 10% !important;
        }
        /*.page-header {
            margin-left: 10% !important;
        }*/
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
        $('.tot_sec_gross').each(function(){
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
		total_calculate('emp_gross','tot_gross');        
		total_calculate('emp_basic','tot_basic');        
		total_calculate('emp_houserent','tot_houserent');        
		total_calculate('emp_medical','tot_medical');        
		total_calculate('emp_absent','tot_absent');        
		total_calculate('emp_pf','tot_pf');        
		total_calculate('emp_tax','tot_tax');        
		total_calculate('emp_adv','tot_adv');        
		total_calculate('emp_food','tot_food');        
		total_calculate('emp_stamp','tot_stamp');        
		total_calculate('emp_deduction','tot_deduction');        
		total_calculate('emp_pay','tot_pay_sal');        
		//total_calculate('emp_ot_per_hour','tot_ot_rate');        
		total_calculate('emp_ot_hour','tot_ot_hour');        
		total_calculate('emp_ot_amt','tot_ot_pay');        
		total_calculate('emp_attn_bonus','tot_attn_bonus');        
		total_calculate('emp_arear','tot_arear');        
		total_calculate('emp_tot_pay','tot_pay');     
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

<?php else:
    echo "<h5 class='text text-danger'>There is no data according to your search.</h5>";
endif;
?>
