<div id="login_popup_wrapper" class="popup_wrapper">
	<div id="login_form_wrapper" class="form_wrapper">
		<form method="post" id="login_form" novalidate="novalidate">
			<a href="javascript:" class="close_modal_button">Close</a>
			<h2>Login Form</h2>
			<dl>          

				<dt><label for="login_form_email">Email</label></dt>
				<dd><input type="email" name="email" id="login_form_email" class="required"></dd>

				<dt><label for="login_form_password">Password</label></dt>
				<dd><input type="password" name="password" id="login_form_password" class="required"></dd>

			</dl>
			<a href="#" onclick="show_register_form()">I Have No Account</a>
			<button class="submit_button" onclick="login()" >Login</button>
		</form>
	</div>
</div>