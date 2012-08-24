<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title></title>
	<script type="text/javascript" src="/js/jquery.min.js"></script>
	<script type="text/javascript" src="/js/jquery.form.validation.js"></script>

	<script>
		$(document).ready(function(){
			
		});

		function validate(){
			$("#login_form").form_validate({
				rules: {
					my_text: {	
						required: { value: false, message: "Enter text" }
						, email: { value: false, message: "Invalid text" }
					}
					,my_email: {	
						required: { value: true, message: "Enter email" }
						, email: { value: true, message: "Invalid email" }
					}
					,my_password: {	
						required: { value: true, message: "Enter password" }
						, minlength: { value: 2, message: "Min length 2 chars" }
					}
					,my_password2: {
						equalTo: { value: "my_password", message: "please enter same password" }
					}
					,my_checkbox: {
						required: { value: true, message: "Enter checkbox" }
					}
					,my_radio: {
						required: { value: true, message: "Enter radio" }
					}
					,my_select: {
						required: { value: true, message: "Enter select" }
					}
				}
				,valid_element_class: "valid"
				,valid_form_class: "form_valid"
				,onValid: function(form){
					console.log('success');
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
	</script>

	<style type="text/css">
		.highlight{
			color: red;
			font-weight: bold;
		}
	</style>
</head>
<body>

	<form id="login_form">
		<div>my_text<input name="my_text" type="text"/></div>
		
		<div>my_password<input name="my_password" type="password"/></div>
		<div>my_password2<input name="my_password2" type="password"/></div>
		
		<div>my_email<input name="my_email" type="text"/></div>
		
		<div>my_checkbox<input name="my_checkbox" type="checkbox"/></div>

		<div>my_radio<input type="radio" name="my_radio" type="radio1"/></div>
		<div>my_radio<input type="radio" name="my_radio" type="radio2"/></div>
		<div>my_radio<input type="radio" name="my_radio" type="radio3"/></div>
			
		<select name="my_select" id="">
			<option value="sel1">sel1</option>
			<option value="sel2">sel2</option>
			<option value="sel3">sel3</option>
		</select>


		<div>my_hidden<input name="my_hidden" type="hidden"/></div>
		
		<div>my_button<input name="my_button" type="button"/></div>
		
		<div>my_submit<input name="my_submit" type="submit"/></div>
		
		<div>my_reset<input name="my_reset" type="reset"/></div>
		
		<div>my_file<input name="my_file" type="file"/></div>
		
		<div>my_image<input name="my_image" type="image"/></div>

	</form>

	<button onclick="validate()">VALIDATE</button>

</body>
</html>