<html><head><title>JU.FAL.O.</title> <script language="javascript" type="text/javascript" src="datetimepicker.js"></script></head>
<table border="0" width="100%" id="table2"><tr>
<td width="22%"><font face="Verdana" size="1"><p align="left"><b>JU.FAL.O.</b></font></p></td>
<td width="56%"><font face="Verdana" size="1" color="red"><p align="center"><b>1. Tria grup. 2. Tria alumne. 3. Tria data. 4. Posa observacions. 5. Prem el boto</b></p></td>
<td width="22%"><font face="Verdana" size="1"><p align="right"><b>JUstifica FALtes Online</b></p></font></td>
</tr></table><hr>

<?php include "connectaBD.php";include "PassaVars.php";

$idalumne = $_POST["idalumne"];
$data1    = $_POST["data1"];
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
	/*COHORTS DE TUTORS: 35 36 37 38 39 40 41 42  83 84 85 106*/
	/*COHORT DE COORDINADORS: 44*/
	/*COHORT DE PROFESSORS: 43*/
	/*COHORT DE DIRECCIO: 45*/
	/*****************************************************/

	$sql2 = "SELECT * FROM mdl_cohort_members WHERE ((userid='$userid') AND ((cohortid=35) OR (cohortid=36) OR (cohortid=37) OR (cohortid=38) OR (cohortid=39) OR (cohortid=40) OR (cohortid=41) OR (cohortid=42) OR (cohortid=44) OR (cohortid=83) OR (cohortid=84) OR (cohortid=85) OR (cohortid=106)))";
	$result2=mysql_query($sql2, $conexion);
	while($row2=mysql_fetch_row($result2)){
		$idprofe=$row2[0];
		$tutoria=$row2[1];
            }
	if (($userid == 7) OR (($userid <> 1) AND ($idprofe <> 0))){
/***************************************************************************************************/

echo "<table  style='text-align: left margin-left: auto; margin-right: auto; width:100%; height: 44px;' border='0'>
  <tbody>
    <tr align='center'>
      <td width='100%'>

<form name =\"triaalumne\" action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\">\n\n";

echo"<select name=\"id\" class='select' onChange=\"this.form.submit()\">\n";

echo "<option value=''>Tria grup</option>";

$sql2="SELECT * FROM mdl_cohort WHERE (idnumber LIKE '%ALUM%') ORDER BY idnumber";
$result2=mysql_query($sql2, $conexion);
while($row2=mysql_fetch_row($result2)){
$grup=$row2[0];
$compta_grups=$compta_grups+1;
echo "<option value=$row2[0]>$compta_grups: $row2[3]</option>";
}
echo "</select>";
echo "</form>";

echo "
<form method='POST' action='justifica_alumnes_llistat.php'>
<select  name='idalumne' class='select' >
<option value=''>Tria alumne</option>";
$sql3="SELECT * FROM mdl_user a, mdl_cohort_members b WHERE ((b.cohortid=$id) AND (a.id=b.userid)) ORDER BY a.lastname";
$result3=mysql_query($sql3, $conexion);
while($row3=mysql_fetch_row($result3)){
$compta_alumnes=$compta_alumnes+1;
echo "<option value='$row3[0]'>$compta_alumnes: $row3[11], $row3[10] ($row3[0])</option>";
}
echo "</select>";

echo "<br>";
echo "<br>";
echo <<< HTML
<input name="data1" id="data1" type="text" size="7" value="Tria data >>>>>>">
<a href="javascript:NewCal('data1','ddmmmyyyy')"><img src="imatges/cal.gif" width="16" height="16" border="0" title="Tria una data"></a>

HTML;

echo "<br>";
echo "<p><font face='Verdana' size='2'>Posa algun comentari:</font></p>";
echo "<input name='observacions' type='text size='50' value=''>";
echo "<br>";
echo "<br>";
echo "<input value='Justifica' type='submit'>";

echo "</form>
      </td>
    </tr>
  </tbody>
</table>";

include "desconnectaBD.php";

/*******************CONTROL DE ACCES FINAL********************************************************/
}
else{
echo"<p align='center'><font face='Verdana' size='2' color='red'><b>Tutoria: ".$tutoria." ACCES DENEGAT!</b></font></p>";
}
}
/******************************************************************************************************/

?>

<hr><p align="center"><font face="Verdana" size="1">(c) V.L.G.A. 2014</font></p></font></body></html>
