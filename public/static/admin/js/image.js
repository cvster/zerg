
$(function() {
    $("#file_upload").uploadify({
        'swf'                : "/static/admin/uploadify/uploadify.swf",
        // 'formData'          :  $("form").serialize(),
        'uploader'          : SCOPE.image_upload_url,
        'multi'              : SCOPE.uploadify_multi,
        'buttonText'        : '图片上传',
        'fileTypeDesc'      : 'Image files',
        'fileObjName'       : 'file',
        'fileTypeExts'      : '*.gif; *.jpg; *.jpge; *.png',
        'onUploadSuccess'   : function(file, data, response) {
            console.log('1-file: ');
            console.log(file);
            console.log('2-data: ');
            console.log(data);
            console.log('3-response: ');
            console.log(response);
            if(response)
            {
                var dataParse = JSON.parse(data);
                var imageUrl = dataParse.imgUrl;

                $("#upload_img_show").attr('src',imageUrl);//显示图片
                $("#imgId").attr('value',dataParse.imgId);//将图片id存入form表单的一个隐藏input中,提交时传给服务器

                $("#upload_img_show").show();
                toastr.success('上传完成');
            }
            else
                toastr.success('上传失败');
        }
    });
});