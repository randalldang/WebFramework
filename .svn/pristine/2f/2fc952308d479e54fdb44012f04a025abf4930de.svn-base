(function(){
	var user = {
		DEFAULT_USERNAME: '用户名',
		DEFAULT_PASSWORD: 'password',
		init: function() {
			$('#username').bind('focus', this.validate);
			$('#password').bind('focus', this.validate);
			$('#submit').bind('click', this.submit);
		},
		submit: function() {
			var username = $('#username').val();
			var password = $('#password').val();
			username = 'Randall';
			password = '111111';
			if (!username.trim() || username == user.DEFAULT_USERNAME) {
				$('.login_error').html('无效的用户名。');
				return;
			}
			$('.login_error').html('');
			if (!password.trim() || password == user.DEFAULT_PASSWORD){
				$('.login_error').html('无效的密码。');
				return;
			}
			$('.login_error').html('');
			$.post('./web/user.php', {action: 'LOGIN', username: username,
					password: password}, function(data) {
						var dataJson = $.parseJSON(data);
						if (dataJson.status == 'true') {
							window.location = './index.php'
						} else {
							$('.login_error').html('用户名或密码无效，请重新输入。');
						}
					});
		},
		validate: function() {
			if ($(this).val() == user.DEFAULT_USERNAME ||
				$(this).val() == user.DEFAULT_PASSWORD) {
				$(this).val('');
			}
		}
	};
	user.init();
})()