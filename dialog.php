<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<head>
  <link rel="stylesheet" href="css/dialog.css" type="text/css">
<script src="im/jquery-1.8.2.js" type="text/javascript"></script>  
<script type="text/javascript">
  function goal(flag){
  var flag;
  $(document).ready(function(flag){
  		function returnValue(x){
  			if (x == '1'){
  				location.reload();
  			}else{}
		}
       	$.ajax({
        	url: "modules/checkscript.php",
        	type: "GET",
        	cache: true,
        	data: {id: "<?echo $_GET['id']?>"},
        	success: function(data){  
        	returnValue(data);
          }
    	});
	});
}
setInterval(goal, 1000);
</script>
</head>
<body>
<?php
// Скрипт проверки
include "config.php";
include "converter_code.php";

# Соединямся с БД
mysql_connect($host, $db_login, $db_password);
mysql_select_db($db_name);
mysql_set_charset("utf8");

$my_id = $_COOKIE['id'];
$friend = $_GET["id"];
$query = "SELECT id, from_user, to_user, text, time, readstatus, deletestatus FROM wc__messages WHERE (to_user = '".$friend."' OR from_user = '".$friend."') AND (to_user = '".$my_id."' OR from_user = '".$my_id."') ORDER BY time DESC";
$res = mysql_query($query) or die(mysql_error());

while ($row = mysql_fetch_array($res)) {
	$avaquery = mysql_query("SELECT *,INET_NTOA(user_ip) FROM wc__superusers WHERE user_id = '".$row['from_user']."' LIMIT 1");
	$avatarparcing = mysql_fetch_assoc($avaquery);
	$username = $avatarparcing['user_name']." ".$avatarparcing['user_surname'];
	mysql_query("UPDATE  wc__messages SET  readstatus =  0 WHERE  id = '".$row['id']."' AND to_user = '".$my_id."'");
  echo '<div id="box"><div id="message">';
  echo '<div id="avatar"><img src="userupload/uploads/';
  echo $avatarparcing['user_smallavatar'];
  echo '.jpg" width="50" border="5"></div>';
  echo '<div id="mesbox">';
    echo '<div id="name"><b>'.$username.'</b></div><div id="text" style="font-size: 14px;">'.$row['text'].'</div><div id="date">'.$row[time].'</div>';
  echo '</div></div></div>';
}
?>
</body>