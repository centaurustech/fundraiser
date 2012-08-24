<?php $this->load->view('header',$data); ?>
<div id="content">
    <?php if($ad): ?>
    <?php foreach($ad as $value) ?>
    <div id="ad-meaning"> 
        <?=$value['meaning']?>
    </div>
    <div id="ad-progress">
        <p>Raised: <?=$value['still_need_raise']?></p>
        <p>GOAL: <?=$value['total_cost']?></p>
        <p>Ends <?=$value['date']?></p>
    </div>
    <?php endif; ?>
    <input id="autorizenet" type="image" src="/images/purchase.png"/>
    <div id="popup-gift">
        <form method="post" action="/transaction/gift" id="form">
            <input type="hidden" name="ad_id" value="<?= $ad['0']['id'] ?>"/>
            <div class="card-data">
                <label>Gift amount</label>
                <input id="amount" type="text" name="amount"/>
                <div class="ad-error"></div>
            </div>
            <div class="card-data">
                <label>This gift is from</label>
                <input type='text' size="10" name="name"/>
                <div>If left blank, gift will be anonymous.</div>
            </div>
            <select id="payment-method" name="type">
                <option value="0">select payment method</option>
                <option value="1">Credit Card</option>
                <option value="2">Electronic Check</option>
            </select>
            <div class="ad-error"></div>
            <div id="credit-card">
                <div class="card-data">
                  <label>Credit Card Number</label>
                  <input id="card_num" type="text" size="15" name="card_num"/>
                  <div class="ad-error"></div>
                </div>
                <div class="card-data">
                  <label>Expiration Date</label>
                  <input id="exp_date" type="text" size="4" name="exp_date"/>
                  <div class="ad-error"></div>
                </div>
                <div class="card-data">
                  <label>CVV2</label>
                  <input id="card_code" type="text" size="4" name="card_code" />
                  <div class="ad-error"></div>
                </div>
            </div>
            <div id="eCheck">
                <div class="card-data">
                    <label>Bank routing number</label>
                    <input type='text' size="10" name="bank_aba_code"/>
                </div>
                <div class="card-data">
                    <label>Bank account number</label>
                    <input type='text' size="10" name="bank_acct_num"/>
                </div>
                <div class="card-data">
                    <label>type of bank account</label>
                    <select>
                        <option value="1">checking</option>
                        <option value="2">businesschecking</option>
                        <option value="3">savings</option>
                    </select>
                </div>
                <div class="card-data">
                    <label>Bank name</label>
                    <input type='text' size="10" name="bank_name"/>
                </div>
                <div class="card-data">
                    <label>Name associated with the bank account</label>
                    <input type='text' size="10" name="bank_acct_name"/>
                </div>
            </div>
            <input type="submit" value="Submit Gift"/>
        </form>
    </div>
</div>
<?php $this->load->view('footer',$data); ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#autorizenet').click(function(){
            $('#popup-gift').show();
        });
        $('#payment-method').click(function(){
            if($('#payment-method').val() == '1') {
                $('#eCheck').hide();
                $('#credit-card').show();
            } else if($('#payment-method').val() == '2') {
                $('#credit-card').hide();
                $('#eCheck').show();
            } else {
                $('#credit-card').hide();
                $('#eCheck').hide();
            }
        })
        $('#form').submit(function(){
            $('.ad-error').text('')
            var error = false;
            var re_amount = /^[0-9]+$/
            var re_card_num = /^[0-9]{13,20}$/;
            var re_exp_date = /^(0[1-9])|(1[0-2])\/([0-3][0-9])$/;
            var re_card_code = /^[0-9]{3}$/;
            if (! re_amount.test($('#amount').val())) {
                $('#amount + .ad-error').text('Please enter a valid amount.')
                error = true;
            }
            if ($('#payment-method').val() == '0') {
                $('#payment-method + .ad-error').text('Please select payment method.')
                return false;
            }
            if (! re_card_num.test($('#card_num').val())) {
                $('#card_num + .ad-error').text('Please enter a valid credit card number.')
                error = true;
            }
            if (! re_exp_date.test($('#exp_date').val())) {
                $('#exp_date + .ad-error').text('Please enter a valid expiration date.')
                error = true;
            }
            if (! re_card_code.test($('#card_code').val())) {
                $('#card_code + .ad-error').text('Please enter a valid CVV2.')
                error = true;
            }
            if (error) {
                return false;
            }
        });
    });
</script>