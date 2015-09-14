<?php

	require_once 'php/posts.php';

	$post_id = isset($_GET['id']) ? (int) $_GET['id'] : 1;
	$page_src = isset($_GET['src']) ? $_GET['src'] : '';
	$nav_title = $page_src;
	$post_data = get_post($post_id);

	$page_name = 'View Post';

	function DisplayContent()
	{
		global $post_data, $post_id, $page_src, $categories;
		$page_content = '<h1>' . $post_data['title'] . '</h1><div style="padding:0 0 20px 0;">' . preview_post($post_id, $page_src, 0);
		$page_content .= '</div>';

		if (!empty($page_src))
			$page_content .= '<div style="text-align:center"><a href="' . $page_src . '.php">Back to ' . $categories[$post_data['category']]['name'] . '</a></div>';

		echo $page_content;
	}

	include 'template.php';
?>