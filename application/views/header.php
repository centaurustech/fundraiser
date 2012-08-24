<!DOCTYPE html>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8" />

	<!-- Set the viewport width to device width for mobile -->
	<meta name="viewport" content="width=device-width" />

	<title>STAfund</title>

	<!-- Included CSS Files (Uncompressed) -->
	<!--
	<link rel="stylesheet" href="stylesheets/foundation.css">
	-->

	<!-- Included CSS Files (Compressed) -->
	<link rel="stylesheet" href="/css/foundation.css">
	<link rel="stylesheet" href="/css/custom.css">

	<link rel="stylesheet" href="/css/main.css">

	<script type="text/javascript">
		<?php
			$CI =& get_instance();
			$CI->load->library('facebook/richfacebook');
			$args['next'] = base_url() . "/auth/facebook_logout_callback";
			$facebook_logout_url = $CI->richfacebook->getLogoutUrl($args);
		?>
		var BASE_URL = "<?php echo base_url(); ?>";
		var FACEBOOK_LOGOUT_URL = "<?php echo $facebook_logout_url; ?>";
	</script>

	<script type="text/javascript" src="/js/jquery.min.js"></script>

	<!-- IE Fix for HTML5 Tags -->
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

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
					url: '<?=base_url()?>auth/get_facebook_user_by_token'
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

		}
	</script>

		<pre id="session" class="debug_block" style="display:none;"><strong>SESSION:</strong><br/><?php print_r($this->session->userdata); ?></pre>
		<pre id="cookies" class="debug_block" style="display:none;"><strong>COOKIE:</strong><br/><?php print_r($_COOKIE); ?></pre>

<!-- header section -->
<div id="headerContainer">
	<div class="row">

		<div class="logo"></div>

		<?php if($this->session->userdata('user')){ ?>
			<div class="login"><a id="logout_button" class="small button" href="/auth/logout">Logout</a></div>
		<?php }else{ ?>
			<div class="login"><a class="small button" href="#" data-reveal-id="auth_wrapper" 	>Register</a></div>
			<div class="login"><a id="" class="small button" href="#" data-reveal-id="auth_wrapper" >Login</a></div>
		<?php } ?>

		<div id="auth_wrapper" class="reveal-modal [expand]">
			
			<h3>Create Your Free STAfund Account</h3>
			
			<div class="fbl">
				<p>Get going quicker; connect with Facebook:</p>
				<img src="/images/main/fb-button.png" alt="Login" onclick="fb_login()">
			</div>

			<p>or, complete the information below:</p>


			<div class="row">
				<dl class="tabs">
					<dd class="active"><a class="tab_switcher" tab="loginTab" href="javascript:">Login</a></dd>
					<dd><a class="tab_switcher" tab="registerTab" href="javascript:">Register</a></dd>
				</dl>

				<ul class="tabs-content">
					<li class="active" id="loginTab">
						<form class="custom" method="post" action id="login_form" novalidate="novalidate">
							<div class="row">
								<div class="six columns">
									<label for="login_form_email">Email Address</label>
									<input id="login_form_email" name="email" class="required" type="text" it="email" />
								</div>
								
								 <div class="six columns">
									<label>Password</label>
									<input id="login_form_password" name="password" class="required" type="password" placeholder="" it="password"/>
								</div>
							</div>
						</form>
							
							<div class="row last">
								<div class="six columns">
									<button class='submit_button large success button' onclick="login()" >Login</button>
									<!-- <input class="large success button" name="Submit" type="button" value="Save and Continue"> -->
								</div>
								<div class="six columns btm">
									<a class="tab_switcher" tab="registerTab" href="javascript:">I Have No Account</a>
								</div>
							</div>
					</li>

					<li id="registerTab">
						<form class="custom" method="post" action id="register_form" novalidate="novalidate">
							<div class="row">
								<div class="six columns">
									<label>First Name</label>
									<input id="register_form_firstname" name="firstname" class="required" type="text"  it="text"/>
								</div>
								 <div class="six columns">
									<label>Last Name</label>
									<input id="register_form_lastname" name="lastname" class="required" type="text"  it="text"/>
								</div>
							</div>
							<div class="row">
								<div class="twelve columns">
									<label>Email Address</label>
									<input id="register_form_email" name="email" class="required" type="text"  it="text"/>
								</div>
							</div>
							<div class="row">
								<div class="six columns">
									<label>Create a Password</label>
									<input id="register_form_password" name="password" class="required" type="password" placeholder="" it="password"/>
								</div>
						 		<div class="six columns">
									<label>Confirm Password</label>
									<input id="register_form_confirmpassword" name="confirmpassword" class="required" type="password" placeholder="" it="password"/>
								</div>
							</div>
							<div class="row">
								<div class="twelve columns">
									<label for="register_form_agree"><input name="agree" id="register_form_agree" type="checkbox" />By creating an account, I agree to STAfund's </label>
							 		<a href="#">Terms of Use</a>
							 	</div>
							</div>
						</form>

							<div class="row last">
								<div class="six columns">
									<button class='submit_button large success button' onclick="register()" >Save and Continue</button>
								</div>
								<div class="six columns btm">
									<a class="tab_switcher" tab="loginTab" href="javascript:">I Already Have an Account</a>
								</div>
							</div>
					</li>
				</ul>
			</div>

			
			<a class="close-reveal-modal">×</a>
		</div>
			
		<div id="header">

			<div class="tweleve columns nav">
			
				<ul class="nav-bar">
					<li class="active"><a href="/">Home</a></li>
	                <li><a href="/ad">Ads</a></li>
					<?php if($this->session->userdata('user')){ ?>
						<li><a href="/profile">Profile</a></li>
		                <li><a href="/ad/create">Create Fundraiser</a></li>
	                    <li><a href="/ad/userAd">My ads</a></li>
					<?php } ?>
					<li><a href="/">Features</a></li>
					<li><a href="/">FAQs</a></li>
					<li><a href="/">Give Funds</a></li>
				</ul>

			</div>
		</div>
	</div>
</div>
