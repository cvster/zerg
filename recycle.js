function o2o_edit(title,url){
    var index = layer.open({
        type: 2,
        title: title,
        content: url
    });
    layer.full(index);
}

/*��ӻ��߱༭��С����Ļ*/
function o2o_s_edit(title,url,w,h){
    layer_show(title,url,w,h);
}
/*-ɾ��*/
function o2o_del(url){

    layer.confirm('ȷ��Ҫɾ����',function(index){
        window.location.href=url;
    });
}