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
        <div class="panel-heading">广告统计</span>
        </div>
        <div style="padding-top:10px;height: 60px">
            <form class="form-horizontal" role="form" style="display: inline" action='' method="get">
                <div style="margin-left: 10px">
                    <label>客户账户：</label>
                    <select id="client_id" name="client_id">
                        <?php
                        echo "<option value='0' selected>选择客户</option>";
                        foreach($clients as $k=>$v){
                            if(isset($form['client_id']) && $form['client_id']==$v['id']){
                                echo "<option value='{$v['id']}' selected>{$v['username']}</option>";
                            }else{
                                echo "<option value='{$v['id']}'>{$v['username']}</option>";
                            }
                        }
                        ?>
                    </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="hidden" name="c" value="admin"/>
                    <input type="hidden" name="m" value="advertismentInfo"/>
                    <input type="text" class="Wdate" placeholder="请选择查询日期" size="30" value="<?php echo isset($form['putdate'])?$form['putdate']:'' ?>" name="putdate" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'});"/>
                    <button type="submit" class="btn btn-primary btn-sm">查询</button>
                </div>
            </form>
        </div>
        <div><front color="red">账户消耗总额：<?php if(isset($count))echo $count.'￥'?></front></div>
        <table class="table table-hover table-striped" style="border:1px solid #D0D0D0">
            <thead>
            <tr>
                <th>广告任务名称</th>
                <th>广告主名称</th>
                <th>广告模式</th>
                <th>投放平台</th>
                <th>广告单价</th>
                <th>广告地址</th>
                <th>广告状态</th>
                <th>效率折扣</th>
                <th>该任务历史总消耗</th>
            </tr>
            </thead>
            <tbody>
            <?php
                if(!empty($ads)){
                    foreach($ads as $value){
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
                        echo "<td>{$value['sum_consume']}￥</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- 列表 End -->
    <?php if(!empty($consume)){?>
        <div id="container" class="panel panel-default">
        </div>
    <?php }?>

</div>

<script src="<?php echo base_url();?>share/bootstrap/js/jquery.js"></script>
<script src="<?php echo base_url();?>share/bootstrap/js/bootstrap.js"></script>
<script src="<?php echo base_url();?>share/bootstrap/js/admin/vip.dream.js"></script>
<script src="<?php echo base_url();?>share/bootstrap/js/switch/bootstrap-switch.min.js"></script>
<script src="<?php echo base_url();?>share/bootstrap/plugins/datepicker/WdatePicker.js"></script>
<script src="<?php echo base_url();?>share/bootstrap/js/highcharts.js"></script>
<script>
    $(function () {
        var options = {};
        options.categories = new Array();
        options.series = new Array();
        options.categories = <?php echo !empty($consume)?$consume["xAxis"]:"[]"?>;
        options.series = <?php echo !empty($consume)?$consume["yAxis"]:"[]"?>;
        showData(options);
    });

function showData(options){
    Highcharts.chart('container', {
        title: {
            text: '广告统计数据',
            x: -20 //center
        },
        subtitle: {
            text: '',
            x: -20
        },
        xAxis: {
            categories: options.categories
        },
        yAxis: {
            title: {
                text: '消耗值'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: '￥'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: options.series,
        plotOptions:{
            line:{
                dataLabels:{
                    enabled:true
                }
            }
        },
        credits: {
            enabled: false
        }
    });
}
</script>
</body>
</html>