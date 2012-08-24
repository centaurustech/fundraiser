<?php $this->load->view('header',$data); ?>
<div id="content">
    <p>ADS</p>
    <div id="ads">
        <?php foreach($ad as $value): ?>
            <div id="ad_<?=$value['id']?>" class="ad">
                <div><img width="110" height="100" src="/images/photo_not_available.png"/></div>
                <div>             
                    <p>Raised: <?=$value['still_need_raise']?></p>
                    <p>GOAL: <?=$value['total_cost']?></p>
                    <p>Ends <?=$value['date']?></p>
                </div>
                <div id="ad-description">
                    <?=$value['description']?>
                    <a href="ad/show/<?=$value['id']?>">READ MORE</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php $this->load->view('footer',$data); ?>