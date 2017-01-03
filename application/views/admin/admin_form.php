<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <title></title>
    <link rel="stylesheet" href="<?php echo base_url();?>/share/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/share/bootstrap/css/custom.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/share/bootstrap/css/admin_main.css">
</head>

<body>


<div class="container">

    <!-- 列表 -->
    <form class="form-horizontal" role="form" method="post" action="<?php echo site_url('admin/saveadmin');?>">
        <div class="panel panel-default">
            <div class="panel-heading">新建用户</div>
            <div class="panel-body">
                <div class="row gap">
                    <label class="col-sm-2 control-label"><span class="required">*</span> 用户名</label>
                    <div class="col-sm-8">
                        <input id="username" name="username" type="text" class="form-control" placeholder="用户名">
                    </div>
                    <div class="col-sm-2" id="message-username">
                    </div>
                </div>
                <div class="row gap">
                    <label class="col-sm-2 control-label"><span class="required">*</span> 密码</label>
                    <div class="col-sm-8">
                        <input id="password" name="password" type="password" class="form-control" placeholder="密码">
                    </div>
                </div>
                <div class="row gap">
                    <label class="col-sm-2 control-label"><span class="required">*</span> 重复密码</label>
                    <div class="col-sm-8">
                        <input id="repassword" name="repassword" type="password" class="form-control" placeholder="再次输入密码">
                    </div>
                    <div class="col-sm-2" id="message-password">
                    </div>
                </div>
            </div>
            <div class="panel-footer" align="right">
                <button type="reset" class="btn btn-default">重置</button>
                <button id="submit" type="submit" class="btn btn-primary">添加</button>
            </div>
        </div>
    </form>
    <!-- 列表 End -->

</div>

<script src="<?php echo base_url().APPPATH.'views/';?>bootstrap/js/jquery.js"></script>
<script src="<?php echo base_url().APPPATH.'views/';?>bootstrap/js/bootstrap.js"></script>
<script src="<?php echo base_url().APPPATH.'views/';?>bootstrap/js/admin/vip.dream.js"></script>
<script>
    var i = 0;
    $('#submit').on("click", function() {
        var username = $('#username').val();
        var password = $('#password').val();
        var repassword = $('#repassword').val();
        if(password!=repassword){
            $('#message-password').html('<font color="red">与密码不一致！</font>');
            return false;
        }
        if(i==0){
            return false;
        }
    });

    $('#username').on('blur',function(){
        var username = $('#username').val();
        $.ajax({
            type: "GET",
            url: "<?php echo site_url('admin/isexitsname');?>",
            data: "username="+username,
            success: function(msg){
                if(msg==1){
                    $('#message-username').html('<font color="red">用户名已使用！</font>');
                    i=0
                }else{
                    $('#message-username').html('');
                    i = 1;
                }
            }
        });
    });
</script>
</body>
</html>