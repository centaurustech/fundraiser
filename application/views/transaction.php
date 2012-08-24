<?php $this->load->view('header',$data); ?>
<div id="content">
    <a href="/ad/show/<?=$ad_id?>">Back</a>
    <?php if($transaction['error']): ?>
        <h2>Error!</h2>
        <h3>We're sorry, but we can't process your order at this time due to the following error:</h3>
        <p><?=$transaction['response_reason_text']?></p>
        <p>response code         <?=$transaction['response_code']?></p>
        <p>response reason code  <?=$transaction['response_reason_code']?></p>
    <?php else: ?>
        <h2>Thank You</h2>
        <p>Your transaction ID:</p>
        <span><?=$transaction['transaction_id']?></span>
    <?php endif; ?>
</div>
<?php $this->load->view('footer',$data); ?>