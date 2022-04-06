<div class="row">
    <div class="col-sm-4">
        <?php
        //$company_info = $this->model->table('company')->where('id', 1)->fetch();
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