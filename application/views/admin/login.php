<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html>
<head>
    <title>后台登录</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="UTF-8">
    <link href="<?php echo base_url();?>share/bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="<?php echo base_url();?>share/bootstrap/css/custom.css" rel="stylesheet" media="screen">
    <link href="<?php echo base_url();?>share/bootstrap/css/login.css" rel="stylesheet" media="screen">
    <script src="<?php echo base_url();?>share/bootstrap/js/jquery.js"></script>
    <script src="<?php echo base_url();?>share/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<?php
!isset($redirect)?$redirect='':'';
echo form_open(site_url("c=login&m=formsubmit&redirect=".$redirect));
?>
<div class="container">

    <header>
        <h1>Admix后台管理系统 </h1>
    </header>
    <div class="login-table">
        <div class="row">

            <label class="col-sm-2 control-label al-r">用户</label>
            <div class="col-sm-10">
                <input name="username" type="text" class="form-control" placeholder="请输入帐号">
                <?php echo form_error('username'); ?>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-2 control-label al-r">密码</label>
            <div class="col-sm-10">
                <input name="password" type="password" class="form-control" placeholder="请输入登录密码">
                <?php echo form_error('password'); ?>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 control-label al-r"></label>
            <div class="col-sm-4">
                <input type="radio" name="user_type" id="optionsRadios2" value="0" checked>
                客户
            </div>
            <div class="col-sm-4">
                    <input type="radio" name="user_type"  id="optionsRadios1" value="1" >
                    管理员
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 al-r" >
            </div>
            <div class="col-sm-4 al-r" >
                <input type="submit" name="submit" style="font-size: 16px;" class="btn btn-large btn-primary btn-block" value="登录" placeholder="">
            </div>
            <div class="col-sm-4 al-r" >
            </div>
        </div>
    </div>
</div>
    <p class="f-small al-c">Copyright © 2016-2017 vip.com All rights reserved.</p>
</form>
</body>
</html>