<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title><?=isset($data['title'])?$data['title']:'Fundaraiser'?></title>
	<link rel="stylesheet" href="/css/main.css">
	<script type="text/javascript" src="/js/jquery.min.js"></script>
	<script type="text/javascript" src="/js/jquery.validate.min.js"></script>

<?php
	$CI =& get_instance();
	$CI->load->library('facebook/richfacebook');
	$args['next'] = "http://fundraiser.nteractivemarketing.com/auth/facebook_logout_callback";
	$facebook_logout_url = $CI->richfacebook->getLogoutUrl($args);

?>


	<script type="text/javascript">
		$(document).ready(function(){

			// console.log(screen.height);
			// console.log(screen.width);


			// console.log($(document).height());
			// console.log($(document).width());

			$(".close_modal_button").on('click',function(){
				hide_popup_wrapper();
				var validator
				
				validator = $("#login_form").validate();
				validator.resetForm();
				validator = $("#register_form").validate();
				validator.resetForm();
			});
		});

		function login(){
			//console.log('login');
			//console.log($("#login_form"));
			$("#login_form").validate({
				rules: {
					login_form_email: {required: true,email: true}
					,login_form_password: {required: true}
				},
				messages: {
					login_form_email: "Please enter a valid email address"
					,login_form_password: "Please enter password"
				},
				submitHandler: function(form){
					console.log($(form).serialize());
					$.ajax({
						url: "/auth/login"
						,type: "post"
						,data: $(form).serialize()
						,success: function(data){
							console.log(data);
						}
					});
				}
			});
			//console.log('login_end');
		}

		function register(){
			console.log('register');
			$("#register_form").validate({
				rules: {
					register_form_firstname: {required: true,minlength: 2}
					,register_form_lastname: {required: true,minlength: 2}
					,register_form_email: {required: true,email: true}
					,register_form_password: {required: true}
					,register_form_confirmpassword: {required: true, equalTo:"#register_form_password"}
				},
				messages: {
					register_form_firstname: { required: "Please enter your firstname", minlength: "Your firstname must consist of at least 2 characters" }
					,register_form_lastname: { required: "Please enter your lastname",	minlength: "Your lastname must consist of at least 2 characters" }
					,register_form_email: "Please enter a valid email address"
					,register_form_password: "Please enter password"
					,register_form_confirmpassword: "please enter same password"
				},
				submitHandler: function(form){
					$.ajax({
						url: "/auth/register"
						,type: "post"
						,data: $(form).serialize()
						,success: function(data){
							console.log(data);
						}
					});
				}
			});
		}


		function show_login_form(){
			$("#register_form_wrapper").hide();
			$("#login_form_wrapper").show();
			//$("#auth_popup_wrapper").css('margin-top','-'+$("#auth_popup_wrapper").outerHeight()/2+'px');
			$("#auth_popup_wrapper").show();
			$(".tabs .tab").removeClass('selected');
			$(".login_tab").addClass('selected');
		}

		function show_register_form(){
			$("#login_form_wrapper").hide();
			$("#register_form_wrapper").show();
			//$("#auth_popup_wrapper").css('margin-top','-'+$("#auth_popup_wrapper").outerHeight()/2+'px');
			$("#auth_popup_wrapper").show();
			$(".tabs .tab").removeClass('selected');
			$(".register_tab").addClass('selected');
		}

		function hide_popup_wrapper(){
			$(".popup_wrapper").hide();
		}

		function show_error(){
			$("#errors_wrapper").show();
		}

		function hide_error(){
			$("#errors_wrapper").html($("#errors_wrapper .close_errors")).hide();
		}

		var fbpopup;

		function fb_login(){
			var w = 650, h = 400;
			var top = (screen.height - h)/2, left = (screen.width - w)/2;
			if(top < 0) top = 0;
			if(left < 0) left = 0;
			var params = "width=" + w + ",height=" + h + ",resizable=yes,scrollbars=yes,status=yes,left=" + left + ",top=" + top;
			fbpopup = window.open("<?=base_url()?>auth/facebook_login", "Facebook", params);
		}

		function fb_logout(){
			var w = 650, h = 400;
			var top = (screen.height - h)/2, left = (screen.width - w)/2;
			if(top < 0) top = 0;
			if(left < 0) left = 0;
			var params = "width=" + w + ",height=" + h + ",resizable=yes,scrollbars=yes,status=yes,left=" + left + ",top=" + top;
			fbpopup = window.open("<?=$facebook_logout_url?>", "Facebook", params);
		}

		function fb_after_login(data){
			console.log('fb_after_login');
			fbpopup.close();
			console.log(data);
			var json = $.parseJSON(data);
			console.log(json);
			// $("#facebook_login_button").hide();
			// $("#facebook_logout_button").show();
		}

		function fb_after_logout(data){
			console.log('fb_after_logout');
			fbpopup.close();
			console.log(data);
			var json = $.parseJSON(data);
			console.log(json);
			// $("#facebook_logout_button").hide();
			// $("#facebook_login_button").show();
		}
	</script>

</head>
<body>
	<div id="fb-root"></div>
	<script type="text/javascript" src="https://connect.facebook.net/en_US/all.js"></script>
	<script type="text/javascript">
		FB.init({appId: '<?php $CI = &get_instance(); echo $CI->config->item("facebook_app_id"); ?>', status: true, cookie: true, xfbml: true});
		FB.getLoginStatus(function(response) { onStatus(response); });
		function onStatus(response) {
			if(response && response.authResponse !== null && response.authResponse.accessToken !== null){
				console.log(response);
				console.log(response.authResponse);
				console.log(response.authResponse.accessToken);
				$.ajax({
					url: 'auth/get_facebook_user_by_token'
					,data: {'access_token':response.authResponse.accessToken}
					,type: 'post'
					,success: function(data){
						console.log(data);
						if(!data.error && data.data){
							$("#facebook_login_existing_button .avatar").attr('src',data.data.avatar);
							$("#facebook_login_existing_button .name").html(data.data.firstname + " " + data.data.lastname);
							$("#facebook_login_existing_button input[type='hidden']").val(data.data.facebook_access_token);
							$("#facebook_login_existing_button").show();
						}
					}
				});
			}
			// if (response.session) {
			// 	var timestamp = new Date().getTime();
			// 	var expires = response['session']['expires'] * 1000;
			// 	if(expires - timestamp >= 0){
			// 		setTimeout(function(){window.location.reload();}, expires - timestamp);
			// 	}
			// }
		}
	</script>
	<?php $this->load->view('templates/auth',$data); ?>
	<div id="header">
		<pre id="session" class="debug_block" style="display:block;"><strong>SESSION:</strong><br/><?php print_r($this->session->userdata); ?></pre>
		<pre id="cookies" class="debug_block" style="display:block;"><strong>COOKIE:</strong><br/><?php print_r($_COOKIE); ?></pre>
		<div id="top_menu">
			<ul>
				<li><a href="/">Home</a></li>
				<li><a href="/profile">Profile</a></li>
                <li><a href="/ad">Ads</a></li>
			</ul>
		</div>
		<div id="auth_menu">
			<?php if($this->session->userdata('user')){ ?>
				<a href="/auth/logout">Logout</a>
                <a href="/ad/create">Create ad</a>
			<?php }else{ ?>
				<button onclick="show_login_form()">login</button>
				<button onclick="show_register_form()">Register</button>
			<?php } ?>
		</div>
		<div id="errors_wrapper">
			<div class="close_errors"></div>
			<?php
				if($this->session->userdata('error')){
					$errors = $this->session->userdata('error');
					if(is_array($errors)){
						foreach($errors as $error){
							$this->load->view('templates/error',array('error'=>$error));
						}
					}else{
						$this->load->view('templates/error',array('error'=>$errors));
					}
					$this->session->unset_userdata('error');
				}
			?>
		</div>
	</div>