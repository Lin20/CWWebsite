<?php

	require_once 'php/screenshots.php';
	
	if(isset($_POST['view_id']))
	{
		increment_view($_POST['view_id']);
	}

	?>