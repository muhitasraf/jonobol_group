<?php
$exportable_data = [];
if ($employee_info):
    $header = [
        'No. of Staff', 'Male', 'Female'
    ];
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
                        <th></th>
                        <th><?php echo $header[0]; ?></th>
                        <th><?php echo $header[1]; ?></th>
                        <th><?php echo $header[2]; ?></th>
                    </thead>
                    <tbody>
                        <?php foreach ($employee_info as $key=>$value):
                            $male = $value['male'];
                            $female = $value['female'];
                            $exportable_data[] = [
                                $male+$female,
                                $male,
                                $female
                            ];
                            ?>
                            <tr>
<!--                                <td> --><?php //echo $value['Description'] ?? '';?><!-- </td>-->
                                <td></td>
                                <td> <?php echo $value['male']+$value['female']; ?> </td>
                                <td> <?php echo $value['male']; ?> </td>
                                <td> <?php echo $value['female']; ?> </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php else:
        echo "<h5 class='text text-danger'>There is no data according to your search.</h5>";
    endif;

//session("export_data", "");
//session("export_data", json_encode($exportable_data));
?>
<script>
    $(function() {
        let pageHeader = $('.page-heading').html();
        // Append a caption to the table before the DataTables initialisation
        //$('.dataTable').append('<caption style="caption-side: bottom">Printed at 15.20pm.</caption>');

        $('.dataTable').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    messageTop: 'Employee List'
                },
                /*{
                    extend: 'pdf',
                    messageTop: 'Employee List'
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