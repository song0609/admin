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
        <!-- 统计图 -->
        <?php if(!empty($consume)){?>
            <div id="container" class="panel panel-default">
            </div>
        <?php }?>
        <div>
            <front color="red">账户消耗总额：<?php if(isset($count))echo $count.'￥'?></front>&nbsp;&nbsp;&nbsp;&nbsp;
            <front color="red">账户余额：<?php echo round($total_count-$count,2).'￥'?></front>
        </div>
        <div style="padding-top:10px;height: 60px">
            <form class="form-horizontal" role="form" style="display: inline" action='' method="get">
                <div style="margin-left: 1px">
                    <input type="hidden" name="c" value="client"/>
                    <input type="hidden" name="m" value="advertismentInfo"/>
                    任务：
                    <select id="ads" name="ads">
                        <?php
                        echo "<option value='0'>全部</option>";
                        foreach($ads as $v){
                                if(isset($form['ads']) && $form['ads']==$v['id']){
                                    echo "<option value='{$v['id']}' selected>{$v['ads_name']}</option>";
                                }else{
                                    echo "<option value='{$v['id']}'>{$v['ads_name']}</option>";
                                }
                            }
                        ?>
                    </select>
                    日期：
                    <input type="text" class="Wdate" placeholder="请选择开始日期" size="30" value="<?php echo isset($form['sdate'])?$form['sdate']:'' ?>" name="sdate" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'});"/>&nbsp;到&nbsp;
                    <input type="text" class="Wdate" placeholder="请选择结束日期" size="30" value="<?php echo isset($form['edate'])?$form['edate']:'' ?>" name="edate" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'});"/>
                    <button type="submit" class="btn btn-primary btn-sm">查询</button>
                    <font color="red"><?php echo isset($error)?$error:''; ?></font>
                </div>
            </form>
        </div>

        <table class="table table-hover table-striped" style="border:1px solid #D0D0D0">
            <thead>
            <tr>
                <th>日期</th>
                <th>消耗</th>
            </tr>
            </thead>
            <tbody>
            <?php
                if(!empty($consume_list)){
                    foreach($consume_list as $value){
                        echo "<tr>";
                        echo "<td>{$value['time']}</td>";
                        echo "<td>{$value['real_consume']}￥</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- 列表 End -->


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