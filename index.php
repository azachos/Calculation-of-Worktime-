<html>

				<head>
								<title>
										web app
								</title>
									<meta http-equiv="Content-type" content="text/html; charset=utf-8;" />
								<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript" src="scripts.js"></script>
</head>

<body>
<div id="main">
<form name="form" action="" method="post">
<table align="center">												
<tr><td>Κατηγορία υπαλλήλου:</td><td>												
<select id="category" name="category">
<option selected value="O">Οικοδόμος</option>
<option value="H">Ημερομίσθιος</option>
<option value="Y">Υπάλληλος</option>
</select>

</td><tr>
<tr><td>										
Επιλογή μήνα:</td><td>
<select id="month" name="month" onchange="loadGrid();">
<?
$month = array ('January','February','March','April','May','June','July','August','September','October','November','December');
for($lt=0; $lt<12; $lt++) {
				if ($lt+1 == 5	)
								print("<option name='$month[$lt]' value='$lt' selected >$month[$lt]</option> \n");
				else
								print("<option name='$month[$lt]' value='$lt'>$month[$lt]</option> \n");
}
?>
</select>

				</td></tr></table>												

				</form>		
				<div id="myDiv"><script type="text/javascript">loadGrid()</script></div>
				<div id="otherDiv">Output:</div>
				</div>
				</body>

				</html>
