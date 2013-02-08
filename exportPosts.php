<?php
require_once 'includes/db.php';


mysql_set_charset('UTF-8');
$sql = 'select * from posts';
$result = mysql_query($sql) or die(mysql_error());

echo '<table>';
echo '<tr><thead><th>תאריך</th>' . 
	 '<th>שם פרטי</th>' . 
	 '<th>שם משפחה</th>' . 
	 '<th>פוסט</th></tr></thead><tbody>';

while($row = mysql_fetch_object($result))
	echo '<tr>' . '<td>' . $row->created . '</td>' . 
		 '<td>' . $row->first_name . '</td>' . 
		 '<td>' . $row->last_name . '</td>' . 
		 '<td>' . $row->message . '</td>' . '</tr>';

echo '</tbody></table>';
?>