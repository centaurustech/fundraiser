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
			$.ajax({
				url: "/auth/login"
				,type: "post"
				,data: $(form).serialize()
				,success: function(data){
					console.log(data);
					if(data.error !== true){
						location.href = "profile";
					}
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
					if(data.error !== true){
						location.href = "profile";
					}
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
	fbuser = json;
	login_with_facebook();
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

var fbuser;

function login_with_facebook(){
	console.log(fbuser);
	if(fbuser.password){ // profile exists, you can log in
		location.href = "/auth/login_facebook";
	}else{ // need registration
		$("#connect_with_facebook_wrapper").remove();
		show_register_form();
		$("#register_form_firstname").val(fbuser.firstname);
		$("#register_form_lastname").val(fbuser.lastname);
		$("#register_form_email").val(fbuser.email);
		$("#register_form_password").focus();
	}
}

function fb_login_existing(){
	location.href = "/auth/login_facebook?token=" + fbuser.facebook_access_token;
}