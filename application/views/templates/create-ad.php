<script type="text/javascript" src="/js/jquery-ui-1.8.23.custom.min.js"></script>
<div id="create-ad">
    <form method="post" id="form" action="/ad/create/published" novalidate="novalidate">
        <label>Choose the type of your fundraiser</label><br/>
        <select id="id_fundraiser" name="id_fundraiser">
            <option value="0">select a fundraising type</option>
           <?php foreach($fundraisers as $value): ?>
            <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
            <?php endforeach; ?>
        </select>
        <div class="ad-error"></div>
        <label for="need_raise">What is your goal - how much do you need to raise?</label><br/>
		<input id="need_raise" name="need_raise" type="text" class="numbers"/>
        <div class="ad-error"></div>
		<label for="total_cost">What is the total cost of your trip?</label><br/>
        <input id="total_cost" name="total_cost" type="text" class="numbers"/>
        <div class="ad-error"></div>
        <label for="still_need_raise">How much do you still nees to raise?</label><br/>
        <input id="still_need_raise" name="still_need_raise" type="text" readonly/>
        <div class="ad-error"></div>
        <label for="datepicker">What is the departure date of your trip?</label><br/>
        <input id="datepicker" type="text" name="date"/>
        <div class="ad-error date"></div>
        <label for="description">Trip Description</label><br/>
        <textarea id="description" name="description"></textarea>
        <div class="ad-error"></div>
        <label for="meaning">What does this Trip mean to you?</label><br/>
        <textarea id="meaning" name="meaning"></textarea>
        <div class="ad-error"></div>
        <input id="submit" onClick="document.forms.form.action = '/ad/create/published'" type="submit" value="save & continue" /> or 
        <input type="submit" onClick="document.forms.form.action = '/ad/create'" value="save & finish later"/>
	</form>
</div>
<script type="text/javascript">
    $(document).ready( function()
    {
        $.datepicker.setDefaults({
		   showOn:     'both',
           buttonImage: "/images/calendar.gif",
		   buttonImageOnly: true,
		   dateFormat: 'yy-mm-dd',
           minDate:    '+0'
        });
        $(function() {
            $("#datepicker").datepicker();
        });
        $('#need_raise').keyup(function(){
            $('#still_need_raise').val($('#need_raise').val());
        });
        $('#need_raise').blur(function(){
            $('#still_need_raise').val($('#need_raise').val());
        });
        $('#form').submit(function()
        {
            $('.ad-error').text('')
            var error = false;
            var re = /^[0-9]+$/;
            if (! re.test($('#need_raise').val())) {
                $('#need_raise + .ad-error').text('Whole numbers only please')
                error = true;
            }
            if (! re.test($('#total_cost').val())) {
                $('#total_cost + .ad-error').text('Whole numbers only please')
                error = true;
            }
            if (! re.test($('#still_need_raise').val())) {
                $('#still_need_raise + .ad-error').text('Whole numbers only please')
                error = true;
            }
            
            if ($(this).attr('action') == '/ad/create/published') {
                if (! $('#description').val()) {
                    $('#description + .ad-error').text('This field is required.')
                    error = true;
                }
                if ($('#id_fundraiser').val() == '0') {
                    $('#id_fundraiser + .ad-error').text('Please select a fundraising type.')
                    error = true;
                }
                if (! $('#still_need_raise').val()) {
                    $('#still_need_raise + .ad-error').text('This field is required.')
                    error = true;
                }
                if (! $('#datepicker').val()) {
                    $('.ad-error.date').text('This field is required.')
                    error = true;
                }
                if (! $('#meaning').val()) {
                    $('#meaning + .ad-error').text('This field is required.')
                    error = true;
                }
                if (parseInt($('#need_raise').val()) > parseInt($('#total_cost').val())) {
                $('#total_cost + .ad-error').text('Total cost should be more')
                error = true;
            }
            }
            console.log($(this).attr('action'));
            if (error) {
                return false;
            }
        });
        
    });
</script>