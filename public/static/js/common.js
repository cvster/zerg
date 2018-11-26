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



function formatDateToString(time) {
    var date=new Date(time);
    var y = date.getFullYear();
    var m = date.getMonth() + 1;
    var d = date.getDate();
    var hour = date.getHours().toString();
    var minutes = date.getMinutes().toString();
    var seconds = date.getSeconds().toString();
    if (hour < 10) {
        hour = "0" + hour;
    }
    if (minutes < 10) {
        minutes = "0" + minutes;
    }
    if (seconds < 10) {
        seconds = "0" + seconds;
    }
    return  y + '-' + (m < 10 ? ('0' + m) : m) + '-' + (d < 10 ? ('0' + d) : d) + " " + hour + ":" + minutes + ":" + seconds;
}


function formatDateToStringYMD(time) {
    var date=new Date(time);
    var y = date.getFullYear();
    var m = date.getMonth() + 1;
    var d = date.getDate();
    return  y + '-' + (m < 10 ? ('0' + m) : m) + '-' + (d < 10 ? ('0' + d) : d);
}


//当服务器返回结果为json形式时，{code，msg，data}
//如果code=1则用toastr.success显示成功消息并刷新父页面，如果code=0，则用toastr.error显示失败消息
function echoResult(result) {
    //console.log(result);//打印服务端返回的数据(调试用)
    toastr.options={timeout:5000, positionClass: "toast-top-center"};
    if (result.code == 1) {
        toastr.success("保存成功");
    }
    if (result.code == 0) {
        toastr.error('警告：'+result.msg);
    }
    if(result.code == 3){
        toastr.warning(result.msg);
        window.location.href = "{:url('user/admin')}";
    }
}