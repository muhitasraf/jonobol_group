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
        'Gross', 'Basic', 'House Rent', 'Medical & Allowance', 'Days in month', 'Weekly off', 'Present Day', 'Leave',
        'Absent Day', 'Payable Day', 'Deduction', 'Attendance Bonus', 'Payable Salary','Stamp', 'Total Payable',
        'Signature and Stamp'
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
                            <th class="rotated-text"><div><span>Present Day</span></div><?php $serial+=1;?></th>
                            <th class="rotated-text"><div><span>Weekly off</span></div><?php $serial+=1;?></th>
                            <th class="rotated-text"><div><span>Festive Holiday</span></div><?php $serial+=1;?></th>
                            <th class="rotated-text"><div><span>CL</span></div><?php $serial+=1;?></th>
                            <th class="rotated-text"><div><span>SL</span></div><?php $serial+=1;?></th>
                            <th class="rotated-text"><div><span>EL</span></div><?php $serial+=1;?></th>
                            <th class="rotated-text"><div><span>SPL</span></div><?php $serial+=1;?></th>
                            <th class="rotated-text"><div><span>Payable Day</span></div><?php $serial+=1;?></th>
                            <th class="rotated-text"><div><span>Absent Day</span></div><?php $serial+=1;?></th>
                            <th class="rotated-text"><div><span>Days in month</span></div><?php $serial+=1;?></th>
                            <th class="rotated-text"><div><span>Gross</span></div><?php $serial+=1;?></th>
                            <th class="rotated-text"><div><span>Basic</span></div><?php $serial+=1;?></th>
                            <th class="rotated-text"><div><span>House Rent</span></div><?php $serial+=1;?></th>
                            <th class="rotated-text"><div><span>Medical Allowance</span></div><?php $serial+=1;?></th>
                            <th class="rotated-text"><div><span>Absent Deduction</span></div><?php $serial+=1;?></th>
                            <th class="rotated-text"><div><span>PF</span></div><?php $serial+=1;?></th>
                            <th class="rotated-text"><div><span>Tax</span></div><?php $serial+=1;?></th>
                            <th class="rotated-text"><div><span>Advance Deduction</span></div><?php $serial+=1;?></th>
                            <th class="rotated-text"><div><span>Food Deduction</span></div><?php $serial+=1;?></th>
                            <th class="rotated-text"><div><span>Stamp Deduction</span></div><?php $serial+=1;?></th>
                            <th class="rotated-text"><div><span>Total Deduction</span></div><?php $serial+=1;?></th>
                            <th class="rotated-text"><div><span>Payable Salary</span></div><?php $serial+=1;?></th>
                            <th class="rotated-text"><div><span>Attendance Bonus</span></div><?php $serial+=1;?></th>
                            <th class="rotated-text"><div><span>Arear</span></div><?php $serial+=1;?></th>
                            <th class="rotated-text"><div><span>Total Payable</span></div><?php $serial+=1;?></th>
                            <th>Signature and Stamp<?php $serial+=1;?></th>
                        </tr>                                    
                    </thead>
                    <tbody>
                        <?php
                        $section_name_old = null;$prev_rowspan=null; $dept = null; $i=0;
                        $tot_sec_gross = 0;$tot_sec_basic = 0;$tot_sec_hrent = 0;$tot_sec_med = 0;$tot_sec_ab = 0;$tot_sec_pf = 0;$tot_sec_tax = 0;$tot_sec_adv = 0;
                        $tot_sec_food = 0;$tot_sec_stamp = 0;$tot_sec_tot_deduc = 0;$tot_sec_pay_sal = 0;$tot_sec_attn_bonus = 0;$tot_sec_arear = 0;$tot_sec_pay = 0;
                        foreach($employee_info as $key => $row):
                            $section_name = $row['Section'];
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
                            $gross = ($row['orgGROSS']);
                            $BASIC = ($row['orgBASIC']);
                            $HOUSERENT = ($row['orgHOUSERENT']);
                            $MEDICAL = ($row['orgMEDICAL']);
                            $DaysInMonth = date_conversion('d',$row['ToDate']);
                            $WeeklyOffDay = $row['WeeklyOffDay'];
                            $PresentDay = $row['PresentDay'];
                            $absenteeism = round($row['Absenteeism']);
                            $pf = ($row['PF']);
                            $advance = ($row['ADVANCE']);
                            $stamp =  $row['STAMP'];
                            $tax = ($row['TAX']);
                            $food = ($row['FOOD']);
                            $ARREAR = ($row['ARREAR']);
                            $deduction = round($absenteeism+$pf+$advance+$stamp+$tax+$food);
                            $attendanceBonus =  ($row['ATTENDANCEBONUS']);

                            $cl = $leave_data['CL'] ?? 0;
                            $sl = $leave_data['SL'] ?? 0;
                            $el = $leave_data['EL'] ?? 0;
                            $spl = $leave_data['SPL'] ?? 0;
                            $total_leave = $cl + $sl + $el + $spl;
                            $payable_day  = $WeeklyOffDay+$PresentDay+$total_leave ;
                            $payable = round($gross - $deduction);
                            //$OTRate = $row['OTRate'];
                            $totalPayable = ($payable+$attendanceBonus+$ARREAR);
                            $totalPayable = round($totalPayable, 2);
                            $absent_day = $row['AbsentDay'];
                            $festival_day = $row['Festival'];
                            if ($payable_day>0) {
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
                                    
                                $exportable_data[] = array_merge($data_array,[$gross,$BASIC,$HOUSERENT,$MEDICAL,$DaysInMonth,$WeeklyOffDay,$PresentDay,$total_leave,$absent_day,$payable_day,$deduction,$attendanceBonus,$payable,$totalPayable]);
                                unset($data_array);
                                $tr_rowspan = $count_section[$row['Section']];                            
                                $tot_sec_gross += $gross;$tot_sec_basic += $BASIC;$tot_sec_hrent += $HOUSERENT;$tot_sec_med += $MEDICAL;$tot_sec_ab += $absenteeism;$tot_sec_pf += $pf;$tot_sec_tax += $tax;$tot_sec_adv += $advance;
                                $tot_sec_food += $food;$tot_sec_stamp += $stamp;$tot_sec_tot_deduc += $deduction;$tot_sec_pay_sal += $payable;$tot_sec_attn_bonus += $attendanceBonus;$tot_sec_arear += $ARREAR;$tot_sec_pay += $totalPayable;
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
                                <td><?php echo $PresentDay;?></td>
                                <td><?php echo $WeeklyOffDay;?></td>
                                <td><?php echo $festival_day;?></td>
                                <td><?php echo $cl;?></td>
                                <td><?php echo $sl;?></td>
                                <td><?php echo $el;?></td>
                                <td><?php echo $spl;?></td>
                                <td><?php echo $payable_day;?></td>
                                <td><?php echo $absent_day;?></td>
                                <td><?php echo $DaysInMonth;?></td>
                                <td class="emp_gross"><?php echo $gross;?></td>
                                <td class="emp_basic"><?php echo $BASIC;?></td>
                                <td class="emp_houserent"><?php echo $HOUSERENT;?></td>
                                <td class="emp_medical"><?php echo $MEDICAL;?></td>
                                <td class="emp_absent"><?php echo $absenteeism; ?></td>
                                <td class="emp_pf"><?php echo $pf;?></td>
                                <td class="emp_tax"><?php echo $tax;?></td>
                                <td class="emp_adv"><?php echo $advance;?></td>
                                <td class="emp_food"><?php echo $food;?></td>
                                <td class="emp_stamp"><?php echo $stamp;?></td>
                                <td class="emp_deduction"><?php echo $deduction;?></td>
                                <td class="emp_pay"><?php echo $payable;?></td>
                                <td class="emp_attn_bonus"><?php echo $attendanceBonus;?></td>
                                <td class="emp_arear"><?php echo $ARREAR;?></td>
                                <td class="emp_tot_pay"><?php echo ceil($totalPayable);?></td>
                                <td><?php ;?></td>
                            </tr>
                            <?php }
                            $prev_rowspan=$row['Section'];$dept=$row['Department'];                            
                        endforeach; ?>
                        <tr class ='row_index table-warning'>
                            <td colspan="<?php echo $serial-16;?>" style="font-weight:bold;"><?php echo 'Department : '.$dept.'<br/> Section : '.$prev_rowspan;?></td>
                            <!--td  style="font-weight:bold;"><?php echo 'Department : '.$dept.'<br/> Section : '.$prev_rowspan;?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td-->
                            <td class ='tot_sec_gross' style="font-weight:bold;"><?php echo $tot_sec_gross;?></td>
                            <td style="font-weight:bold;"><?php echo $tot_sec_basic;?></td>
                            <td style="font-weight:bold;"><?php echo $tot_sec_hrent;?></td>
                            <td style="font-weight:bold;"><?php echo $tot_sec_med;?></td>
                            <td style="font-weight:bold;"><?php echo $tot_sec_ab;?></td>
                            <td style="font-weight:bold;"><?php echo $tot_sec_pf;?></td>
                            <td style="font-weight:bold;"><?php echo $tot_sec_tax;?></td>
                            <td style="font-weight:bold;"><?php echo $tot_sec_adv;?></td>
                            <td style="font-weight:bold;"><?php echo $tot_sec_food;?></td>
                            <td style="font-weight:bold;"><?php echo $tot_sec_stamp;?></td>
                            <td style="font-weight:bold;"><?php echo $tot_sec_tot_deduc;?></td>
                            <td style="font-weight:bold;"><?php echo $tot_sec_pay_sal;?></td>
                            <td style="font-weight:bold;"><?php echo $tot_sec_attn_bonus;?></td>
                            <td style="font-weight:bold;"><?php echo $tot_sec_arear;?></td>
                            <td style="font-weight:bold;"><?php echo $tot_sec_pay;?></td>
                            <td></td>
                        </tr>
                        <tr class="table-info">
                            <td colspan="<?php echo $serial-16;?>" style="font-weight:bold;">Total</td>
                            <!--td style="font-weight:bold;">Total</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td-->
                            <td class="tot_gross" style="font-weight:bold;"></td>
                            <td class="tot_basic" style="font-weight:bold;"></td>
                            <td class="tot_houserent" style="font-weight:bold;"></td>
                            <td class="tot_medical" style="font-weight:bold;"></td>
                            <td class="tot_absent" style="font-weight:bold;"></td>
                            <td class="tot_pf" style="font-weight:bold;"></td>
                            <td class="tot_tax" style="font-weight:bold;"></td>
                            <td class="tot_adv" style="font-weight:bold;"></td>
                            <td class="tot_food" style="font-weight:bold;"></td>
                            <td class="tot_stamp" style="font-weight:bold;"></td>
                            <td class="tot_deduction" style="font-weight:bold;"></td>
                            <td class="tot_pay_sal" style="font-weight:bold;"></td>
                            <td class="tot_attn_bonus" style="font-weight:bold;"></td>
                            <td class="tot_arear" style="font-weight:bold;"></td>
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
