<html><head>
<script language="javascript" type="text/javascript" src="datetimepicker.js"></script></head><body>
<title>OP.AL.</title></head><body bgcolor="#FFFFFF">
<table border="0" width="100%" id="table2"><tr>
<td width="22%"><font face="Verdana" size="1" color="black"><p align="left"><b>OP.AL.</b></p></td>
<td width="56%"><font face="Verdana" size="1" color="red"><p align="center"><b>Tria una enquesta i pica el boto</b></p></td>
<td width="22%"><font face="Verdana" size="1" color="black"><p align="right"><b>OPtatives ALumnes</b></font></p></td>
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
	$cohort=43;
	$sql2 = "SELECT * FROM mdl_cohort_members WHERE ((userid='$userid') AND (cohortid='$cohort'))";
	$result2=mysql_query($sql2, $conexion);
	while($row2=mysql_fetch_row($result2)){
		$idprofe=$row2[0];
            }

	if (($userid==7) OR (($userid <> 1) AND ($userid <> 7) AND ($idprofe <> 0))){ 

/***************************************************************************************************/
/*EL PAS DE VARIABLES NO FUNCIONAVA A INTERNET (SI EN INTRANET)*/
/*DEU ESTAR "REGISTERGLOBALS" A "OFF" AL SERVIDOR, PER QUESTIONS DE SEGURETAT*/
/***************************************************************************************************/

$tipus = $_POST["tipus"];

/**************************/
/*TAULA AMB FORMULARI*/
/**************************/
echo "<table  style='text-align: center margin-left: auto; margin-right: auto; width:100%; height: 44px;' border='0'>
  <tbody>
    <tr align='center'>
      <td width='100%'>	
      <form method='get' action='optatives_llistat.php?tipus=$tipus'>
        <font face='Arial' size='2'> 
        <select name='tipus'>
		<option value=''>1.- Tria enquesta</option>";
		$sql01 = "SELECT * FROM mdl_feedback WHERE (anonymous='2') AND (name LIKE '%optatives%') ORDER BY name ASC";
		$result01=mysql_query($sql01, $conexion);
		while($row01=mysql_fetch_row($result01)){
			$tipus=$row01[2];
			echo "<option value='$row01[0]'>$tipus</option>";
		}
echo "
        </select>
        </font>
        <input value='2. Genera consulta' type='submit'>
      </form>
      </td>
    </tr>
  </tbody>
</table>";

include "desconnectaBD.php";

/*******************CONTROL DE ACCES FINAL********************************************************/
}
else{
echo"<p align='center'><font face='Verdana' size='2' color='red'><b>ACCÉS DENEGAT!</b></font></p>";
}
}
/******************************************************************************************************/
?>
<hr><p align="center"><font face="Verdana" size="1">(c) V.L.G.A. 2016</font></p></body></html>