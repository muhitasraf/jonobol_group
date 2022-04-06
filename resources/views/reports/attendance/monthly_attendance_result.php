<?php
$exportable_data = [];
if ($employee_info):
    $head_array = ['No'];
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
    if($cb_present)
        $head_array[] = 'P';
    if($cb_absent)
        $head_array[] = 'A';
    if($cb_late)
        $head_array[] = 'L';
    if($cb_ot)
        $head_array[] = 'OT';

    $date_heads = $header;

    $header = array_merge($head_array,$header);
    //dd($head_array);
    $exportable_data[] = $header;
?>
    <div class="container-fluid attendance-sheet-full">
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
            <div class="col-sm-12">
                <table class="table table-striped table-bordered table-sm dataTable FixedHeader" cellspacing="0" width="100%">
                    <thead>
                        <tr class="table-secondary">
                            <?php foreach ($header as $head) {
                                echo "<th>".$head."</th>";
                            }?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($employee_info as $index => $employee) :
                            $EmployeeCode = $employee['EmployeeCode'];
                            $EmployeeName = $employee['EmployeeName'];
                            $DOJ = date_conversion('d-m-Y',$employee['DOJ']);
                            $designation = $employee['Designation'];
                            $department = $employee['Department'];
                            $section = $employee['Section'];
                            $staff_category = $employee['StaffCategory'];

                            $data_array = [$index+1];
                            if($cb_code)
                                $data_array[] = $EmployeeCode;
                            if($cb_name)
                                $data_array[] = $EmployeeName;
                            if($cb_doj)
                                $data_array[] = $DOJ;
                            if($cb_designation)
                                $data_array[] = $designation;
                            if($cb_section)
                                $data_array[] = $section;
                            if($cb_department)
                                $data_array[] = $department;
                            if($cb_staffcat)
                                $data_array[] = $staff_category;
                            
                            
                            $all_status = explode(',',$employee['DayStatus']);
                            $pal = array_count_values($all_status);
                            $slab_1_ot = array_sum(explode(',',$employee['slab_1_ot'])) ?? null;
                            $slab_2_ot = array_sum(explode(',',$employee['slab_2_ot'])) ?? null;
                            $w_ot = array_sum(explode(',',$employee['w_ot'])) ?? null;
                            //dd($pal);
                            //$doj_day = date_conversion('d',$employee['DOJ']);
                            //$seperation_effective_day = date_conversion('d',$employee['separation_effective_date']);
                            ?>
                            <tr>
                                <td><?php echo $index+1; ?></td>
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
                                    <td><?php echo $section; ?></td>
                                <?php endif;?>
                                <?php if($cb_department):?>
                                    <td><?php echo $department; ?></td>
                                <?php endif;?>
                                <?php if($cb_staffcat):?>
                                    <td><?php echo $staff_category; ?></td>
                                <?php endif;?>
                                <?php if($cb_present):?>
                                    <?php if(isset($pal['P'])):?>
                                        <td><?php echo $pal['P']; ?></td>
                                    <?php else:?>
                                        <td></td>
                                    <?php endif;?>
                                <?php endif;?>
                                <?php if($cb_absent):?>
                                    <?php if(isset($pal['A'])):?>
                                        <td><?php echo $pal['A']; ?></td>
                                    <?php else:?>
                                        <td></td>
                                    <?php endif;?>
                                <?php endif;?>
                                <?php if($cb_late):?>
                                    <?php if(isset($pal['L'])):?>
                                        <td><?php echo $pal['L']; ?></td>
                                    <?php else:?>
                                        <td></td>
                                    <?php endif;?>
                                <?php endif;?>
                                <?php if($cb_ot):?>
                                    <td><?php echo 'C-'.$slab_1_ot.'<br/>E-'.$slab_2_ot.'<br>W-'.$w_ot.'<br>T-'.($slab_1_ot+$slab_2_ot+$w_ot);?></td>
                                <?php endif;?>
                                
                                <?php
                                $work_dates = explode(',',$employee['WorkDate']);
                                //myLog(json_encode($all_status));
                                $total_data = count($work_dates);
                                $total_head = count($date_heads);

                                $ShiftInTimes = explode(',',$employee['ShiftInTime']);
                                $in_times = explode(',',$employee['InTime']);
                                $out_times = explode(',',$employee['OutTime']);
                                $slab_1_ots = explode(',',$employee['slab_1_ot']);
                                $slab_2_ots = explode(',',$employee['slab_2_ot']);
                                $w_ots = explode(',',$employee['w_ot']);
                                for ( $day = 0; $day < $total_head; $day++  ) {
                                    $day_status = $all_status[$day] ?? null;
                                    $in_time =  null;
                                    $out_time = null;
                                    if(isset($in_times[$day]) && $in_times[$day]>'00:00:00'){
                                        $in_time = date('h:i a', strtotime($in_times[$day]));
                                    }
                                    if(isset($out_times[$day]) && $out_times[$day]>'00:00:00'){
                                        $out_time = date('h:i a', strtotime($out_times[$day]));
                                        if($in_time ==  null){
                                             $in_time = date('h:i a', strtotime($ShiftInTimes[$day]));
                                        }
                                    }                                    
                                    $status_with_time = $day_status . ',  (' . $in_time . ' - ' . $out_time . ')';

                                    //$status_with_time = null;
                                    //myLog($EmployeeCode.", day_status:$day_status, intime isset:".$in_times[$day].isset($day_status));
                                    //myLog($EmployeeCode.", day_status:$day_status, intime empty:".$in_times[$day].empty($day_status));
                                    if (!empty($day_status)){
                                        echo '<td>
                                          <span class="d-block border-bottom">' . $day_status . '</span> 
                                          <span class="d-block border-bottom">' . ($in_time == null ? '-':$in_time) . '</span><span class="d-block border-bottom">' . $out_time.'</span>'.
                                          $slab_1_ots[$day].'-'.$slab_2_ots[$day].'-'.$w_ots[$day] .'-'.($slab_1_ots[$day]+$slab_2_ots[$day]+$w_ots[$day]).
                                       '</td>';
                                    }else {
                                        echo '<td></td>';
                                        $status_with_time = null;
                                    }

                                    $io_array[] = $status_with_time;
                                }

                                $exportable_data[] = array_merge($data_array, $io_array);
                                unset($data_array);
                                unset($io_array);
                            echo "</tr>";
                        endforeach;?>
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
        }
    </style>
    <script>
        $(function() {
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

    <script>
        /*$('.btn-export').on('click',function (e) {
            let uri = 'data:application/vnd.ms-excel;base64,';
            let template = $('div.attendance-sheet-full').html();
            window.location.href = uri + btoa(template);
            e.preventDefault();
        });
        dataTablePlaceHolder();*/
    </script>
<?php else:
endif;
//session("export_data", "");
//session("export_data", json_encode($exportable_data));
?>