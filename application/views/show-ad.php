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
    <button>Give now</button>
</div>
<?php $this->load->view('footer',$data); ?>