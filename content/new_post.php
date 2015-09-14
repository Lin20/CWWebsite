<script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
	tinymce.init({
		selector: "textarea",
		theme: "modern",
		plugins: [
			"advlist autolink lists link image charmap print preview hr anchor pagebreak",
			"searchreplace wordcount visualblocks visualchars code fullscreen",
			"insertdatetime media nonbreaking save table contextmenu directionality",
			"emoticons template paste textcolor colorpicker textpattern"
		],
		toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
		toolbar2: "print preview media | forecolor backcolor emoticons",
		image_advtab: true,
		templates: [
			{title: "Test template 1", content: "Test 1"},
			{title: "Test template 2", content: "Test 2"}
		]
	});
</script>


<h1>New Post</h1>
<div id="new_post">

	<form method="post" action="confirm_post.php">

		<p><span><input type="text" id="post_title" name="title" value="" placeholder="Title" maxlength="255"></span></p>
		<p><textarea name="post" id="post_post" placeholder="Post" maxlength="65535" rows="10"></textarea></p>
		<p><span><input type="text" id="post_thumbnail" name="thumbnail" value="" placeholder="Thumbnail (optional)"></span></p>
		<p><span><select id="post_category" name="category">

				global $total_categories;
				global $categories;
					for($i = 1; $i <= $total_categories; $i++)
					{
					echo '<option value="' . $i . '" ' . ($i == 1 ? 'selected' : '') . '> ' . $categories[$i]['name'] . '</option>';
					}


				</select></span></p>
		<p>Password: <span><input type="password" id="post_password" name="password" value="" placeholder="Password"></span></p>
		<p><span><input type="submit" value="Post"></span></p>
	</form>

</div>