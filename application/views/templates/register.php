<div id="register_popup_wrapper" class="popup_wrapper">
	<div class="form_wrapper_bg"></div>
	<div id="register_form_wrapper" class="form_wrapper">
		<form method="post" id="register_form" action="" novalidate="novalidate">
			<a href="javascript:" class="close_modal_button">Close</a>
			<h2>Register Form</h2>
			<dl>          
				<dt><label for="register_form_firstname">First Name</label></dt>
				<dd><input type="text" name="firstname" id="register_form_firstname" class="required" minlength="2"></dd>

				<dt><label for="register_form_lastname">Last Name</label></dt>
				<dd><input type="text" name="lastname" id="register_form_lastname" class="required" minlength="2"></dd>

				<dt><label for="register_form_email">Email</label></dt>
				<dd><input type="email" name="email" id="register_form_email" class="required"></dd>


				<dt><label for="register_form_password">Password</label></dt>
				<dd><input type="password" name="password" id="register_form_password" class="required"></dd>
				
				<dt><label for="register_form_confirmpassword">Confirm Password</label></dt>
				<dd><input type="password" name="confirmpassword" id="register_form_confirmpassword" class="required"></dd>
				
				<p><label for="register_form_agree"><input type="checkbox" name="agree" id="register_form_agree" class="required"> By creating this account, I agree STAfund's <a href="#">Terms of Use</a></label></p>
				
				
				<a href="javascript:" onclick="show_login_form()">I Already Have an Account</a>
				<button class='submit_button' onclick="register()" >Save and Continue</button>
	
			</dl>

		</form>
	</div>
</div>