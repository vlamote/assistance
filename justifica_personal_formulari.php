<html><head><title>JUFALO</title> <script language="javascript" type="text/javascript" src="datetimepicker.js"></script></head>
<table border="0" width="100%" id="table2"><tr>
<td width="33%"><font face="Verdana" size="1"><p align="left"><b>JUFALO</b></font></p></td>
<td width="34%"><font face="Verdana" size="1"color="red"><p align="center"><b>1. Tria grup. 2. Tria alumne. 3. Tria data. 4. Posa observacions. 5. Prem el boto</b></font></p></td>
<td width="33%"><font face="Verdana" size="1"><p align="right"><b>JUstificacio de FALtes Online</b></p></font></td>
</tr></table><hr>

<?php include "connectaBD.php";include "PassaVars.php";

$id=$_GET["id"];
$idalumne=$id;
$data1= $_POST["data1"];
$observacions   = $_POST["observacions"];
$compta_alumnes=0;
$compta_grups=0;

/*******************CONTROL DE ACCES INICI********************************************************/
require_once ('../config.php');
global $USER;
$userid=$USER->id;
if(!isloggedin()){
header('Location: http://iessitges.xtec.cat/login/index.php?id=284'); }
else {
	$idprofe=0;

	/*****************************************************/
	/*COHORTS DE TUTORS: 35 36 37 38 39 40 41 42  83 84 85*/
	/*COHORT DE COORDINADORS: 44*/
	/*COHORT DE PROFESSORS: 43*/
	/*COHORT DE DIRECCIO: 45*/
	/*****************************************************/

	$sql2 = "SELECT * FROM mdl_cohort_members WHERE ((userid='$userid') AND ((cohortid=35) OR (cohortid=36) OR (cohortid=37) OR (cohortid=38) OR (cohortid=39) OR (cohortid=40) OR (cohortid=41) OR (cohortid=42) OR (cohortid=44) OR (cohortid=83) OR (cohortid=84) OR (cohortid=85) OR (cohortid=106)))";
	$result2=mysql_query($sql2, $conexion);
	while($row2=mysql_fetch_row($result2)){
		$idprofe=$row2[0];
            }
	if (($userid == 7) OR (($userid <> 1) AND ($idprofe <> 0))){
/***************************************************************************************************/

    $sql2 = "SELECT * FROM mdl_user WHERE id=$idalumne";
    $result2=mysql_query($sql2, $conexion);
    while($row2=mysql_fetch_row($result2)){
    $alumne=$row2[11].", ".$row2[10];
     }

echo "<p align='center'><font face='verdana' size='2'><b>Justifica a l'alumne:</b> $alumne</font></p>";

echo "<form method='POST' action='justifica_personal_llistat.php?idalumne=$idalumne'>";

echo <<< HTML

<p align='center'><input name="data1" id="data1" type="text" size="7" value="Tria data >>>>>>">

<a href="javascript:NewCal('data1','ddmmmyyyy')">

<img src="imatges/cal.gif" width="16" height="16" border="0" title="Tria una data">
</p>
</a>

HTML;
echo "<p align='center'><font face='Verdana' size='2'>Posa algun comentari:</font></p>";
echo "<p align='center'><font face='Verdana' size='1' color='red'><b>*CAMP OBLIGATORI! (si no pot ser no us sortiran les justificacons al G.R.I.AL.)</b></font></p>";
echo "<p align='center'><input name='observacions' type='text size='50' value=''></p>";
echo "<p align='center'><input value='Justifica' type='submit'></p>";

echo "</form>";

include "desconnectaBD.php";

/*******************CONTROL DE ACCES FINAL********************************************************/
}
else{
echo"<p align='center'><font face='Verdana' size='2' color='red'><b>ACCES DENEGAT!</b></font></p>";
}
}
/******************************************************************************************************/

?>

<hr><p align="center"><font face="Verdana" size="1">(c) V.L.G.A. 2014</font></p></font></body></html>
