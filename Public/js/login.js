/**
 * 前端登录类
 * @author Li Yidong
 */
var login = {
    check : function() {
        // 获取登录页面中的用户名 和 密码
        var username = $('input[name="username"]').val();
        var password = $('input[name="password"]').val();
        // console.log(username);
        if(!username) {
            dialog.error('用户名不能为空');
        }
        if(!password) {
            dialog.error('密码不能为空');
        }

        var data = {'username':username,'password':password};
        // 执行异步请求  $.post
        $.post(url_check,data,function(result){
            if(result.status == 0) {
                return dialog.error(result.message);
            }
            if(result.status == 1) {
                return dialog.success(result.message, url_index);
            }

        },'JSON');

    }
}