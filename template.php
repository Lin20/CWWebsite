<!doctype html>
<?php
	include_once 'php/settings.php';
	include_once 'php/screenshots.php';
?>

<html><head>
		<title><?php print $site_name . ' - ' . $page_name; ?></title>
		<link href="css/styles.css" rel="stylesheet" type="text/css" media="screen">
	</head>

	<body id="main">

		<div id="wrapper">

			<div id="banner">
				<div id="logo">
					<h1><a href="index.php"><?php print $site_name ?></a></h1>
				</div>

				<div id="nav">
					<ul>
						<li><a href="index.php" <?php if ($nav_title == "home")
	echo 'class="active_nav"';
else
	echo 'class="inactive_nav"';
?> >Home</a></li>
						<li><a href="news.php" <?php if ($nav_title == "news")
								   echo 'class="active_nav"';
							   else
								   echo 'class="inactive_nav"';
?> >News</a></li>
						<li><a href="updates.php" <?php if ($nav_title == "updates")
								   echo 'class="active_nav"';
							   else
								   echo 'class="inactive_nav"';
?> >Updates</a></li>
						<li><a href="gallery.php" <?php if ($nav_title == "gallery")
								   echo 'class="active_nav"';
							   else
								   echo 'class="inactive_nav"';
?> >Gallery</a></li>
						<li><a href="irc.php" <?php if ($nav_title == "irc")
						echo 'class="active_nav"';
					else
						echo 'class="inactive_nav"';
?> >IRC</a></li>
						<li><a href="about.php" <?php if ($nav_title == "about")
						echo 'class="active_nav"';
					else
						echo 'class="inactive_nav"';
?> >About</a></li>
					</ul>
				</div>
			</div>

			<div id="main_area">
				<div class="announcements">
<?php
	require_once 'php/announcements.php';
	echo_announcements();
?>
					<script src="js/jquery.min.js"></script>
					<script>
						(function () {

							var quotes = $(".quotes");
							var quoteIndex = Math.floor(Math.random() * quotes.length);
							quotes.hide();

							function showNextQuote() {
								++quoteIndex;
								quotes.eq(quoteIndex % quotes.length)
										.fadeIn(2000)
										.delay(2000)
										.fadeOut(2000, showNextQuote);
							}

							showNextQuote();

						})();
					</script>
				</div>

				<div id="content">
								<?php DisplayContent(); ?>
				</div>

				<div id="sidebar">
					<div id="sidebar_content">
						<div id="latest_screenshot">
							<a href="gallery.php">Latest screenshot</a>
							<link rel="stylesheet" href="css/lightbox.css">
							<script type="text/javascript" src="js/lightbox-plus-jquery.js"></script>
							<script src="js/jquery.unveil.min.js"></script>

							<script>
						$(function () {
							$("img").unveil();
						});
							</script>

							<div><?php global $total_screenshots;
								echo preview_screenshot($total_screenshots);
								?></div>
						</div>

						<div id="content_break"></div>

						<a class="twitter-timeline" href="https://twitter.com/ProgrammerLin" data-widget-id="623394053262962688" height="300" width="215">Tweets by @ProgrammerLin</a>
						<script>!function (d, s, id) {
								var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
								if (!d.getElementById(id)) {
									js = d.createElement(s);
									js.id = id;
									js.src = p + "://platform.twitter.com/widgets.js";
									fjs.parentNode.insertBefore(js, fjs);
								}
							}(document, "script", "twitter-wjs");</script>

						<div id="social_media"><ul id="socialbar"><li id="youtube"><a target="_blank" href="http://youtube.com/linscape99"><IMG src="images/youtube_color.png"></a></li><li id="facebook"><a target="_blank" href="http://www.facebook.com/codenameworld"><IMG src="images/facebook_color.png"></a></li><li id="twitter"><a target="_blank" href="http://twitter.com/programmerlin"><IMG src="images/twitter_color.png"></a></li></ul><style>#socialbar img {border:0px;}#socialbar li img {}#socialbar li a:hover {}#socialbar{padding:0px;list-style: none outside none; margin:0px; position: static;}#socialbar li {display:inline;padding-right:4px;}#socialbar{width:180px;text-align:center;}</style></div>
					</div>
				</div>
			</div>

			<div id="right_side">
			</div>

			<div id="footer">
				<p>Copyright &copy; 2015 <?php print $site_name ?></p>
			</div>

		</div>

	</body>
</html>