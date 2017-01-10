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
<div id="container">

    <!-- Header -->
    <header id="header">

        <!-- Logo -->
        <div class="logo"></div>
        <!-- Logo End -->

        <!-- Main Menu -->
        <nav class="main-menu">
            <!--<a href="<?php /*echo site_url('c=admin&m=welcome');*/?>" data-id="m0" target="main-frame" class="on"><i class="glyphicon glyphicon-home"></i> 首页</a>
            <a href="javascript:void(0);" data-id="m1"><i class="glyphicon glyphicon-th-list"></i> 校园服务</a>
            <a href="javascript:void(0);" data-id="m2"><i class="glyphicon glyphicon-cog"></i> 用户管理</a>-->
        </nav>
        <!-- Main Menu End -->

        <div class="username btn-group pull-right">
            <a href="javascript:void(0);" class="user-btn dropdown-toggle" data-toggle="dropdown">
                <i class="glyphicon glyphicon-user"></i> <?php echo "欢迎&nbsp;&nbsp;&nbsp;&nbsp;".$username;?><span class="caret"></span>
            </a>
            <ul class="dropdown-menu arrow" role="menu">
                <li><a href="<?php echo site_url('c=admin&m=logout');?>">退出 <i class="glyphicon glyphicon-log-out"></i></a></li>
            </ul>
        </div>
        <!-- User End -->

    </header>
    <!-- Header End -->

    <!-- Sidebar -->
    <div id="sidebar"><ul class="tree-menu"></ul></div>
    <a id="sidebar-btn" href="javascript:void(0);"></a>
    <!-- Sidebar End -->

    <!-- Main -->
    <div id="main">
        <iframe id="main-frame" name="main-frame" frameborder="0" src="<?php echo site_url('c=admin&m=getAdvertiserList');?>"></iframe>
    </div>
    <!-- Main End -->

    <!-- 全屏模态框 -->
    <div class="modal fade modal-alert" id="fs-dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body"></div>
                <div class="modal-footer"><button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">确定</button></div>
            </div>
        </div>
    </div>
    <!-- 全屏模态框 End -->

</div>

<script>
var menu_config = [
    {
        id: "m0",
        menu: [
            {
                text: "广告主管理",
                items: [],
                href: "<?php echo site_url('c=admin&m=getAdvertiserList');?>"
            },
            {
                text: "广告管理",
                items: [],
                href: "<?php echo site_url('c=admin&m=test');?>"
            },
            {
                text: "财务管理",
                items: [],
                href: "<?php echo site_url('c=admin&m=test');?>"
            },
            {
                text: "广告统计",
                items: [],
                href: "<?php echo site_url('c=admin&m=test');?>"
            },
            {
                text: "管理员账户管理",
                items: [
                    {
                        text: "新增管理员",
                        items: [],
                        href: "<?php echo site_url('c=admin&m=addadmin');?>"
                    },
                    {
                        text: "修改密码",
                        items: [],
                        href: "<?php echo site_url('c=admin&m=password');?>"
                    }
                ],
                href: ""
            }
        ]
    }/*,
    {
        id: "m1",
        menu: [
            {
                text: "兼职平台",
                items: [],
                href: "<?php echo site_url('c=admin&m=parttime');?>"
            },
            {
                text: "失物招领平台",
                items: [
                    {
                        text: "寻物信息管理",
                        items: [],
                        href: "<?php echo site_url('c=admin&m=lost');?>"
                    },
                    {
                        text: "招领信息管理",
                        items: [],
                        href: "<?php echo site_url('c=admin&m=found');?>"
                    },
                    {
                        text: "类别管理",
                        items: [],
                        href: "<?php echo site_url('c=admin&m=foundlosttype');?>"
                    }
                ],
                href: ""
            }
        ]
    },
    {
        id: "m2",
        menu: [
            {
                text: "新增用户",
                items: [],
                href: "<?php echo site_url('c=admin&m=addadmin');?>"
            },
            {
                text: "修改密码",
                items: [],
                href: "<?php echo site_url('c=admin&m=password');?>"
            }
        ]
    }*/
];
</script>
<script src="<?php echo base_url();?>share/bootstrap/js/jquery.js"></script>
<script src="<?php echo base_url();?>share/bootstrap/js/bootstrap.js"></script>
<script src="<?php echo base_url();?>share/bootstrap/js/admin/vip.dream.js"></script>
<script src="<?php echo base_url();?>share/bootstrap/js/admin/vip.main.js"></script>
</body>
</html>