
$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});


$(".like-button").click(function (event) {
    target = $(event.target);
    var current_like = target.attr("like-value");
    var user_id = target.attr("like-user");
    // 已经关注了
    if (current_like == 1) {
        // 取消关注
        $.ajax({
            url: "/user/" + user_id + "/unfan",
            method: "POST",
            //data: {"_token": _token},
            dataType: "json",
            success: function success(data) {
                if (data.error != 0) {
                    alert(data.msg);
                    return;
                }

                target.attr("like-value", 0);
                target.text("关注");
            }
        });
    } else {
        // 取消关注
        $.ajax({
            url: "/user/" + user_id + "/fan",
            method: "POST",
            //data: {"_token": _token},
            dataType: "json",
            success: function success(data) {
                if (data.error != 0) {
                    alert(data.msg);
                    return;
                }

                target.attr("like-value", 1);
                target.text("取消关注");
            }
        });
    }
});
