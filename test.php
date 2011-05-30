<?
//echo $_POST['category'];
$monthLength = $_POST['length'];
$year = $_POST['year'];
//echo $monthLength;
//session_start();
$session_id = uniqid();
//echo $session_id;
$xml_output = "<?xml version=\"1.0\"?>\n";
$xml_output .= "<data>\n";
$xml_output .= "<id>" .$session_id ."</id>\n";
$xml_output .= "<category>" .$_POST['category']. "</category>\n";
for($i=0 ; $i<$monthLength; $i++) {
				$xml_output .= "<day>\n";
				$day = $i+1;
				$xml_output .= "<dayoff>" .$_POST['dayoff'.$i] ."</dayoff>\n" ."<startdate>" .$year ."-" .$_POST['month'] ."-" .$day ." " .$_POST['start_time_day'.$i]. "</startdate>\n";
				$xml_output	.= "<enddate>" .$year ."-" .$_POST['month'] ."-" .$day ." " .$_POST['end_time_day'.$i]. "</enddate>\n";
				$xml_output .= "</day>\n";
}
$xml_output .= "</data>\n";

echo $_POST['dayoff4'];
//echo $xml_output;


$myFile = "data.xml";
$fh = fopen($myFile, 'w') or die("can't open file");
fwrite($fh, $xml_output);
fclose($fh);

#CODE FOR DATABASE INTERACTION 
#
#
$Server = "ALEX-PC\SQLEXPRESS";

$connectionInfo = array( "Database"=>"TIMEATT6");
//connection to the database
$dbconn = sqlsrv_connect($Server, $connectionInfo)
  or die("Couldn't connect to SQL Server on $Server");

  /*
$myFile = "data.xml";
$ParameterOne = "";
$fh = fopen($myFile, 'r');
$ParameterOne = fread($fh,filesize($myFile));
fclose($fh);


echo "<!--" .$ParameterOne ."-->";
*/

$xml = simplexml_load_string($xml_output);
$getdata = $xml->xpath("/data/id");
//echo $getdata[0];
//declare the SQL statement that will query the database
$query = "execute InputDays4 '" .$xml_output ."'";

//execute the SQL query and return records
sqlsrv_query($dbconn, $query);

$query = "execute myproc '" .$getdata[0] ."'";
//execute the SQL query and return records
$result = sqlsrv_query($dbconn, $query);

//display the results
if ($result != null) {
	//echo $result;
	//echo "num rows" .sqlsrv_num_rows($result);
	?>
	<html><head><meta http-equiv="Content-type" content="text/html; charset=iso8859-7;" />
	<link rel="stylesheet" type="text/css" href="style.css"></head>
	<body>
	<table>
	<tr>
		<td>
				<table class="sample">
				<tr><td>ыяес</td></tr>
				<tr><td>йамом</td></tr>
				<tr><td>упея 1.2</td></tr>
				<tr><td>упея 1.8</td></tr>
				<tr><td>мувта 1.25</td></tr>
				<tr><td>саббато 1.3</td></tr>
				<tr><td>упея саб 2.10</td></tr>
				<tr><td>йуя/аяциа 1.75</td></tr>
				<tr><td>упея йуя/аяциа</td></tr>
				</table>
			</td>
	<?
	while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
	?> 
			<td>
				<table class="sample">
				<tr><td><?if ($row['totaltime'] != null) echo $row['totaltime']; else echo 0;?></td></tr>
				<tr><td><?if ($row['OT1'] != null) echo $row['OT1'];  else echo 0;?></td></tr>
				<tr><td><?if ($row['OT12'] != null) echo $row['OT12'];  else echo 0;?></td></tr>
				<tr><td><?if ($row['OT18'] != null) echo $row['OT18'];  else echo 0;?></td></tr>
				<tr><td><?if ($row['night'] != null) echo $row['night'];  else echo 0;?></td></tr>
				<tr><td><?if ($row['OT13'] != null) echo $row['OT13'];  else echo 0;?></td></tr>
				<tr><td><?if ($row['OT21'] != null) echo $row['OT21'];  else echo 0;?></td></tr>
				<tr><td><?if ($row['OT175'] != null) echo $row['OT175'];  else echo 0;?></td></tr>
				<tr><td><?if ($row['OT255'] != null) echo $row['OT255'];  else echo 0;?></td></tr>
				</table>
			</td>
	<? } ?>	
	</tr>
	</table>
	</body>
	</html>
<?
} else {
     echo "error";
}

sqlsrv_close($dbconn);
#END OF CODE FOR DATABASE INTERACTION
#
#
//session_destroy();
?>
