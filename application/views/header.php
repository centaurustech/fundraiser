<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title><?=isset($data['title'])?$data['title']:'Fundaraiser'?></title>
	<link rel="stylesheet" href="/css/main.css">
	<script type="text/javascript" src="/js/jquery.min.js"></script>
	<script type="text/javascript" src="/js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="/js/script.js"></script>

<?php
	$CI =& get_instance();
	$CI->load->library('facebook/richfacebook');
	$args['next'] = "http://fundraiser.nteractivemarketing.com/auth/facebook_logout_callback";
	$facebook_logout_url = $CI->richfacebook->getLogoutUrl($args);

?>
	<script type="text/javascript">
		
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
					$("#facebook_login_button").hide();
					$("#wait_facebook").show();
					$.ajax({
						url: '<?=base_url()?>/auth/get_facebook_user_by_token'
						,data: {'access_token':response.authResponse.accessToken}
						,type: 'post'
						,success: function(data){
							console.log(data);
							
							if(!data.error && data.data){
								fbuser = data.data;
								$("#facebook_login_existing_button .avatar").attr('src',data.data.avatar);
								$("#facebook_login_existing_button .name").html(data.data.firstname + " " + data.data.lastname);
								$("#facebook_login_existing_button input[type='hidden']").val(data.data.facebook_access_token);
								$("#facebook_login_existing_button").show();
								$("#wait_facebook").hide();
							}else{
								fbuser = null;
								$("#facebook_login_existing_button").hide();
								$("#facebook_login_button").show();
								$("#wait_facebook").hide();
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
                <li><a href="/ad">Ads</a></li>
				<?php if($this->session->userdata('user')){ ?>
					<li><a href="/profile">Profile</a></li>
	                <li><a href="/ad/create">Create ad</a></li>
                    <li><a href="/ad/userAd">My ads</a></li>
					<li><a href="/auth/logout">Logout</a></li>
				<?php }else{ ?>
					<li><a onclick="show_login_form()">login</a></li>
					<li><a onclick="show_register_form()">Register</a></li>
				<?php } ?>
			</ul>
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