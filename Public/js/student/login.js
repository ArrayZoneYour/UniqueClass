/**
 *前端登录业务类
 *@author liyidong
 */

var login = {
	check : function(){
		// 获取登录页面中的用户名和密码
		var student_number = $('input[name="student_number"]').val();
		var password = $('input[name="password"]').val();

		// if(!student_number){
		// 	dialog.error('学号不能为空！');
		// }
		// if(!password){
		// 	dialog.error('密码不能为空！');
		// }
		var url = "login.html";
		var data = {'student_number':student_number,'password':password}
		// 执行异步请求 $.post
		$.post(url,data,function(result){
			if(result.status == 0){
				dialog.error(result.message);
			}
			if(result.status == 1){
				dialog.success(result.message , '../Student/userInfo.html');
			}
		},'JSON');
	}
}