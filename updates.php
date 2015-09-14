<?php

$page_name = 'Updates';
$page_category = 1;
$page_src = 'updates';
$nav_title = 'updates';

include 'postlist.php';

function DisplayContent() {
	global $newsfeed;
	
	echo '<h1>Updates</h1>';
	echo $newsfeed;
}

include 'template.php';
?>