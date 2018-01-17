/*
 * 公用的form表单提交方法
 */
function myapp_save(form) {
    var data = $(form).serialize()

    var url = $(form).attr('url')

    $.post(url, data, function (result) {
        if(result.code == 0){
            layer.msg(result.msg,{time:2000,icon:5})
        }else if(result.code == 1){
            layer.msg(result.msg, {time:2000,icon:6}, function () {
                var index = layer.load();
                self.location = result.data.jump_url;
            })
        }
    },'JSON')
}