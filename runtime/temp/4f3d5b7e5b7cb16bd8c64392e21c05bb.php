<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:73:"D:\phpStudy\WWW\phone_app\public/../application/admin\view\admin\add.html";i:1506785746;s:76:"D:\phpStudy\WWW\phone_app\public/../application/admin\view\public\_meta.html";i:1506615826;s:78:"D:\phpStudy\WWW\phone_app\public/../application/admin\view\public\_footer.html";i:1506648129;}*/ ?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<link rel="Bookmark" href="/favicon.ico" >
<link rel="Shortcut Icon" href="/favicon.ico" />
<!--[if lt IE 9]>
<script type="text/javascript" src="__STATIC__/hui_admin/lib/html5shiv.js"></script>
<script type="text/javascript" src="__STATIC__/hui_admin/lib/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="__STATIC__/hui_admin/static/h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="__STATIC__/hui_admin/static/h-ui.admin/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="__STATIC__/hui_admin/lib/Hui-iconfont/1.0.8/iconfont.css" />
<link rel="stylesheet" type="text/css" href="__STATIC__/hui_admin/static/h-ui.admin/skin/default/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="__STATIC__/hui_admin/static/h-ui.admin/css/style.css" />
<!--[if IE 6]>
<script type="text/javascript" src="__STATIC__/hui_admin/lib/DD_belatedPNG_0.0.8a-min.js"></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
</head>
<body>
<article class="page-container">
    <form class="form form-horizontal" id="form-admin-add" method="post" action="<?php echo url('admin/add'); ?>">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>管理员名：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="用户名" id="username" name="username">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>密码：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="password" class="input-text" autocomplete="off" value="" placeholder="密码" id="password" name="password">
            </div>
        </div>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
            </div>
        </div>
    </form>
</article>

<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="__STATIC__/hui_admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="__STATIC__/hui_admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="__STATIC__/hui_admin/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="__STATIC__/hui_admin/static/h-ui.admin/js/H-ui.admin.js"></script>
<!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="__STATIC__/hui_admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="__STATIC__/hui_admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="__STATIC__/hui_admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<!--
<script type="text/javascript">
    $(function(){
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });

        $("#form-admin-add").validate({
            rules:{
                adminName:{
                    required:true,
                    minlength:4,
                    maxlength:16
                },
                password:{
                    required:true,
                },
                password2:{
                    required:true,
                    equalTo: "#password"
                },
                sex:{
                    required:true,
                },
                phone:{
                    required:true,
                    isPhone:true,
                },
                email:{
                    required:true,
                    email:true,
                },
                adminRole:{
                    required:true,
                },
            },
            onkeyup:false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
                $(form).ajaxSubmit({
                    type: 'post',
                    url: "xxxxxxx" ,
                    success: function(data){
                        layer.msg('添加成功!',{icon:1,time:1000});
                    },
                    error: function(XmlHttpRequest, textStatus, errorThrown){
                        layer.msg('error!',{icon:1,time:1000});
                    }
                });
                var index = parent.layer.getFrameIndex(window.name);
                parent.$('.btn-refresh').click();
                parent.layer.close(index);
            }
        });
    });
</script>-->
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>