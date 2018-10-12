
$(function() {
    $("#file_upload").uploadify({
        'swf'              : "/static/admin/uploadify/uploadify.swf",       //'swf'              : SCOPE.uploadify_swf,
        'uploader'        : SCOPE.image_upload_url,     //'uploader'        : SCOPE.image_upload_url,

        'buttonText'      : '图片上传',
        'fileTypeDesc'    : 'Image files',
        'fileObjName'     : 'file',
        'fileTypeExts'    : '*.gif; *.jpg; *.jpge; *.png',
        'onUploadSuccess' : function(file, data, response) {
            console.log('file ');
            console.log(file);
            console.log('data ');
            console.log(data);
            console.log('response ');
            console.log(response);
            if(response)
            {
                var dataParse = JSON.parse(data);
                $("#upload_org_code_img").attr('src',dataParse.data);
                console.log(dataParse.data);
                $("#upload_org_code_img").show();
                toastr.success('上传完成');
            }
            else
                toastr.success('上传失败');
        }
    });
});