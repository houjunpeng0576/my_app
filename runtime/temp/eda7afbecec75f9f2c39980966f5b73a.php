<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:77:"D:\wamp\www\demo\htdocs\my_app\public/../application/admin\view\news\add.html";i:1516131796;s:81:"D:\wamp\www\demo\htdocs\my_app\public/../application/admin\view\public\_meta.html";i:1512919205;s:83:"D:\wamp\www\demo\htdocs\my_app\public/../application/admin\view\public\_footer.html";i:1512919205;}*/ ?>
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
<link rel="stylesheet" type="text/css" href="__STATIC__/admin/uploadify/uploadify.css" />
<!--[if IE 6]>
<script type="text/javascript" src="__STATIC__/hui_admin/lib/DD_belatedPNG_0.0.8a-min.js"></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<script>
    swf = '__STATIC__/admin/uploadify/uploadify.swf';
    image_upload_url = "<?php echo url('image/qiniuUpload'); ?>";
</script>
</head>
<body>
<div class="page-container">
    <form method="post" class="form form-horizontal" id="form-news-add" url="<?php echo url('news/add'); ?>">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>产品标题：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" id="title" name="title">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">简略标题：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" id="small_title" name="small_title">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>分类栏目：</label>
            <div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="catid" class="select" id="cat">
                    <?php if(is_array($cats) || $cats instanceof \think\Collection || $cats instanceof \think\Paginator): $i = 0; $__LIST__ = $cats;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <option value="<?php echo $key; ?>"><?php echo $vo; ?></option>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
					<!--<option value="11">├二级分类</option>-->
				</select>
				</span> </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">文章摘要：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea name="description" id="description" class="textarea"  placeholder="说点什么...最少输入10个字符" datatype="*10-100" dragonfly="true" nullmsg="备注不能为空！" onKeyUp="$.Huitextarealength(this,200)"></textarea>
                <p class="textarea-numberbar"><em class="textarea-length">0</em>/200</p>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">允许评论：</label>
            <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                <div class="check-box">
                    <input type="checkbox" id="checkbox-1" name="is_allowcomments" value="1">
                    <label for="checkbox-1">&nbsp;</label>
                </div>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">是否推荐到首页头图：</label>
            <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                <div class="check-box">
                    <input type="checkbox" id="checkbox-2" name="is_head_figure" value="1">
                    <label for="checkbox-2">&nbsp;</label>
                </div>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">允许是否推荐：</label>
            <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                <div class="check-box">
                    <input type="checkbox" id="checkbox-3" name="is_position" value="1">
                    <label for="checkbox-3">&nbsp;</label>
                </div>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">缩略图：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="file" id="file_upload" multiple="true" name="file" id="file" readonly nullmsg="请添加附件！">
                <img src="" id="upload_org_code_img" width="150" height="150" style="display: none">
                <input type="hidden" name="image" id="file_upload_image" multiple="true" value="">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">详细内容：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <script id="editor" type="text/plain" style="width:100%;height:400px;"></script>
            </div>
        </div>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                <button onClick="article_save_submit();" class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存并提交审核</button>
                <button onClick="article_save();" class="btn btn-secondary radius" type="button"><i class="Hui-iconfont">&#xe632;</i> 保存草稿</button>
                <button onClick="layer_close();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript" src="__STATIC__/hui_admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="__STATIC__/hui_admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="__STATIC__/hui_admin/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="__STATIC__/hui_admin/static/h-ui.admin/js/H-ui.admin.js"></script>

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="__STATIC__/hui_admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="__STATIC__/hui_admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="__STATIC__/hui_admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="__STATIC__/hui_admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript" src="__STATIC__/hui_admin/lib/ueditor/1.4.3/ueditor.config.js"></script>
<script type="text/javascript" src="__STATIC__/hui_admin/lib/ueditor/1.4.3/ueditor.all.min.js"> </script>
<script type="text/javascript" src="__STATIC__/hui_admin/lib/ueditor/1.4.3/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" src="__STATIC__/admin/uploadify/jquery.uploadify.min.js"> </script>
<script type="text/javascript" src="__STATIC__/admin/js/image.js"></script>
<script type="text/javascript" src="__STATIC__/admin/js/common.js"></script>
<script type="text/javascript">
    $(function(){
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });
    });

    //表单验证
    $("#form-news-add").validate({
        rules:{
            title:{
                required:true,
            },
            small_title:{
                required:true,
            },
            file:{
                required:true,
            }
        },
        messages:{

        },
        onkeyup:false,
        focusCleanup:true,
        success:"valid",
        submitHandler:function(form){
            myapp_save(form);
            //$(form).ajaxSubmit();
            // var index = parent.layer.getFrameIndex(window.name);
            //parent.$('.btn-refresh').click();
            // parent.layer.close(index);
        }
    });

    $(function(){
        var ue = UE.getEditor('editor',{textarea:'content'});
    });
</script>
</body>
</html>