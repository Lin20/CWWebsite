<?php

	$page_name = 'Home';
	$nav_title = 'home';
	$page_src = 'news';

	require_once 'php/posts.php';

	function DisplayContent()
	{
		$news_data = get_last_post(2);
		$updates_data = get_last_post(1);
		//$page_content = '<p>Welcome to the website for Codename::World!</p>';
		$page_content = '<h2>Latest Game Update</h2><div style="padding:0 0 20px 0;">' . preview_post_data($updates_data['id'], $updates_data, 'updates', 65535);
		$page_content .= ' </div>
						<div style="text-align:center"><a href="updates.php">View Game Updates</a></div>
						<div id="page_break"></div>	
						<h2>Latest Site News</h2><div style="padding:0 0 20px 0;">' . preview_post_data($news_data['id'], $news_data, 'news', 65535);
		$page_content .= ' </div>
						<div style="text-align:center"><a href="news.php">View Site News</a></div>
					';

		echo $page_content;
	}

	include 'template.php';
?>