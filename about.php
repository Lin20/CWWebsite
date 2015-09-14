<?php

	$page_name = 'About';
	$page_src = 'about';
	$nav_title = 'about';
	$page_content = "<?php print(\"Tesy\"); ?>";

	function DisplayContent() {
		echo file_get_contents("content/about.html");
	}

	include 'template.php';
?>