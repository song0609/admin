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
    <form class="form-horizontal" role="form" method="post" action="<?php echo site_url('c=admin&m=saveFinance');?>">
        <div class="panel panel-default">
            <div class="panel-heading">添加记录
                <span><a href="<?php echo site_url('c=admin&m=getFinanceList') ?>" class="btn btn-large btn-primary" style="padding: 0">返回</a></span>
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
                    <label class="col-sm-2 control-label"><span class="required">*</span> 充值金额</label>
                    <div class="col-sm-8">
                        <input id="money" name="money" type="text" class="form-control" value="<?php echo isset($form['money'])?$form['money']:'' ?>" placeholder="充值金额">
                    </div>
                    <div class="col-sm-2" id="message-money">
                        <font color="red"><?php echo isset($errors)?$errors['money']:''; ?></font>
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
                    <label class="col-sm-2 control-label"> 备注</label>
                    <div class="col-sm-8">
                        <input id="note" name="note" type="note" class="form-control" value="<?php echo isset($form['note'])?$form['note']:''?>" placeholder="备注">
                    </div>
                    <div class="col-sm-2" id="message-note">
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
</body>
</html>