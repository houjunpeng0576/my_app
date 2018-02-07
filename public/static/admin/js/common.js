/* 公用的form表单提交方法 */
function myapp_save(form) {
    var data = $(form).serialize()

    var url = $(form).attr('url')

    $.post(url, data, function (result) {
        if(result.code == 0){
            layer.msg(result.msg,{time:2000,icon:5})
        }else if(result.code == 1){
            layer.msg(result.msg, {time:2000,icon:6}, function () {
                var index = layer.load();
                if(result.data.type == 2){
                    var index = parent.layer.getFrameIndex(window.name);
                    //parent.$('.btn-refresh').click();
                    parent.location.href = result.data.jump_url
                    parent.layer.close(index);
                }
                self.location = result.data.jump_url;
            })
        }
    },'JSON')
}

/* 通用化-删除逻辑 */
function app_del(obj,id){
    layer.confirm('确认要删除吗？',function(index){
        $.ajax({
            type: 'POST',
            url: delete_url,
            dataType: 'json',
            data:{id:id},
            success: function(data){
                if(data.code == 1){
                    if(pageCount == 1 && currentPage > 1){
                        currentPage--;
                    }
                    // $(obj).parents("tr").remove();
                    layer.msg('已删除!',{icon:1,time:1000},function () {
                        self.location = data.data.jump_url + (data.data.jump_url.indexOf('?') < 1 ? '?' :'&') + 'page=' + currentPage
                    });
                }else{
                    layer.msg(data.msg,{icon:2,time:2000})
                }
            },
            error:function(data) {
                console.log(data.msg);
            },
        });
    });
}

/* 通用化-分页 */
function execPage() {
    laypage({
        cont: 'laypage',//分页容器的id
        pages: lastPage, //总页数
        curr:currentPage, //当前页
        first:'首页',
        last:'末页',
        prev:'上一页',
        next:'下一页',
        skin: 'default',  //当前页的颜色
        skip: true,
        jump:function(e,first){
            if(!first){
                location.href = url + '&page='+e.curr;
            }
        }
    });
}