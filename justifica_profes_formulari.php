<html><head><title>JU.FA.P.</title> <script language="javascript" type="text/javascript" src="datetimepicker.js"></script></head>
<table border="0" width="100%" id="table2"><tr>
<td width="22%"><font face="Verdana" size="1"><p align="left"><b>JU.FA.P.</b></font></p></td>
<td width="56%"><font face="Verdana" size="1" color="red"><p align="center"><b>1. Tria professor. 3. Tria data. 4. Tria motiu. 5. Prem el boto</b></p></td>
<td width="22%"><font face="Verdana" size="1"><p align="right"><b>JUstifica FALtes Profes</b></p></font></td>
</tr></table><hr>

<?php include "connectaBD.php";include "PassaVars.php";
date_default_timezone_set("Europe/Madrid");
$idalumne = $_POST["idalumne"];
$data1    = $_POST["data1"];
$tipus    = $_POST["tipus"];
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

	$sql2 = "SELECT * FROM mdl_cohort_members WHERE ((userid='$userid') AND (cohortid=45))";
	$result2=mysql_query($sql2, $conexion);
	while($row2=mysql_fetch_row($result2)){
		$idprofe=$row2[0];
            }
	if (($userid == 7) OR (($userid <> 1) AND ($idprofe <> 0))){
/***************************************************************************************************/

	echo "<table  style='text-align: left margin-left: auto; margin-right: auto; width:100%; height: 44px;' border='0'>
	<tbody>
	<tr align='center'>
	<td width='100%'>
	<form method='POST' action='justifica_profes_llistat.php?idalumne=$idalumne'>
	<select  name='idalumne' class='select' >
		<option value=''>Tria professor</option>";

		$sql3="SELECT * FROM mdl_user a, mdl_cohort_members b WHERE ((b.cohortid=43) AND (a.id=b.userid)) ORDER BY a.lastname";
		$result3=mysql_query($sql3, $conexion);
		while($row3=mysql_fetch_row($result3)){
			$compta_alumnes=$compta_alumnes+1;

		echo "<option value='$row3[0]'>$compta_alumnes: $row3[11], $row3[10] ($row3[0])</option>";

	}

	echo "</select>";

	echo"<br><br>
	<select  name='tipus' class='select' >
		<option value=''>Tria motiu</option>
		<option value='B'>Baixa</option>
		<option value='M'>Error</option>
		<option value='J'>Malaltia</option>
		<option value='I'>Permis</option>
		<option value='U'>Reunio</option>
		<option value='D'>Sortida</option>
		</select>";

echo "<br>";
echo "<br>";

echo <<< HTML
<input name="data1" id="data1" type="text" size="7" value="Tria data>">
<a href="javascript:NewCal('data1','ddmmmyyyy')"><img src="imatges/cal.gif" width="16" height="16" border="0" title="Tria una data"></a>

HTML;

echo "<br>";
/*echo "<p><font face='Verdana' size='2'>Posa algun comentari:</font></p>";
echo "<input name='observacions' type='text size='50' value=''>";
echo "<br>";*/
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
echo"<p align='center'><font face='Verdana' size='2' color='red'><b>ACCES DENEGAT!</b></font></p>";
}
}
/******************************************************************************************************/

?>

<hr><p align="center"><font face="Verdana" size="1">(c) V.L.G.A. 2014</font></p></font></body></html