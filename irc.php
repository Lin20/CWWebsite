<?php

	$page_name = 'IRC';
	$page_src = 'irc';
	$nav_title = 'irc';

	function DisplayContent() {
		echo '<h1>IRC Channel</h1><div id="preview_game">Connect to the IRC channel using the app below, or connect manually.<br><p><strong>Server:</strong> <a href="irc://irc.techtronix.net:6667/codenameworld">irc.techtronix.net</a><br><strong>Channel:</strong> #codenameworld</p></div>';
		echo '<iframe src="https://kiwiirc.com/client/irc.techtronix.net/?&theme=relaxed#codenameworld" style="border-left:1px solid #b0b0b0; border-top: 1px solid #b0b0b0; border-bottom: 1px solid #b0b0b0; width:100%; height:450px;"></iframe>';
	}

	include 'template.php';
?>