<?php

include ('../config.php');
mysql_connect($host, $db_login, $db_password);
mysql_select_db($db_name);

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$targ_w = $targ_h = 100;
	$jpeg_quality = 90;

	$add_photo = "INSERT INTO  wc__images (ID) VALUES (NULL)";
	$photo_name = "SELECT * FROM wc__images WHERE ID = last_insert_id()";
	mysql_query($add_photo);
	$newname = mysql_query($photo_name);
	$name = mysql_fetch_assoc($newname);
	$newname = $name['ID'];
	mysql_query("UPDATE wc__superusers SET user_smallavatar = '".$newname."' WHERE user_id='".$_COOKIE['id']."'");

	$src = 'files/'.$_COOKIE['id'].'.jpg';
	$img_r = imagecreatefromjpeg($src);
	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

	imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],
	$targ_w,$targ_h,$_POST['w'],$_POST['h']);

	//header('Content-type: image/jpeg');
	imagejpeg($dst_r,"../userupload/uploads/".$newname.".jpg",$jpeg_quality);
	echo "done";
	unlink('files/'.$_COOKIE['id'].'.jpg');
	exit;
}

// If not a POST request, display page below:

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>

		<script src="js/jquery.min.js"></script>
		<script src="js/jquery.Jcrop.js"></script>
		<link rel="stylesheet" href="css/jquery.Jcrop.css" type="text/css" />
		<link rel="stylesheet" href="files/demos.css" type="text/css" />

		<script language="Javascript">

			$(function(){

				$('#cropbox').Jcrop({
					aspectRatio: 1,
					onSelect: updateCoords
				});

			});

			function updateCoords(c)
			{
				$('#x').val(c.x);
				$('#y').val(c.y);
				$('#w').val(c.w);
				$('#h').val(c.h);
			};

			function checkCoords()
			{
				if (parseInt($('#w').val())) return true;
				alert('Please select a crop region then press submit.');
				return false;
			};

		</script>

	</head>

	<body>
		<!-- This is the image we're attaching Jcrop to -->
		<img src="files/<?echo $_COOKIE['id'];?>.jpg" id="cropbox" />

		<!-- This is the form that our event handler fills -->
		<form action="crop.php" method="post" onsubmit="return checkCoords();">
			<input type="hidden" id="x" name="x" />
			<input type="hidden" id="y" name="y" />
			<input type="hidden" id="w" name="w" />
			<input type="hidden" id="h" name="h" />
			<input type="submit" value="Crop Image" />
		</form>
	</body>

</html>
