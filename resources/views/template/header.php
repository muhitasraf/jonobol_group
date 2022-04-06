<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="content-type" content="text/plain; charset=UTF-8"/>
    <title><?php echo $title ?? '';?> :: HR</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo asset('plugins/fontawesome-free/css/fontawesome.min.css') ?>">
    <link rel="stylesheet" href="<?php echo asset('plugins/fontawesome-free/css/solid.min.css') ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo asset('dist/css/adminlte.min.css'); ?>">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="<?php echo asset('dist/css/fonts.css'); ?>">
    <!--plugins css-->
    <link rel="stylesheet" href="<?php echo asset('plugins/select2/css/select2.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('dist/css/custom.css'); ?>">

    <script src="<?php echo asset('plugins/jquery/jquery.min.js'); ?>"></script>
    <script src="<?php echo asset('plugins/jquery-ui/jquery-ui.min.js'); ?>"></script>   
    
    <style href="<?php echo asset('fonts/SutonnyMJ-Regular.ttf'); ?>"></style>

    

   
</head>
<body class="font-opensans hold-transition sidebar-mini"><!-- sidebar-collapse for auto collapse always -->
    <div class="wrapper">
        <!-- Navbar -->
        <?php
            $perm = new \App\Models\Permission();
            $cmp = $perm->table('company',1);//->select('id','logo')->fetch();
            $path = "uploads/images/";
            $logo = $path."company/".$cmp->logo;
            if(!$cmp->logo){
                $logo = $path."no-image.jpg";
            }
            //echo '<pre>';print_r(session('role_id'));
            //echo $perm->hasPerm('show-transfer');exit;
        ?>
        <nav class="main-header navbar navbar-expand navbar-dark navbar-info p-0"><!--navbar-white navbar-light-->
            <!-- Left navbar links -->
            <?php if ($perm->hasPerm(['show-employee'])):?>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item ml-2">
                    <a href="<?php echo route('apply_leave/create');?>" class="nav-link">
                        <span style="color:#fff;font-weight: bold;">Apply Leave</span>
                    </a>
                </li>
                <li class="nav-item ml-2">
                    <a href="<?php echo route('apply_leave');?>" class="nav-link">
                        <span style="color:#fff;font-weight: bold;">Leave Application</span>
                    </a>
                </li>
                <li class="nav-item ml-2">
                    <a href="<?php echo route('attendance/synchronize_device_data');?>" class="nav-link">
                        <i class="fa fa-arrow-right"><span style="color:#fff;font-weight: bold;">Sync Attendence</span></i>
                    </a>
                </li>
                <li class="nav-item ml-2">
                    <a href="<?php echo route('attendance/device');?>" class="nav-link">
                        <span style="color:#fff;font-weight: bold;">Attendence Device</span>
                    </a>
                </li>
                <li class="nav-item ml-2">
                    <a href="<?php echo route('attendance/process');?>" class="nav-link">
                        <span style="color:#fff;font-weight: bold;">Attendence Process</span>
                    </a>
                </li>
                <li class="nav-item ml-2">
                    <a href="<?php echo route('attendance/manual');?>" class="nav-link">
                        <span style="color:#fff;font-weight: bold;">Attendance Manual</span>
                    </a>
                </li>
            </ul>
            <?php endif; ?>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar-x" data-slide="true" href="<?php echo route('auth/logout');?>" title="Logout">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->