<link rel="stylesheet" href="/css/jquery-ui-1.8.23.custom.css"/>
<script type="text/javascript" src="/js/jquery-ui-1.8.23.custom.min.js"></script>
    <form method="post" id="form" action="/ad/create" novalidate="novalidate">
        <label>Choose the type of your fundraiser</label><br/>
        <select id="id_fundraiser" name="id_fundraiser">
            <option value="0">select a fundraising type</option>
           <?php foreach($fundraisers as $value): ?>
            <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
            <?php endforeach; ?>
        </select><br/>
        <label for="need_raise">What is your goal - how much do you need to raise?</label><br/>
		<input id="need_raise" name="need_raise" type="text" class="numbers"/><br/>
		<label for="total_cost">What is the total cost of your trip?</label><br/>
        <input id="total_cost" name="total_cost" type="text" class="numbers"/><br/>
        <label for="still_need_raise">How much do you still nees to raise?</label><br/>
        <input id="still_need_raise" name="still_need_raise" type="text" readonly/><br/>
        <label for="datepicker">What is the departure date of your trip?</label><br/>
        <input id="datepicker" type="text" name="date"/><br/>
        <label for="description">Trip Description</label><br/>
        <textarea id="description" name="description"></textarea><br/>
        <label for="meaning">What does this Trip mean to you?</label><br/>
        <textarea id="meaning" name="meaning"></textarea><br/>
        <input id="submit" type="submit" value="save & continue" />
	</form>
<script type="text/javascript">
    $(document).ready( function()
    {
        error=new Array();
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
        $('.numbers').keyup(function(){
            var re = /^[0-9]+$/;
            if (! re.test($(this).val())){
                $(this).css('color','red');
                error[$(this).attr('id')]=false;
            } else if (parseInt($('#need_raise').val()) > parseInt($('#total_cost').val())){
                $(this).css('color','red');
                error[$(this).attr('id')]=false;
            } else {
                error[$(this).attr('id')]=true;
                
                $(this).css('color','#000');
                if ($(this).attr('id') == 'need_raise') {
                    $('#still_need_raise').val($('#need_raise').val());
                }
            }
        });
        $('#form').submit(function()
        {
            for (var key in error) 
                {
                    if(error[key] == false)
                    {
                        return false;
                    }
                }
            if (! $('#description').val() 
                || $('#id_fundraiser').val() == '0'
                || ! $('#still_need_raise').val()
                || ! $('#datepicker').val()
                || ! $('#meaning')) {
                return false
            }
        });
        
    });
</script>