$(function() {
    $("#file_upload").uploadify({
        swf           : swf,
        uploader      : image_upload_url,
        buttonText    : '图片上传',
        fileObjName   : 'file',
        auto          : true,
        fileTypeDesc  : 'image files',
        fileTypeExts  : '*.png;*.jpg;*.gif',
        /*
         * file 成功上传后返回来的文件对象
         * data 后台脚本返回来的数据
         * response 服务器是否成功返回响应内容 bool
         */
        onUploadSuccess : function(file, data, response){
            if(response){
                var obj = JSON.parse(data)
                console.log(obj.data)
                var imageObj = $('#upload_org_code_img')
                imageObj.attr('src',obj.data)
                $('#file_upload_image').val(obj.data)
                imageObj.show()
            }

        }
    });
});