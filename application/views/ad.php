<?php $this->load->view('header',$data); ?>
<div id="content">
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
                    <a href="/ad/show/<?=$value['id']?>">READ MORE</a>
                </div>
            </div>
            <?php if($this->uri->rsegment(2) == 'userAd'):?>
                <div id="functions-ad">
                    <a class="delete-ad" href="/ad/delete/<?=$value['id']?>">delete</a>
                    <a class="delete-edit" href="#">edit</a>
                </div>
                <?php endif;?>
        <?php endforeach; ?>
    </div>
</div>
<?php $this->load->view('footer',$data); ?>
<?php if($this->uri->rsegment(2) == 'userAd'):?>
<script type="text/javascript">
                    $(document).ready(function(){
                        $('.delete-ad').click(function(){
                            if(! confirm('you want to delete this ad?')) {
                                return false;
                            }
                        });
                    });
</script>
<?php endif;?>