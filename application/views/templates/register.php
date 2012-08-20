<div id="register_form_wrapper" class="form_wrapper">
	<!-- <div class="form_wrapper_bg"></div> -->
	<button class="close_modal_button">Close</button>
	<form method="post" id="register_form" action="" novalidate="novalidate">
		<h2>Register Form</h2>
		<label for="register_form_firstname">First Name<input type="text" name="firstname" id="register_form_firstname" class="required" minlength="2"></label>
		<label for="register_form_lastname">Last Name<input type="text" name="lastname" id="register_form_lastname" class="required" minlength="2"></label>
		<label for="register_form_email">Email<input type="email" name="email" id="register_form_email" class="required"></label>
		<label for="register_form_password">Password<input type="password" name="password" id="register_form_password" class="required"></label>
		<label for="register_form_confirmpassword">Confirm Password<input type="password" name="confirmpassword" id="register_form_confirmpassword" class="required"></label>
		<label for="register_form_agree"><input type="checkbox" name="agree" id="register_form_agree" class="required">By creating this account, I agree STAfund's <a href="#">Terms of Use</a></label>
		<a href="#">I Already Have an Account</a>
		<button onclick="register()" >Save and Continue</button>
	</form>
</div>