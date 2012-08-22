<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title></title>
	<script type="text/javascript">window.opener.fb_after_<?php echo $data['action']; ?>('<?php print_r(json_encode($data)); ?>');</script>
</head>
<body>
	<pre><?php print_r($data); ?></pre>
</body>
</html>