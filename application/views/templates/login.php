<div id="login_form_wrapper" class="form_wrapper">
	<!-- <div class="form_wrapper_bg"></div> -->
	<button class="close_modal_button">Close</button>
	<form method="post" id="login_form" action="" novalidate="novalidate">
		<h2>Login Form</h2>
		<label for="login_form_email">Email<input type="email" name="email" id="login_form_email" class="required"></label>
		<label for="login_form_password">Password<input type="password" name="password" id="login_form_password" class="required"></label>
		<button onclick="login()" >Login</button>
		<a href="#" onclick="show_register_form()">I Have No Account</a>
	</form>
</div>