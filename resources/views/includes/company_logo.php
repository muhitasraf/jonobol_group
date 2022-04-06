<?php
$path = "uploads/images/";
$company_photo = $path."company/".$company_info->logo;
$file_dir = upload_path("/images/company/".$company_info->logo);
if(!$company_info->logo || !is_file($file_dir)) {
    $company_photo = $path."logo.png";
}
//echo $company_photo;
?>
<img class="rounded company_logo float-right mr-2" src="<?php echo asset($company_photo);?>" alt="Company Logo">