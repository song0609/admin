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
            <!--<button type="button" class="btn btn-primary btn-sm">添加广告主</button>-->
            <span><a href="<?php echo site_url("c=admin&m=addAdvertisment")?>" class="btn btn-large btn-primary" style="padding: 0">添加广告</a></span>
        </div>
        <table class="table table-hover table-striped">

            <thead>
            <tr>
                <th>广告名称</th>
                <th>广告主名称</th>
                <th>广告模式</th>
                <th>投放平台</th>
                <th>广告单价</th>
                <th>广告地址</th>
                <th>广告状态</th>
                <th>效率折扣</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach($data as $value){
                echo "<tr>";
                echo "<td>{$value['ads_name']}</td>";
                echo "<td>{$clients[$value['client_id']]['username']}</td>";
                echo "<td>{$value['ads_type']}</td>";
                echo "<td>{$value['platform']}</td>";
                echo "<td>{$value['price']}</td>";
                echo "<td>{$value['ads_url']}</td>";
                $status = ($value['ads_status']=='0')?'暂停':'开启';
                echo "<td>".$status."</td>";
                echo "<td>{$value['discount']}</td>";
                echo "<td>";
                echo '<a href="'.site_url("c=admin&m=editAdvertisment&id={$value['id']}").'" class="btn btn-large btn-primary" style="padding: 0">编辑</a>&nbsp;';
                echo "</td>";
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

    <!-- 提示模态框 -->
    <!--<div class="modal fade modal-alert" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body">是否确定删除？</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">取消</button>
                    <button type="button" data-role="submitbutton" class="btn btn-primary btn-sm">确定</button>
                </div>
            </div>
        </div>
    </div>-->
    <!-- 提示模态框 End -->

</div>

<script src="<?php echo base_url();?>share/bootstrap/js/jquery.js"></script>
<script src="<?php echo base_url();?>share/bootstrap/js/bootstrap.js"></script>
<script src="<?php echo base_url();?>share/bootstrap/js/admin/vip.dream.js"></script>
<script src="<?php echo base_url();?>share/bootstrap/js/switch/bootstrap-switch.min.js"></script>
<script>

    //
    $('.mySwitch').bootstrapSwitch();

    $('.mySwitch').on({

        'init.bootstrapSwitch': function() {

            //alert("初始化");
        },
        'switchChange.bootstrapSwitch': function(event, state) {
            var id = $(this).val();
            $.ajax({
                type: "GET",
                url: "<?php echo site_url('c=admin&m=statusAdvertiser');?>",
                data: "id="+id+"&status="+state,
                success: function(msg){
                    alert("更新成功");
                }
            });

        }
    });
</script>
</body>
</html>