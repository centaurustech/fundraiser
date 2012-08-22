<?php $this->load->view('header',$data); ?>
<div id="content">
	<p>PROFILE</p>
	SESSION user:</br>
	<pre><?php print_r($this->session->userdata('user')); ?></pre>
</div>
<?php $this->load->view('footer',$data); ?>