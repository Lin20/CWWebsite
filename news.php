<?php

	$page_name = 'News';
	$nav_title = 'news';
	$page_category = 2;
	$page_src = 'news';

	include 'postlist.php';

	function DisplayContent()
	{
		global $newsfeed;

		echo '<h1>News</h1>';
		echo $newsfeed;
	}

	include 'template.php';
?>