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
    <link rel="stylesheet" href="<?php echo base_url();?>share/bootstrap/js/switch/bootstrap-switch.min.css">
</head>

<body>

<div class="container">
    <!-- 列表 -->
    <div class="panel panel-default">
        <div class="panel-heading">广告管理 &nbsp; <span class="badge"><?php echo $total;?></span>
        </div>
        <table class="table table-hover table-striped">

            <thead>
            <tr>
                <th>广告名称</th>
                <th>广告模式</th>
                <th>投放平台</th>
                <th>广告单价</th>
                <th>广告地址</th>
                <th>广告状态</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach($data as $value){
                echo "<tr>";
                echo "<td>{$value['ads_name']}</td>";
                echo "<td>{$value['ads_type']}</td>";
                echo "<td>{$value['platform']}</td>";
                echo "<td>{$value['price']}</td>";
                echo "<td>{$value['ads_url']}</td>";
                $status = ($value['ads_status']=='0')?'暂停':'开启';
                echo "<td>".$status."</td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
        <div class="panel-footer" align="center">
            <?php
            echo $pagination;
            ?>
        </div>
    </div>
    <!-- 列表 End -->


</div>

<script src="<?php echo base_url();?>share/bootstrap/js/jquery.js"></script>
<script src="<?php echo base_url();?>share/bootstrap/js/bootstrap.js"></script>
<script src="<?php echo base_url();?>share/bootstrap/js/admin/vip.dream.js"></script>
<script src="<?php echo base_url();?>share/bootstrap/js/switch/bootstrap-switch.min.js"></script>
<script>
</script>
</body>
</html>