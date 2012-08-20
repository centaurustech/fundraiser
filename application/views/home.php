<?php $this->load->view('header',$data); ?>
<div id="content">
	<p>HOME</p>
	<?php $this->load->view('content',$data); ?>
	<?php if(!$this->session->userdata('user')){ ?>
		<?php $this->load->view('templates/login',$data); ?>
		<?php $this->load->view('templates/register',$data); ?>
	<?php } ?>
</div>
<?php $this->load->view('footer',$data); ?>