<?php
	require_once 'db_connect.php';
	require_once 'settings.php';
	
	$stmt = $mysqli->prepare('SELECT * FROM screenshots');
	$stmt->execute();
	$stmt->store_result();
	$total_screenshots = $stmt->num_rows;
	$stmt->close();
	
	//$screenshots = array($total_screenshots + 1);
	
	if(isset($_POST['view_id']))
	{
		increment_view($_POST['view_id']);
	}
	
	function get_screenshot($index)
	{
		global $mysqli;
		$stmt = $mysqli->prepare('SELECT * FROM screenshots WHERE id=? LIMIT 1');
		$stmt->bind_param('i', $index);
		$stmt->execute();
		$stmt->bind_result($id, $filename, $date, $title, $description, $views);
		$data = null;
		while($stmt->fetch())
			$data = array('id' => $id, 'filename' => $filename, 'date' => $date, 'title' => $title, 'description' => $description, 'views' => $views);
		$stmt->close();
		return $data;
	}
	
	function preview_screenshot($index)
	{
		return preview_screenshot_data($index, get_screenshot($index), 0, false);
	}
	
	function preview_screenshot_data($index, $data, $last_time, $add_dates)
	{
		$title = $data['title'];
		$filename = $data['filename'];
		$date = $data['date'];
		$description = $data['description'];
		$views = $data['views'];
		
		$thumb = 'screenshots/preview/' . basename($filename, ".png") . '.jpg';
		$img = 'screenshots/' . $filename;
		if(!file_exists($thumb))
		{
			$thumb = 'screenshots/preview/' . $filename;
			if(!file_exists($thumb))
				$thumb = $img;
		}
		
		$result = '';
		if($add_dates)
		{
			$last = date('F Y', $last_time);
			$current = date('F Y', $date);
			if($last != $current)
			{
				$current_tag = date('F-Y', $date);
				$result .= ($last != $current? '<a class="date_tag" id="' . $current_tag . '" href="#' . $current_tag . '">' . $current . '</a>' : '');
			}
		}
		$result .=
				'<div id="preview_screenshot">
				<a href="' . $img . '" data-lightbox="screenshots" data-title="&lt;a href=\'' . $img . '\'&gt;' . $title . '&lt;/a&gt;" data-desc="' . $description . '" data-date="' . date('M j, Y', $date) . '" data-views="' . $views . '" data-index="' . $index . '">
				<img src="images/loading.gif" data-src="' . $thumb . '" width="192" height="108"></a>
				<noscript><img src="' . $thumb . '" width="192" height="108"></noscript>
				</div>';
		
		return $result;
	}
	
	function increment_view($index)	
	{
		echo $index;
		global $mysqli;
		$stmt = $mysqli->prepare('UPDATE screenshots SET views=views+1 WHERE id=' . $index);
		$stmt->execute();
	}
?>