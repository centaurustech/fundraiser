<?php $this->load->view('header',$data); ?>
<div id="content">
	<p>PROFILE</p>
	<?php if(array_key_exists('active', $data['account'])){ ?>

		<?php if($data['account']['active'] == 1){ ?>
			
			<pre><?php print_r($data); ?></pre>

		<?php }elseif($data['account']['active'] == 0){ ?>
			
			<?php if($this->input->get('code')){ ?>
				<div class="error">
					<?php 
						$result = result($this->input->get('code'));
						echo $result['message'];
					?>
				</div>
			<?php } ?>
			<p>Your account is not activated yet. You were sent an email with an activation code. If you have not received an email, click the <a href="/auth/email/activation/resend">link</a> to resend the activation data.</p>
			<a href="<?=$data['account']['activation_url']?>"></a>

		<?php } ?>

	<?php } ?>
</div>
<?php $this->load->view('footer',$data); ?>