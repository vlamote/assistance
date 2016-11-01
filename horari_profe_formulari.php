<html><head><title>HORA.P.</title> <script language="javascript" type="text/javascript" src="datetimepicker.js"></script></head>
<table border="0" width="100%" id="table2"><tr>
<td width="22%"><font face="Verdana" size="1"><p align="left"><b>HORA.P.</b></font></p></td>
<td width="56%"><font face="Verdana" size="1" color="red"><p align="center"><b>1. Tria profe. 2. Tria data. 3. Prem el boto</b></p></td>
<td width="22%"><font face="Verdana" size="1"><p align="right"><b>HORAri Profes</b></p></font></td>
</tr></table><hr>

<?php include "connectaBD.php";include "PassaVars.php";

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

	$sql2 = "SELECT * FROM mdl_cohort_members WHERE ((userid='$userid') AND ((cohortid=43) OR (cohortid=44) OR (cohortid=45) OR (cohortid=59)))";
	$result2=mysql_query($sql2, $conexion);
	while($row2=mysql_fetch_row($result2)){
		$idprofe=$row2[0];
            }

	if (($userid==7) OR (($userid <> 1) AND ($idprofe <> 0))){
/***************************************************************************************************/

$idalumne = $_POST["idalumne"];
$data1    = $_POST["data1"];
$observacions   = $_POST["observacions"];
$compta_alumnes=0;
$compta_grups=0;

echo "<p align='center'><font face='Verdana' size='2' color='red'>Es possible que alguna sessio a prop de canvis horaris d'estiu o hivern (finals del 10 i/o finals del 03)<br><b>tinguin algun desfassament horari</b> degut a que cada any aquestes dates son diferents.<br>El sistema considera el canvi horari el 01/04 i el 01/11!</p>";

echo "<table  style='text-align: left margin-left: auto; margin-right: auto; width:100%; height: 44px;' border='0'>
  <tbody>
    <tr align='center'>
      <td width='100%'>";

echo "
<form method='POST' action='horari_profe_llistat.php?idalumne=$idalumne'>
<select  name='idalumne' class='select' >
<option value=''>Tria profe</option>";
$sql3="SELECT * FROM mdl_user a, mdl_cohort_members b WHERE ((b.cohortid=43) AND (a.id=b.userid)) ORDER BY a.lastname";
$result3=mysql_query($sql3, $conexion);
while($row3=mysql_fetch_row($result3)){
$compta_alumnes=$compta_alumnes+1;
echo "<option value='$row3[0]'>$compta_alumnes: $row3[11], $row3[10] ($row3[0])</option>";
}
echo "</select>";

echo "<br>";
echo "<br>";
echo <<< HTML
<input name="data1" id="data1" type="text" size="7" value="Tria data >>>>>>"><a href="javascript:NewCal('data1','ddmmyyyy')"><img src="imatges/cal.gif" width="16" height="16" border="0" title="Tria una data"></a>

HTML;

echo "<br>";
echo "<br>";
echo "<input value='Troba' type='submit'>";

echo "</form>
      </td>
    </tr>
  </tbody>
</table>";

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
