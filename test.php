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
				
				//if end time is earlier than start time -> the end day is the next day
				$h1 = strtotime($_POST['start_time_day'.$i]);
				$h2 = strtotime($_POST['end_time_day'.$i]);
				$h1 = date("H", $h1);
				$h2 = date("H", $h2);
				$endday = $day;
				$endmonth = $_POST['month'];
				$endyear = $year;
				if ($h2<=$h1) {		//if end time is earlier than start time -> the end day is the next day
					$endday = $day+1;
					if (($endday) > $monthLength) {
						$endday = 1;
						$endmonth++;
						if ($endmonth == 13) {
							$endmonth = 1;
							$endyear++;
						}
					}
				}
				$xml_output .= "<holiday>" .$_POST['holiday'.$i] ."</holiday>\n" ."<dayoff>" .$_POST['dayoff'.$i]   ."</dayoff>\n" ."<startdate>" .$year ."-" .$_POST['month'] ."-" .$day ." " .$_POST['start_time_day'.$i]. "</startdate>\n";
				$xml_output	.= "<enddate>" .$endyear ."-" .$endmonth ."-" .$endday ." " .$_POST['end_time_day'.$i]. "</enddate>\n";
				$xml_output .= "</day>\n";
}
$xml_output .= "</data>\n";

echo $_POST['start_time_day1'] ."</br>";
$h2 = strtotime($_POST['start_time_day1'])."</br>";
//echo $_POST['dayoff4'];

$hour = date("H", $h2);
echo $hour;
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
//echo "<!--" .$ParameterOne ."-->";
*/

$xml = simplexml_load_string($xml_output);
$getdata = $xml->xpath("/data/id");
//echo $getdata[0];
//declare the SQL statement that will query the database
$query = "execute InputDays4 '" .$xml_output ."'";

//execute the SQL query and return records
$stmt=sqlsrv_query($dbconn, $query);

/*
$query = "execute myproc '" .$getdata[0] ."'";
//execute the SQL query and return records
$stmt = sqlsrv_query($dbconn, $query);
*/

$prev_stmt=$stmt;
while (sqlsrv_rows_affected($stmt) >0 ) {	//while positive we are fetching messages, -1 means recordset
//echo "<br>" .sqlsrv_rows_affected($stmt);	
$prev_stmt=$stmt;			//keep the previou statement
sqlsrv_next_result($stmt);	//next message
}
$result = $prev_stmt;	//load recordset

//display the results
if ($result) {
	//echo $result;
	//echo "num rows" .sqlsrv_num_rows($result);
	?>
	<html><head><meta http-equiv="Content-type" content="text/html; charset=utf-8;" />
	<link rel="stylesheet" type="text/css" href="style.css"></head>
	<body>
	<table class="sample">
<!--	<tr>
		<td>
			Day
		</td>
		<?
			for($i=0; $i<monthLength; $i++) {
				echo "<td>" .$i+1 ."</td>";
			}
		?>
	</tr>
	<tr>
		<td>
			Start
		</td>
		<?
			for($i=0; $i<monthLength; $i++) {
				echo "<td>" .$i+1 ."</td>";
			}
		?>
	</tr>
-->	<tr>
		<td>
				<table class="sample2">
				<tr><td>ΩΡΕΣ</td></tr>
				<tr><td>ΚΑΝΟΝ</td></tr>
				<tr><td>ΥΠΕΡ 1.2</td></tr>
				<tr><td>ΥΠΕΡ 1.8</td></tr>
				<tr><td>ΝΥΧΤΑ 1.25</td></tr>
				<tr><td>ΣΑΒΒΑΤΟ 1.3</td></tr>
				<tr><td>ΥΠΕΡ ΣΑΒΒΑΤΟ 2.10</td></tr>
				<tr><td>ΚΥΡ/ΑΡΓΙΑ 1.75</td></tr>
				<tr><td>ΥΠΕΡ ΚΥΡ/ΑΡΓΙΑ</td></tr>
				</table>
			</td>
	<?
	while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
	?> 
			<td>
				<table class="sample2">
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
