/*页面 全屏-添加*/

//$('.listorder input')，jQuery, 表示listorder样式，下面的input标签
$('.listorder input').blur(function() {
    //input失去焦点时抛送给服务器对应的参数
    var id = $(this).attr('attr-id');
    var listorder = $(this).val();
    var url = SCOPE.listorder_url;
    var postData={
        'id': id,
        'listorder': listorder,
    };

    $.post(url, postData, function(result) {
        //回调函数，post给服务器的url，返回结果是result，在这里处理
        if(result.code == 1){
            toastr.success("更新成功");
            // location.reload();//刷新网页，使其按照listorder排序.刷新不舒服，不刷新了。
        }else if(result.code == 0){
            toastr.error(result.msg);
        }//result.code == 2 表示数据没有变化。
    },"json");
});


function sleep(numberMillis) {
    var now = new Date();
    var exitTime = now.getTime() + numberMillis;
    while (true) {
        now = new Date();
        if (now.getTime() > exitTime)
            return;
    }
}


//建立一個可存取到form input选择的file的url
function getObjectURL(file) {
    var url = null ;
    // 下面函数执行的效果是一样的，只是需要针对不同的浏览器执行不同的 js 函数而已
    if (window.createObjectURL!=undefined) { // basic
        url = window.createObjectURL(file) ;
    } else if (window.URL!=undefined) { // mozilla(firefox)
        url = window.URL.createObjectURL(file) ;
    } else if (window.webkitURL!=undefined) { // webkit or chrome
        url = window.webkitURL.createObjectURL(file) ;
    }
    return url ;
}
