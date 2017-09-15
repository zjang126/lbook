$.ajaxSetup({
    headers:{//laravel的ajax验证,需要在meta 加个token
        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
    }
});

$(".post-audit").click(function (event) {
    taraget=$(event.target);
    var post_id=taraget.attr('post-id');
    var status=taraget.attr("post-action-status");
//审核文章js
    $.ajax({
        url:"/admin/posts/"+post_id+"/status",
        method:"POST",
        data:{"status":status},
        dataType:"json",
        success:function (data) {
            if(data.error!=0){
                alert(data.msg);
                return ;
            }
            taraget.parent().parent().remove();
        }
    });
});

$(".resource-delete").click(function (event) {
    if(confirm("确定要删除吗?")==false){
        return ;
    }
    var  target=$(event.target);
    event.preventDefault();
    var url=$(target).attr('delete-url');
    $.ajax({
        url:url,
        method:"POST",
        data:{"_method":'DELETE'},
        dataType:"json",
        success:function(data) {
            if(data.error!=0){
                alert(data.msg);
                return;
            }
            window.location.reload();
        }
    })
});