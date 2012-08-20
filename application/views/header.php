<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title><?=isset($data['title'])?$data['title']:'Fundaraiser'?></title>
	<link rel="stylesheet" href="/css/main.css">
	<script type="text/javascript" src="/js/jquery.min.js"></script>
	<script type="text/javascript" src="/js/jquery.validate.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$(".close_modal_button").on('click',function(){
				hide_form_wrapper();
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
					,register_form_confirmpassword: {required: true}
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
		}

		function show_register_form(){
			$("#login_form_wrapper").hide();
			$("#register_form_wrapper").show();
		}

		function hide_form_wrapper(){
			$(".form_wrapper").hide();
		}

		function show_error(){
			$("#errors_wrapper").show();
		}

		function hide_error(){
			$("#errors_wrapper").html($("#errors_wrapper .close_errors")).hide();
		}

	</script>
</head>
<body>
	<div id="header">
		<pre id="session"><strong>SESSION:</strong><br/><?php var_dump($this->session->userdata); ?></pre>
		<div id="top_menu">
			<ul>
				<li><a href=".">Home</a></li>
				<li>
					<?php if($this->session->userdata('user')){ ?>
						<a href="logout">Logout</a>
					<?php }else{ ?>
						<button onclick="show_login_form()">login</button>
					<?php } ?>
				</li>
				<li><button onclick="show_register_form()">Register</button></li>
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