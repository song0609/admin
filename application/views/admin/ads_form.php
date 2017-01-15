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
    <form class="form-horizontal" role="form" method="post" action="<?php echo site_url('c=admin&m=saveAdvertisment');?>">
        <div class="panel panel-default">
            <div class="panel-heading">新建广告
                <span><a href="<?php echo site_url('c=admin&m=getAdvertismentList') ?>" class="btn btn-large btn-primary" style="padding: 0">返回</a></span>
            </div>

            <div class="panel-body">
                <?php if(isset($tips)){ ?>
                    <div class="alert alert-success alert-dismissible show" role="alert">
                        <?php echo isset($tips)?$tips:''; ?>
                    </div>
                <?php } ?>
                <div class="row gap">
                    <div class="col-sm-8">
                        <input id="id" name="id" type="hidden"  value="<?php echo isset($form['id'])?$form['id']:0 ?>">
                    </div>
                </div>
                <div class="row gap">
                    <label class="col-sm-2 control-label"><span class="required">*</span> 广告名称</label>
                    <div class="col-sm-8">
                        <input id="ads_name" name="ads_name" type="text" class="form-control" value="<?php echo isset($form['ads_name'])?$form['ads_name']:'' ?>" placeholder="广告名称">
                    </div>
                </div>
                <div class="row gap">
                    <label class="col-sm-2 control-label"><span class="required">*</span> 广告主名称</label>
                    <div class="col-sm-10">
                        <select id="client_id" name="client_id">
                            <?php
                            foreach($clients as $k=>$v){
                                if(isset($form['client_id']) && $form['client_id']==$v['id']){
                                    echo "<option value='{$v['id']}' selected>{$v['username']}</option>";
                                }else{
                                    echo "<option value='{$v['id']}'>{$v['username']}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row gap">
                    <label class="col-sm-2 control-label"><span class="required">*</span> 广告模式</label>
                    <div class="col-sm-8">
                        <input id="ads_type" name="ads_type" type="text" class="form-control" value="<?php echo isset($form['ads_type'])?$form['ads_type']:'' ?>" placeholder="广告模式">
                    </div>
                </div>
                <div class="row gap">
                    <label class="col-sm-2 control-label"><span class="required">*</span> 投放平台</label>
                    <div class="col-sm-8">
                        <input id="platform" name="platform" type="text" class="form-control" value="<?php echo isset($form['platform'])?$form['platform']:''?>" placeholder="投放平台">
                    </div>
                    <div class="col-sm-2" id="message-password">
                    </div>
                </div>
                <div class="row gap">
                    <label class="col-sm-2 control-label"><span class="required">*</span> 广告单价</label>
                    <div class="col-sm-8">
                        <input id="price" name="price" type="text" class="form-control" value="<?php echo isset($form['price'])?$form['price']:'' ?>" placeholder="广告单价">
                    </div>
                </div>
                <div class="row gap">
                    <label class="col-sm-2 control-label"><span class="required">*</span> 广告地址</label>
                    <div class="col-sm-8">
                        <input id="ads_url" name="ads_url" type="text" class="form-control" value="<?php echo isset($form['ads_url'])?$form['ads_url']:'' ?>" placeholder="广告地址">
                    </div>
                </div>
                <div class="row gap">
                    <label class="col-sm-2 control-label"><span class="required">*</span> 折扣</label>
                    <div class="col-sm-8">
                        <input id="discount" name="discount" type="text" class="form-control" value="<?php echo isset($form['discount'])?$form['discount']:'' ?>" placeholder="折扣">
                    </div>
                </div>
                <div class="row gap">
                    <label class="col-sm-2 control-label"><span class="required">*</span> 第三方平台</label>
                    <div class="col-sm-10">
                        <select id="third_platform" name="third_platform">
                            <?php
                            foreach($platforms as $k=>$v){
                                if(isset($form['third_platform']) && $form['third_platform']==$k){
                                    echo "<option value='{$k}' selected>{$v}</option>";
                                }else{
                                    echo "<option value='{$k}' selected>{$v}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row gap">
                    <label class="col-sm-2 control-label"><span class="required">*</span> 用户名</label>
                    <div class="col-sm-8">
                        <input id="username" name="username" type="text" class="form-control" value="<?php echo isset($form['username'])?$form['username']:'' ?>" placeholder="用户名">
                    </div>
                </div>
                <div class="row gap">
                    <label class="col-sm-2 control-label"><span class="required">*</span> 账号密码</label>
                    <div class="col-sm-8">
                        <input id="password" name="password" type="text" class="form-control" value="<?php echo isset($form['password'])?$form['password']:''?>" placeholder="账号密码">
                    </div>
                    <div class="col-sm-2" id="message-password">
                        <font color="red"><?php echo isset($errors)?$errors['password']:''; ?></font>
                    </div>
                </div>
                <div class="row gap">
                    <label class="col-sm-2 control-label"><span class="required">*</span> 广告状态</label>
                    <div class="col-sm-8">
                    <?php if(isset($form['ads_status'])){ ?>
                        <input type="radio" name="ads_status" id="ads_status1" value="0" <?php echo (isset($form['ads_status'])&&$form['ads_status']=='0')?'checked':'' ?>>暂停&nbsp;&nbsp;
                        <input type="radio" name="ads_status" id="ads_status2" value="1" <?php echo (isset($form['ads_status'])&&$form['ads_status']=='1')?'checked':'' ?>>开启
                    <?php }else{?>
                        <input type="radio" name="ads_status" id="ads_status1" value="0" checked>暂停&nbsp;&nbsp;
                        <input type="radio" name="ads_status" id="ads_status2" value="1" >开启
                    <?php }?>
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
<!--<script>
    $('#submit').on("click", function() {
        var username = $('#username').val();
        var password = $('#password').val();
        var repassword = $('#repassword').val();
        if(password!=repassword){
            $('#message-password').html('<font color="red">与密码不一致！</font>');
            return false;
        }
    });

</script>-->
</body>
</html>