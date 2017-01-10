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
    <form class="form-horizontal" role="form" method="post" action="<?php echo site_url('c=admin&m=saveAdvertiser');?>">
        <div class="panel panel-default">
            <div class="panel-heading">新建广告主
                <span><a href="<?php echo site_url('c=admin&m=getAdvertiserList') ?>" class="btn btn-large btn-primary" style="padding: 0">返回</a></span>
            </div>

            <div class="panel-body">
                <?php if(isset($tips)){ ?>
                    <div class="alert alert-success alert-dismissible show" role="alert">
                        <?php echo isset($tips)?$tips:''; ?>
                    </div>
                <?php } ?>
                <div class="row gap">
                    <label class="col-sm-2 control-label"><span class="required">*</span> 广告主账号</label>
                    <div class="col-sm-8">
                        <input id="username" name="username" type="text" class="form-control" value="<?php echo isset($form['username'])?$form['username']:'' ?>" placeholder="用户名">
                    </div>
                    <div class="col-sm-2" id="message-username">
                        <font color="red"><?php echo isset($errors)?$errors['username']:''; ?></font>
                    </div>
                </div>
                <div class="row gap">
                    <label class="col-sm-2 control-label"><span class="required">*</span> 广告主名称</label>
                    <div class="col-sm-8">
                        <input id="advertiser" name="advertiser" type="text" class="form-control" <?php echo isset($form['advertiser'])?$form['advertiser']:'' ?> placeholder="广告主名称">
                    </div>
                </div>
                <div class="row gap">
                    <label class="col-sm-2 control-label"><span class="required">*</span> 账号密码</label>
                    <div class="col-sm-8">
                        <input id="password" name="password" type="password" class="form-control" <?php echo isset($form['password'])?$form['password']:'' ?> placeholder="账号密码">
                    </div>
                </div>
                <div class="row gap">
                    <label class="col-sm-2 control-label"><span class="required">*</span> 再次输入密码</label>
                    <div class="col-sm-8">
                        <input id="repassword" name="repassword" type="password" class="form-control" placeholder="再次输入密码">
                    </div>
                    <div class="col-sm-2" id="message-password">
                    </div>
                </div>
                <div class="row gap">
                    <label class="col-sm-2 control-label"><span class="required">*</span> 联系人</label>
                    <div class="col-sm-8">
                        <input id="linkman" name="linkman" type="text" class="form-control" <?php echo isset($form['linkman'])?$form['linkman']:'' ?> placeholder="联系人">
                    </div>
                </div>
                <div class="row gap">
                    <label class="col-sm-2 control-label"><span class="required">*</span> 联系电话</label>
                    <div class="col-sm-8">
                        <input id="phone" name="phone" type="text" class="form-control" <?php echo isset($form['phone'])?$form['phone']:'' ?> placeholder="联系电话">
                    </div>
                </div>
                <div class="row gap">
                    <label class="col-sm-2 control-label"><span class="required">*</span> 邮箱</label>
                    <div class="col-sm-8">
                        <input id="email" name="email" type="text" class="form-control" <?php echo isset($form['email'])?$form['email']:'' ?> placeholder="邮箱">
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

<script src="<?php echo base_url().'share/';?>bootstrap/js/jquery.js"></script>
<script src="<?php echo base_url().'share/';?>bootstrap/js/bootstrap.js"></script>
<script src="<?php echo base_url().'share/';?>bootstrap/js/admin/vip.dream.js"></script>
<script>
    $('#submit').on("click", function() {
        var username = $('#username').val();
        var password = $('#password').val();
        var repassword = $('#repassword').val();
        if(password!=repassword){
            $('#message-password').html('<font color="red">与密码不一致！</font>');
            return false;
        }
    });

</script>
</body>
</html>