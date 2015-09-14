<?php
	require_once 'php/posts.php';
	
	$page_name = 'Confirm Post';
	$page_category = 'updates';
	$nav_title = 'confirm_post';
	
	$password = $_POST['password'];
	$author = 0;
	$title = $_POST['title'];
	$data = $_POST['post'];
	$thumbnail = $_POST['thumbnail'];
	$category = $_POST['category'];
	$result = create_post($author, $title, $data, $thumbnail, $category, $password);
	
	function DisplayContent()
	{
		global $result;
		echo $result['message'];
	}
	
	include 'template.php';
?>