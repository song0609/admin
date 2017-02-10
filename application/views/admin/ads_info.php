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
                    <input type="text" class="Wdate" placeholder="请选择查询日期" size="30" value="" name="putdate" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'});"/>
                    <button type="submit" class="btn btn-primary btn-sm">查询</button>
                </div>
            </form>
        </div>
        <table class="table table-hover table-striped">

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
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- 列表 End -->

    <div id="container" class="panel panel-default">
    </div>

</div>

<script src="<?php echo base_url();?>share/bootstrap/js/jquery.js"></script>
<script src="<?php echo base_url();?>share/bootstrap/js/bootstrap.js"></script>
<script src="<?php echo base_url();?>share/bootstrap/js/admin/vip.dream.js"></script>
<script src="<?php echo base_url();?>share/bootstrap/js/switch/bootstrap-switch.min.js"></script>
<script src="<?php echo base_url();?>share/bootstrap/plugins/datepicker/WdatePicker.js"></script>
<script src="<?php echo base_url();?>share/bootstrap/js/highcharts.js"></script>
<script src="<?php echo base_url();?>share/bootstrap/js/exporting.js"></script>
<script>
    $(function () {
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
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
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
            series: [{
                name: 'Tokyo',
                data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
            }, {
                name: 'New York',
                data: [-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]
            }, {
                name: 'Berlin',
                data: [-0.9, 0.6, 3.5, 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0, 3.9, 1.0]
            }, {
                name: 'London',
                data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
            }]
        });
    });
</script>
</body>
</html>