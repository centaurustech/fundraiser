$(document).ready(function(){

	// console.log(screen.height);
	// console.log(screen.width);


	// console.log($(document).height());
	// console.log($(document).width());

	$(".close_modal_button").on('click',function(){
		hide_popup_wrapper();
		var validator;
		
		validator = $("#login_form").validate();
		validator.resetForm();
		validator = $("#register_form").validate();
		validator.resetForm();
	});

	$('form input').keypress(function (event) {
        if (event.which == '13') {
            event.preventDefault();
        }
    });

    $("#auth_wrapper a.tab_switcher").on('click',function(event){
		$("#auth_wrapper .tabs dd.active").removeClass('active').siblings().addClass('active');
		$("#auth_wrapper ul.tabs-content > li").removeClass('active');
		$("#" + $(this).attr('tab')).addClass('active');
	});
});

function login(){
	$("#login_form").form_validate({
		rules: {
			email: {
				required: { value: true, message: "Please enter your email" }
				, email: { value: true, message: "Please enter a valid email address" }
			}
			,password: {
				required: { value: true, message: "Please enter password" }
			}
		}
		,valid_element_class: "valid"
		,valid_form_class: "form_valid"
		,onValid: function(form){
			console.log($(form).serialize());
			$.ajax({
				url: "/auth/login"
				,type: "post"
				,data: $("#login_form").serialize()
				,success: function(data){
					console.log(data);
					if(data.error !== true){
						location.href = "profile";
					}
				}
			});
		}
		,invalid_element_class: "invalid"
		,invalid_form_class: "form_invalid"
		,onInvalid: function(form){
			console.log('fail');
		}
		,show_message: true // если false, то нижние значения не имеют смысла
		,message_popup: false // false - тэг сообщения показывать рядом с элементом; true - показывать сообщение как всплывающую подсказку
		,message_position: "right" // поиция блока сообщения, относительно элемента. может принимать значения: top | right | bottom | left
		,message_tag: "div" // имя тега хрянящего сообщение об ошибке
		,message_tad_class: "error_message" // класс тега хрянящего сообщение об ошибке
	});


	// $("#login_form").validate({
	// 	rules: {
	// 		login_form_email: {required: true,email: true}
	// 		,login_form_password: {required: true}
	// 	},
	// 	messages: {
	// 		login_form_email: "Please enter a valid email address"
	// 		,login_form_password: "Please enter password"
	// 	},
	// 	submitHandler: function(form){
	// if($("#login_form #login_form_email").hasClass('required')){
	// 	if($("#login_form #login_form_email").val() == '' || !validateEmail($("#login_form #login_form_email").val())){
	// 		$("#login_form #login_form_email").addClass('invalid');
	// 		valid == false;
	// 	}else{
	// 		$("#login_form #login_form_email").removeClass('invalid');
	// 	}
	// }

	// validate_form($("#login_form"));

	// if(valid){

	// }
	// 	}
	// });
}

function validate_form(form){
	$.each($(form).find("input, select, textarea"), function(i,v) {
		if($(v).attr('it')){
			var it = $(v).attr('it');
			if(it == 'text'){

			}else if(it == 'password'){

			}else if(it == 'email'){

			}else if(it == 'checkbox'){

			}else{

			}
			console.log(v.tagName);
			console.log($(v));
			console.log($(v).val());
			console.log($(v).attr('it'));
		}
	});
}

function get_type(element){
	if(v.tagName == 'text'){
		return $(v).val();
	}else if(v.tagName == 'textarea'){
		return v.tagName;
	}else if(v.tagName == 'select'){
		return v.tagName;
	}else if(v.tagName == 'text'){
		return v.tagName;
	}else if(v.tagName == 'text'){

	}else if(v.tagName == 'text'){

	}
}

function validateEmail(email) {
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	if( !emailReg.test( email ) ) {
		return false;
	} else {
		return true;
	}
}

function register(){
	$("#register_form").form_validate({
		rules: {
			firstname: {
				required: { value: true, message: "Please enter your firstname" }
				, minlength: { value: 2, message: "Your firstname must consist of at least 2 characters" }
			}
			,lastname: {
				required: { value: true, message: "Please enter your lastname" }
				, minlength: { value: 2, message: "Your lastname must consist of at least 2 characters" }
			}
			,email: {
				required: { value: true, message: "Please enter your email" }
				, email: { value: true, message: "Please enter a valid email address" }
			}
			,password: {
				required: { value: true, message: "Please enter password" }
			}
			,confirmpassword: {
				equalTo: { value: "password", message: "Please enter same password" }
			}
			,agree: {
				required: { value: true }
			}
		}
		,valid_element_class: "valid"
		,valid_form_class: "form_valid"
		,onValid: function(form){
			console.log($(form).serialize());
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
		,invalid_element_class: "invalid"
		,invalid_form_class: "form_invalid"
		,onInvalid: function(form){
			console.log('fail');
		}
		,show_message: true // если false, то нижние значения не имеют смысла
		,message_popup: false // false - тэг сообщения показывать рядом с элементом; true - показывать сообщение как всплывающую подсказку
		,message_position: "right" // поиция блока сообщения, относительно элемента. может принимать значения: top | right | bottom | left
		,message_tag: "div" // имя тега хрянящего сообщение об ошибке
		,message_tad_class: "error_message" // класс тега хрянящего сообщение об ошибке
	});
}

function show_login_tab(){

}

function show_register_tab(){
	
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
	fbpopup = window.open(BASE_URL + "auth/facebook_login", "Facebook", params);
}

function fb_logout(){
	var w = 650, h = 400;
	var top = (screen.height - h)/2, left = (screen.width - w)/2;
	if(top < 0) top = 0;
	if(left < 0) left = 0;
	var params = "width=" + w + ",height=" + h + ",resizable=yes,scrollbars=yes,status=yes,left=" + left + ",top=" + top;
	fbpopup = window.open(FACEBOOK_LOGOUT_URL, "Facebook", params);
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