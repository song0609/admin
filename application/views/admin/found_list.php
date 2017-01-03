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
        <div class="panel-heading">招领信息 &nbsp; <span class="badge"><?php echo $total;?></span></div>
        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th>拾获地点</th>
                <th>拾获时间</th>
                <th>类型</th>
                <th>备注</th>
                <th>联系方式</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach($data as $value){
                echo "<tr>";
                echo "<td>{$value['happen_place']}</td>";
                echo "<td>{$value['happen_time']}</td>";
                echo "<td>{$value['type_name']}</td>";
                echo "<td>{$value['remarks']}</td>";
                echo "<td>{$value['phone']}</td>";
                echo "<td>";
                if($value['is_display']==1){
                    echo "<input type='checkbox' class='mySwitch' name='switch' checked data-size='large' data-on-text='显示' data-off-text='隐藏' value='{$value['id']}'>&nbsp;";
                }else{
                    echo "<input type='checkbox' class='mySwitch' name='switch' data-size='large' data-on-text='显示' data-off-text='隐藏' value='{$value['id']}'>&nbsp;";
                }
                echo "<button class='btn btn-danger btn-sm' data-role='delbutton' value='{$value['id']}'> 删除</button>&nbsp;";
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
    <div class="modal fade modal-alert" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body">是否确定删除？</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">取消</button>
                    <button type="button" data-role="submitbutton" class="btn btn-primary btn-sm">确定</button>
                </div>
            </div>
        </div>
    </div>
    <!-- 提示模态框 End -->

</div>

<script src="<?php echo base_url();?>share/bootstrap/js/jquery.js"></script>
<script src="<?php echo base_url();?>share/bootstrap/js/bootstrap.js"></script>
<script src="<?php echo base_url();?>share/bootstrap/js/admin/vip.dream.js"></script>
<script src="<?php echo base_url();?>share/bootstrap/js/switch/bootstrap-switch.min.js"></script>
<script>

    // 提示模态框
    var alertModal = function(elem,i) {

        console.log(ts);

        var ts  = $(elem),
            btn = ts.find('[data-role="submitbutton"]');

        ts.modal('show');

        btn.off("click");
        btn.on("click", function() {
            $.ajax({
                type: "GET",
                url: "<?php echo site_url('c=admin&m=delfoundlost');?>",
                data: "id="+i,
                success: function(msg){
                    history.go(0);
                }
            });
        });

    };

    //
    $('[data-role="delbutton"]').on("click", function() {

        // To Do Something
        var i = $(this).val();
        alertModal(".modal-alert",i);
    });


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
                url: "<?php echo site_url('c=admin&m=displayfoundlost');?>",
                data: "id="+id+"&state="+state,
                success: function(msg){
                }
            });

        }
    });
</script>
</body>
</html>