<?php 
	get_header();
	$type = 'zebra';
	if (isset($_GET['type']) ) $type = $_GET['type'];
?>
	<?php include('builder.php') ?>
<?php  get_footer() ?>
