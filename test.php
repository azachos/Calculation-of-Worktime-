<?
echo $_POST['category'];
$monthLength = $_POST['length'];
$year = $_POST['year'];
echo $monthLength;
session_start();
$session_id = uniqid();
echo $session_id;
$xml_output = "<?xml version=\"1.0\"?>\n";
$xml_output .= "<data>\n";
$xml_output .= "<id>" .$session_id ."</id>\n";
$xml_output .= "<category>" .$_POST['category']. "</category>\n";
for($i=0 ; $i<$monthLength; $i++) {
				$xml_output .= "<day>\n";
				$day = $i+1;
				$xml_output .= "<startdate>:" .$year ."-" .$_POST['month'] ."-" .$day ." " .$_POST['start_time_day'.$i]. "</startdate>\n";
				$xml_output	.= "<enddate>:" .$year ."-" .$_POST['month'] ."-" .$day ." " .$_POST['end_time_day'.$i]. "</enddate>\n";
				$xml_output .= "</day>\n";
}
$xml_output .= "</data>\n";
echo "aa";
echo $xml_output;

$myFile = "data.xml";
$fh = fopen($myFile, 'w') or die("can't open file");
fwrite($fh, $xml_output);
fclose($fh);

session_destroy();
?>
