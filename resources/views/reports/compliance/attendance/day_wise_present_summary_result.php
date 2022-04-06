<?php
$exportable_data = [];
if ($employee_info):
    $header = [
        'No. of Staff', 'Male', 'Female'
    ];
    $exportable_data[] = $header;
?>
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <?php echo view('includes/company_logo',compact('company_info'),false); ?>
            </div>
            <div class="col-sm-8">
                <h4><?php echo $company_info->name?></h4>
                <p><?php echo $company_info->address?></p>
                <p class="font-weight-bold"><?php echo $title?></p>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-sm-12">
                <table class="table table-bordered">
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

session("export_data", "");
session("export_data", json_encode($exportable_data));
?>