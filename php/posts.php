<?php

	require_once 'db_connect.php';
	require_once 'settings.php';

	$stmt = $mysqli->prepare('SELECT * FROM categories');
	$stmt->execute();
	$stmt->store_result();
	$total_categories = $stmt->num_rows;
	$stmt->close();

	$categories = array($total_categories + 1);
	$total_posts = array($total_categories + 1);
	for ($i = 1; $i <= $total_categories; $i++)
	{
		$stmt = $mysqli->prepare('SELECT * FROM posts WHERE category=?');
		$stmt->bind_param('i', $i);
		$stmt->execute();
		$stmt->store_result();
		$total_posts[$i] = $stmt->num_rows;
		$stmt->close();

		$stmt = $mysqli->prepare('SELECT * FROM categories WHERE category=? LIMIT 1');
		$stmt->bind_param('i', $i);
		$stmt->execute();
		$stmt->bind_result($id, $css, $name);
		while ($stmt->fetch())
			$categories[$i] = array('css' => $css, 'name' => $name);
		$stmt->close();
	}

	function get_post($index)
	{
		global $mysqli;
		$stmt = $mysqli->prepare('SELECT * FROM posts WHERE id=? LIMIT 1');
		$stmt->bind_param('i', $index);
		$stmt->execute();
		$stmt->bind_result($id, $author, $date, $updated, $title, $post, $thumbnail, $category);
		$data = null;
		while ($stmt->fetch())
			$data = array('id' => $id, 'author' => $author, 'date' => $date, 'updated' => $updated, 'title' => $title, 'post' => $post, 'thumbnail' => $thumbnail, 'category' => $category);
		$stmt->close();
		return $data;
	}

	function get_last_post($src_cat)
	{
		global $mysqli;
		$stmt = $mysqli->prepare('SELECT * FROM posts WHERE category=' . $src_cat . ' ORDER BY id DESC LIMIT 1');
		$stmt->execute();
		$stmt->bind_result($id, $author, $date, $updated, $title, $post, $thumbnail, $category);
		$data = null;
		while ($stmt->fetch())
			$data = array('id' => $id, 'author' => $author, 'date' => $date, 'updated' => $updated, 'title' => $title, 'post' => $post, 'thumbnail' => $thumbnail, 'category' => $category);
		$stmt->close();
		return $data;
	}

	function create_post($author, $title, $data, $thumbnail, $category, $password)
	{
		global $post_pass;
		if ($password != $post_pass)
		{
			$result = array('result' => false, 'message' => 'Invalid password 2.');
			return $result;
		}

		global $mysqli;
		$result;

		$stmt = $mysqli->prepare('INSERT INTO posts(id, author, date, updated, title, post, thumbnail, category) VALUES (NULL, ?, ?, NULL, ?, ?, ?, ?)');
		if ($mysqli->error)
		{
			$result = array('result' => false, 'message' => 'Failed to post. ' . $mysqli->error);
			return $result;
		}

		$stmt->bind_param('iisssi', $author, time(), $title, $data, $thumbnail, $category);
		if ($stmt->execute())
			$result = array('result' => true, 'message' => 'Update successfully posted.');
		else
			$result = array('result' => false, 'message' => 'Failed to post. ' . $stmt->error);

		return $result;
	}

	function preview_post($index, $src = '', $preview_limit = 200)
	{
		$data = get_post($index);
		return preview_post_data($index, $data, $src, $preview_limit);
	}

	function preview_post_data($index, $data, $src = '', $preview_limit = 160)
	{
		if ($data == null)
			return 'Invalid post.';

		global $categories;
		$post_title = $data['title'];
		$post_date = $data['date'];
		$post_data = $data['post'];
		$thumbnail = $data['thumbnail'];
		$category = $categories[$data['category']];
		$post_theme = $category['css'];
		if ($preview_limit != 0 && $preview_limit != 65535)
		{
			if($thumbnail != null)
				$preview_limit = 160;
			else
				$preview_limit = 250;
		}

		$display_data = $post_data;
		if ($preview_limit > 0 && $preview_limit < 65535)
		{
			$stripped = strip_tags($post_data, '<br><br/><strong><strong/>');
			$display_data = $stripped;
			if (strlen($stripped) > $preview_limit)
				$display_data = substr($stripped, 0, $preview_limit) . "...";
		}
		$visit_link = 'viewpost.php?id=' . $index . (!empty($src) ? '&amp;src=' . $src : '');

		$result = '
			<div id="' . $post_theme . '">';
		if ($thumbnail != null)
		{
			$image_link = $thumbnail;
			$video_id = '';
			if (strrpos($thumbnail, "yt:") === 0)
			{
				$video_id = substr($thumbnail, 3);
				$image_link = 'http://img.youtube.com/vi/' . $video_id . '/hqdefault.jpg';
			}
			if (empty($video_id) || ($preview_limit > 0 && $preview_limit < 65535))
			{
				$result .= '<a href="' . ($preview_limit > 0 ? $visit_link : $thumbnail) . '">';
				$result.= '<img src=' . $image_link . ' id="post_thumb" width="240" height="135"></a>';
			}
			if (!empty($video_id) && ($preview_limit == 0 || $preview_limit == 65535))
			{
				$thumbnail = null;
				$display_data = '<div style="width:560px; height:340px; margin:auto;"><iframe width="560" height="315" src="https://www.youtube.com/embed/' . $video_id . '" frameborder="0" allowfullscreen></iframe></div>' . $display_data;
			}
		}

		$result .= '
					<div id="post_text">
						<div style="float:left;' . ($thumbnail != null ? 'width:57.8%' : 'width:100%;') . '">
							<div style="float:left; width:90%; padding: 0px;">
								
								<div id="post_title"><a href="' . $visit_link . '">' . $post_title . '</a></div><div id="post_summary"><u>Lin</u> posted on ' . date('M j, Y', $post_date) . '</div>
								
							</div>
							<div style="float:right;">
								<a class="" href="' . $visit_link . '">#' . $index . '</a>
							</div>
						</div>
						<div class="fixed" style="margin:0px; ' . ($thumbnail != null ? '' : 'clear:both;') . '">' . $display_data . '</div>';



		if ($preview_limit > 0)
			$result .= '<strong><a class="" href="' . $visit_link . '" style="float:right; margin-top:4px;">View Post</a></strong>';

		$result .= '
		
					</div>
			</div>';

		return $result;
	}
	