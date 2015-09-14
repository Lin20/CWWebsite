<?php

	require_once 'php/screenshots.php';
	$page_name = 'Gallery';
	$nav_title = 'gallery';
	$page_src = 'gallery';

	$num_screenshots = 2;

	function DisplayContent()
	{
		global $total_screenshots, $mysqli, $page_src, $page_name;
		$order = isset($_GET['sort']) ? (int) $_GET['sort'] : 0;
		if($order < 0 || $order > 3)
			$order = 0;
		
		echo '
			
			<h1 style="float:left">' . $page_name . '</h1><div id="sortby">Sort by: <select name="sort" onchange="
			 window.location.href=\'' . $page_src . '.php?sort=\' + this.value;
			 ">' .
				'<option value="0" ' . ($order == 0 ? 'selected' : '') . '>Newest</option>
				<option value="1" ' . ($order == 1 ? 'selected' : '') . '>Oldest</option>
				<option value="2" ' . ($order == 2 ? 'selected' : '') . '>Most Popular</option>
				<option value="3" ' . ($order == 3 ? 'selected' : '') . '>Least Popular</option>
			</select></div>
			<div style="clear:both; overflow:auto;">';

		$stmt;
		if ($order == 1)
			$stmt = $mysqli->prepare('SELECT * FROM screenshots ORDER BY id ASC');
		else if($order == 2)
			$stmt = $mysqli->prepare('SELECT * FROM screenshots ORDER BY views DESC');
		else if ($order == 3)
			$stmt = $mysqli->prepare('SELECT * FROM screenshots ORDER BY views ASC');
		else
			$stmt = $mysqli->prepare('SELECT * FROM screenshots ORDER BY id DESC');
		$stmt->execute();
		$stmt->bind_result($id, $filename, $date, $title, $description, $views);
		$stmt->store_result();

		$data = null;



		$last_date = 0;
		for ($i = $total_screenshots; $i > 0; $i--)
		{
			if (!$stmt->fetch())
			{
				//echo 'error';
				break;
			}
			$data = array('id' => $id, 'filename' => $filename, 'date' => $date, 'title' => $title, 'description' => $description, 'views' => $views);

			echo preview_screenshot_data($id, $data, $last_date, $order < 2);
			$last_date = $date;
		}
		
		$stmt->close();
		echo '</div>';
	}

	include 'template.php';
?>