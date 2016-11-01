<html><head><title>TROB.AL.</title> <script language="javascript" type="text/javascript" src="datetimepicker.js"></script></head>
<table border="0" width="100%" id="table2"><tr>
<td width="22%"><font face="Verdana" size="1"><p align="left"><b>TROB.AL.</b></font></p></td>
<td width="56%"><font face="Verdana" size="1" color="red"><p align="center"><b>1. Tria grup. 2. Tria alumne. 3. Tria data. 4. Prem el boto</b></p></td>
<td width="22%"><font face="Verdana" size="1"><p align="right"><b>TROBa Alumne</b></p></font></td>
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
<form method='POST' action='troba_alum_llistat.php'>
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
