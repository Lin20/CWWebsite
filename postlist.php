<?php

	require_once 'php/posts.php';
	$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
		
	$num_posts = 3;
	
	$stmt = $mysqli->prepare('SELECT * FROM posts WHERE category=? ORDER BY id DESC');
	$stmt->bind_param('i', $page_category);
	$stmt->execute();
	$stmt->bind_result($post_id, $post_author, $post_date, $post_updated, $post_title, $post_post, $post_thumbnail, $post_category);
	$stmt->store_result();
	
	$stmt->data_seek(($page - 1) * $num_posts);
	$data = null;
	
	$newsfeed = '<div style="padding:0 0 20px 0;">';
				
					for($i = 0; $i < $num_posts; $i++)
					{
						if(!$stmt->fetch())
						{
							//echo 'error';
							break;
						}
						$data = array('id' => $post_id, 'author' => $post_author, 'date' => $post_date, 'updated' => $post_updated, 'title' => $post_title, 'post' => $post_post, 'thumbnail' => $post_thumbnail, 'category' => $post_category);
						if($i == $total_posts[1])
						{
							$newsfeed .= '<p>' . preview_post_data($post_id, $data, $page_src) . '</p>';
						}
						else
							$newsfeed .= preview_post_data($post_id, $data, $page_src);
					}
					
	$stmt->close();
					
	$newsfeed .= '
					</div>
					<div style="text-align:center">';
					
	$num_pages = $total_posts[$page_category] / $num_posts + ($total_posts[$page_category] % $num_posts != 0 ? 1 : 0);
	for($i = 1; $i <= $num_pages; $i++)
	{
		$newsfeed .= '<a href="' . $page_src . '.php?page=' . $i . '" style="margin:4px"' . ($i == $page ? '" class="active"' : '') . '>' . $i . '</a>';
	}
					
	$newsfeed .= '</div>';
?>