<!DOCTYPE HTML>
<?php 
session_start();
if (!isset($_SESSION['email']))
	header('location: login.php');
error_reporting(E_ALL ^ E_DEPRECATED);
require_once('connect.php');
$db = mysql_select_db('blogname');


?>
<html>
<head>
<title>Show Blog</title>
</head>
<body>
here is blog content<hr/>
<?php
$sql = mysql_query("SELECT * FROM posts ORDER BY id");
while ($row=mysql_fetch_array($sql)){
$title=$row['title'];
$content=$row['content'];
$date=$row['date'];

?>
<table border="1">
<tr><td><?php echo $title;?></td>
<td><?php echo $date;?></td>
</tr>
<tr><td colspan="2"><?php echo $content;?></td></tr>
</table>
<?php
}
?>
</body>
</html>