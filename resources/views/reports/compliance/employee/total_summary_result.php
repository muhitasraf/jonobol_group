<?php if ($employee_info):?>
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <?php
                $path = "uploads/images/";
                $company_logo = $path."company/".$company_info->logo;
                if(!$company_info->logo){
                    $company_logo = $path."no-image.jpg";
                }
                ?>
                <img class="rounded company_logo float-right mr-2" src="<?php echo asset($company_logo);?>" alt="company_logo" style="width:80px;">
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
                        <th>Unit/Branch</th>
                        <th>No. of Staff</th>
                        <th>Male</th>
                        <th>Female</th>
                    </thead>
                    <tbody>
                        <?php foreach ($employee_info as $key=>$value):?>
                            <tr>
                                <td> <?php echo $value['Description'] ?? '';?> </td>
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
?>