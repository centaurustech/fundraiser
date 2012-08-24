(function($) {

	var form_has_errors = false;

	var _form = null;
	
	var data = null;

	var rules = null;
	
	var _valid_element_class = false;
	var _valid_form_class = false;
	var _onValid = false;
	var _invalid_element_class = false;
	var _invalid_form_class = false;
	var _onInvalid = false;

	var _show_message = true;
	
	var _message_popup = false;
	var _message_position = 'bottom';
	var _message_tag = "span";
	var _message_tad_class = null;

	var DEFAULT_REQUIRED_MESSAGE = "Value Required";
	var DEFAULT_INVALID_EMAIL_MESSAGE = "Invalid Email";
	var DEFAULT_INVALID_MINLENGTH_MESSAGE = "Value is too short";
	var DEFAULT_NOTEQUAL_MESSAGE = "Values ​​must match";

	//var input = ['password','text','checkbox','radio','file'];

	$.fn.form_validate = function(obj){
		_form = this;

		data = null;
		if(obj){
			data = obj;
			clear_all();
			set_properties();

			rules = null;
			if(data.hasOwnProperty("rules") && $.isPlainObject(data.rules)){ // если есть правила
				rules = data.rules;
				$.each(rules,function(element_name,element_rules){
					if(element_rules.hasOwnProperty('required') && element_rules.required.hasOwnProperty('value') && element_rules.required.value == true){ // если поле обязательное
						if(is_filled(element_name)){ // если есть значение
							var validation_result = is_valid(element_name)
							if(!is_valid(element_name).valid){ // если значение НЕ валидно
								console.log("render_invalid="+element_name);
								render_invalid(element_name,validation_result.message); // рисуем ошибку - значение в поле не валидно
							}
						}else{
							console.log("render_required="+element_name);
							render_required(element_name); // рисуем ошибку - поля обязательно для заполнения
						}
					}else{ // если поле не обязательное
						if(is_filled(element_name)){ // если есть значение
							var validation_result = is_valid(element_name)
							if(!validation_result.valid){ // если значение НЕ валидно
								console.log("render_invalid="+element_name);
								render_invalid(element_name,validation_result.message); // рисуем ошибку - значение в поле не валидно
							}
						}
					}

					if(element_rules.hasOwnProperty('equalTo') && element_rules.equalTo.hasOwnProperty('value')){ // значение поля должно равняться значению в другом поле
						if(is_equal(element_name,element_rules.equalTo.value)){
							//console.log("EQUAL");
						}else{
							render_notequal(element_name);
							//console.log("NOT EQUAL");
						}
					}
				});
			}	
		}

		if(form_has_errors){
			// найдены ошибки валидаци
			if(data.hasOwnProperty('onInvalid')){
				//console.log(data.onInvalid);
				data.onInvalid(_form);
			}else{

			}
		}else{
			// ошибок не найдено
			if(data.hasOwnProperty('onValid')){
				//console.log(data.onValid);
				data.onValid(_form);
			}else{
				
			}
		}

	}

	var is_equal = function(element_name, equal_element_name){
		var elements = $(_form).find('[name="' + element_name + '"]');
		var equal_elements = $(_form).find('[name="' + equal_element_name + '"]');
		if(elements.size()>0 && equal_elements.size()>0){
			return elements.first().val() == equal_elements.first().val();
		}
		return false;
	}

	var is_filled = function(element_name){
		var elements = $(_form).find('[name="' + element_name + '"]');
		// if CHECKBOX or RADIO
		if(elements.first().is(":checkbox")){
			return elements.first().is(":checked");
		}


		if(elements.first().is(":radio")){
			var radio_ckecked = false;
			elements.each(function(){
				if($(this).is(":checked")){
					radio_ckecked = true;
					return false;
				}
			});
			return radio_ckecked;
		}

		// if SELECT
		if(elements.get(0).tagName == 'SELECT'){
			return elements.first().find(':selected').size() > 0;
		}

		// if TEXTAREA or TEXT or PASSWORD or HIDDEN
		if(elements.get(0).tagName == 'textarea' || elements.first().is(":text") || elements.first().is(":password") || elements.first().is(":hidden")){
			return elements.first().val() != '';
		}

		// // if IMAGE
		// if(elements.get(0).is(':image')){
		// 	return false;
		// }

		// // if FILE
		// if(elements.get(0).is(':file')){
		// 	return false;
		// }

		return false;
	}

	var is_valid = function(element_name){
		var result = {valid: true,message: ""};

		if(rules != null && $.isPlainObject(rules) && rules.hasOwnProperty(element_name) && $.isPlainObject(rules[element_name])){ // если у элемента есть правила
			if(rules[element_name].hasOwnProperty('email')){
				var elements = $(_form).find('[name="' + element_name + '"]');
				if(!is_valid_email(elements.first().val())){
					result.valid = false;
					if(rules[element_name].email.hasOwnProperty('message')){
						result.message = rules[element_name].email.message;
					}else{
						result.message = DEFAULT_INVALID_EMAIL_MESSAGE;
					}
				}
			}else if(rules[element_name].hasOwnProperty('minlength') && $.isPlainObject(rules[element_name].minlength) && rules[element_name].minlength.hasOwnProperty('value')){
				var elements = $(_form).find('[name="' + element_name + '"]');
				if(elements.first().val().toString().length < parseInt(rules[element_name].minlength.value)){
					result.valid = false;
					if(rules[element_name].minlength.hasOwnProperty('message')){
						result.message = rules[element_name].minlength.message;
					}else{
						result.message = DEFAULT_INVALID_MINLENGTH_MESSAGE;
					}
				}
			}
		}

		return result;
		//return true; // если нет ограничительных правил, то значение валидно.
	}


	var render_invalid = function(element_name,message){
		form_has_errors = true;
		
		var elements = $(_form).find('[name="' + element_name + '"]');

		if(data.hasOwnProperty('invalid_element_class') && data.invalid_element_class == true){
			elements.addClass(data.invalid_element_class.toString());
		}

		
		
		if(_show_message){
			elements.last().before('<span class="invalid">' + message + '</span>');
		}	

	}

	var render_required = function(element_name){
		form_has_errors = true;

		var elements = $(_form).find('[name="' + element_name + '"]');

		var message;
		if(rules[element_name].required.hasOwnProperty('message')){
			message = rules[element_name].required.message;
		}else{
			message = DEFAULT_REQUIRED_MESSAGE;
		}

		if(_show_message){
			elements.last().before('<span class="required">' + message + '</span>');
		}

	}

	var render_notequal = function(element_name){
		form_has_errors = true;

		var elements = $(_form).find('[name="' + element_name + '"]');

		var message;
		if(rules[element_name].equalTo.hasOwnProperty('message')){
			message = rules[element_name].equalTo.message;
		}else{
			message = DEFAULT_NOTEQUAL_MESSAGE;
		}

		if(_show_message){
			elements.last().before('<span class="notequal">' + message + '</span>');
		}
	}

	var clear_all = function(){
		form_has_errors = false;

		$(_form).find("span.invalid").remove();
		$(_form).find("span.required").remove();
		
		// $.each(rules,function(){
		// });

		// clear invalid styles
		if(data.hasOwnProperty('invalid_element_class')){
			$(_form).find("."+data.invalid_element_class.toString()).removeClass(data.invalid_element_class.toString());
		}
		if(data.hasOwnProperty('invalid_form_class')){
			$(_form).removeClass(data.invalid_form_class.toString());
		}

		// clear valid styles
		if(data.hasOwnProperty('valid_element_class')){
			$(_form).find("."+data.invalid_element_class.toString()).removeClass(data.valid_element_class.toString());
		}

		if(data.hasOwnProperty('valid_form_class')){
			$(_form).removeClass(data.valid_form_class.toString());
		}
	}

	var is_valid_email = function(email){
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		if( !emailReg.test( email ) ) {
			return false;
		} else {
			return true;
		}
	}

	var set_properties = function(){
		if(data.hasOwnProperty('valid_element_class')){
			_valid_element_class = data.valid_element_class;
		}
		if(data.hasOwnProperty('valid_form_class')){
			_valid_form_class = data.valid_form_class;
		}
		if(data.hasOwnProperty('onValid')){
			_onValid = data.onValid;
		}
		if(data.hasOwnProperty('invalid_element_class')){
			_invalid_element_class = data.invalid_element_class;
		}
		if(data.hasOwnProperty('invalid_form_class')){
			_invalid_form_class = data.invalid_form_class;
		}
		if(data.hasOwnProperty('onInvalid')){
			_onInvalid = data.onInvalid;
		}


		if(data.hasOwnProperty('show_message')){
			_show_message = data.show_message;
		}
	}


	// return 'select';
	// return 'textarea';

	// return 'radio';
	// return 'checkbox';

	// return 'text';
	// return 'password';
	// return 'hidden';
	
	// return 'image';
	// return 'file';

	// return 'reset';
	// return 'submit';
	// return 'button';

})(jQuery);