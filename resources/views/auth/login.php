<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $title ?? '';?> :: HR</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo asset('plugins/fontawesome-free/css/all.min.css') ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo asset('dist/css/adminlte.min.css'); ?>">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="<?php echo asset('dist/css/fonts.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('dist/css/custom.css'); ?>">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Galada&display=swap" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="/"><b class="font-weight-bolder text text-info" style="font-family: 'Galada', cursive;">জনবল</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in</p>

            <form action="<?php echo route('auth/login_check')?>" method="post">
                <?php include_once(View.'/errors/form-validation.php'); ?>
                <div class="input-group">
                    <input type="text" name="user_name" class="form-control" placeholder="User name">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <?php if(isset($errors['user_name'])):?>
                    <span class="text-danger"><?php echo $errors['user_name'][0]; ?></span>
                <?php endif;?>
                <div class="input-group mt-2">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <?php if(isset($errors['password'])):?>
                    <span class="text-danger"><?php echo $errors['password'][0]; ?></span>
                <?php endif;?>
                <?php                      
                    // init variables
                    $min_number = 1;
                    $max_number = 9;
                    // generating random numbers
                    $random_number1 = mt_rand($min_number, $max_number);
                    $random_number2 = mt_rand($min_number, $max_number);
                ?>
                <div class="form-group row mt-2">
                    <span for="LeaveType" class="col-sm-6 control-span"><span style="font-weight:bold;">CAPTCHA &nbsp;&nbsp;:</span>&nbsp;&nbsp;<?php echo $random_number1 . ' + ' . $random_number2;?></span>
                    <div class="col-sm-6">
                        <input type="text" name="captcha" class="form-control form-control-sm" placeholder="Enter Captcha" autocomplete="off">
                        <input name="firstNumber" type="hidden" value="<?php echo $random_number1; ?>" />
                        <input name="secondNumber" type="hidden" value="<?php echo $random_number2; ?>" />
                    </div>
                </div>   
                <?php if(isset($errors['captcha'])):?>
                    <span class="text-danger"><?php echo $errors['captcha'][0]; ?></span>
                <?php endif;?>             
                <div class="row mt-3">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">
                                Remember Me
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-outline-info btn-block btn-flat">Sign In</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->
</body>
</html>
