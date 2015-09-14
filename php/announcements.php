<?php
	require_once 'db_connect.php';
	require_once 'settings.php';
	
	$stmt = $mysqli->prepare('SELECT * FROM screenshots');
	$stmt->execute();
	$stmt->store_result();
	$total_screenshots = $stmt->num_rows;
	$stmt->close();
	
	function echo_announcements()
	{
		global $mysqli;
		$stmt = $mysqli->prepare('SELECT * FROM announcements');
		$stmt->execute();
		$stmt->bind_result($id, $content);
		$data = null;
		while($stmt->fetch())
		{
			$data = array('id' => $id, 'content' => $content);
			echo '<div class="quotes">' . $content . '</div>';
		}
		
		$stmt->close();
	}
	
	?>