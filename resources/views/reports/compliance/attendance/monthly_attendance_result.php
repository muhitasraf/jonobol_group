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

    $date_heads = $header;

    $header = array_merge($head_array,$header);
    $exportable_data[] = $header;
?>
    <div class="container-fluid">
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
            <div class="col-sm-12">
                <table class="table table-bordered table-sm dataTable" cellspacing="0" width="100%">
                    <thead>
                        <tr>
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
                                <?php endif;
                                $work_dates = explode(',',$employee['WorkDate']);
                                $all_status = explode(',',$employee['DayStatus']);
                                $total_data = count($work_dates);
                                $total_head = count($date_heads);

                                $in_times = explode(',',$employee['InTime']);
                                $out_times = explode(',',$employee['OutTime']);

//                                $exportable_data[$index+1][] = $employee['EmployeeCode'];
//                                $exportable_data[$index+1][] = $employee['EmployeeName'];
//                                $exportable_data[$index+1][] = $employee['DOJ'];

    //                            if ($employee['EmployeeCode'] == '01272'){
    //                                myLog('header: '.$employee['EmployeeCode'].'->'.json_encode($header));
    //                                myLog('work_dates: '.json_encode($work_dates));
    //                                myLog('day_status: '.json_encode($all_status));
    //                                myLog('in_times: '.json_encode($in_times));
    //                                myLog('out_times: '.json_encode($out_times));
    //                            }
                                for ( $day = 0; $day < $total_head; $day++  ) {
                                    $day_status = $all_status[$day] ?? null;
                                    $in_time = date_conversion('h:i a', $in_times[$day] ?? null);
                                    $out_time = date_conversion('h:i a', $out_times[$day] ?? null);
                                    $status_with_time = $day_status . ',  (' . $in_time . ' - ' . $out_time . ')';
                                    echo '<td>
                                          <span class="d-block border-bottom">' . $day_status . '</span> 
                                          <span class="d-block border-bottom">' . ($in_time == null ? '-':$in_time) . '</span>' . $out_time .
                                        '</td>';

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

            $('.dataTable').DataTable( {
                dom: 'Bfrtip',
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
                    /*{
                        extend: 'pdf',
                        messageTop: 'Monthly Salary',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                    },*/
                    {
                        extend: 'print',
                        messageTop: pageHeader,
                        action: function ( e, dt, node, config ) {
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
<?php else:
endif;
//session("export_data", "");
//session("export_data", json_encode($exportable_data));
?>