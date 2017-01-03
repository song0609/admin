<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <title></title>
    <link rel="stylesheet" href="<?php echo base_url();?>share/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url();?>share/bootstrap/css/custom.css">
    <link rel="stylesheet" href="<?php echo base_url();?>share/bootstrap/css/admin_main.css">
</head>

<body>


<div class="container">

    <!-- 列表 -->
    <form class="form-horizontal" role="form" method="post" action="<?php echo site_url('c=admin&m=updatepassword');?>">
        <div class="panel panel-default">
            <div class="panel-heading">修改密码</div>
            <div class="panel-body">
                <div class="row gap">
                    <label class="col-sm-2 control-label"><span class="required">*</span> 原密码</label>
                    <div class="col-sm-8">
                        <input id="oldpassword" name="oldpassword" type="password" class="form-control" placeholder="原密码">
                    </div>
                    <div class="col-sm-2" id="message-oldpassword">
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

    $('#oldpassword').on('blur',function(){
        var oldpassword = $('#oldpassword').val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('c=admin&m=isoldpassword');?>",
            data: "password="+oldpassword,
            success: function(msg){
                if(msg==0){
                    $('#message-oldpassword').html('<font color="red">原密码错误！</font>');
                    i=0
                }else{
                    $('#message-oldpassword').html('');
                    i = 1;
                }
            }
        });
    });
</script>
</body>
</html>