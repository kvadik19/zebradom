<?php 
	echo get_header();
	$type = 'zebra';
	if (isset($_GET['type']) ) $type = $_GET['type'];
?>
	<?php include('builder.php') ?>
<?php
/*$dir = get_template_directory().'/images/builder/models/furniture/classic';
if (is_dir($dir)) {
	$files = scandir($dir);
	foreach($files as $key => $value){
		$path = realpath($dir.DIRECTORY_SEPARATOR.$value);
		if(!is_dir($path)) {
			$new_name = explode('-', $value);
			if(count($new_name) > 3) {
				unset($new_name[0]);
				unset($new_name[count($new_name)]);
				$new_arr = [ $new_name[count($new_name)] ];
				unset($new_name[count($new_name)]);
				foreach ($new_name as $item) {
					$new_arr[] = $item;
				}
				echo $dir.DIRECTORY_SEPARATOR.$value.'<br>';
				echo $dir.DIRECTORY_SEPARATOR.implode('-', $new_arr).".png<br>";
				rename($dir.DIRECTORY_SEPARATOR.$value, $dir.DIRECTORY_SEPARATOR.implode('-', $new_arr).".png");
			}
		}
	}
}*/
?>
<?php  get_footer() ?>
