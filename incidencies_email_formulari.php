<html><head>
<script language="javascript" type="text/javascript" src="datetimepicker.js"></script></head><body>
<title>ENVI.DI.A.</title></head><body bgcolor="#FFFFFF">
<table border="0" width="100%" id="table2"><tr>
<td width="22%"><font face="Verdana" size="1" color="black"><p align="left"><b></b></p></td>
<td width="56%"><font face="Verdana" size="1" color="black"><p align="center"><b>ENVI.ament DIgital d'Assistències</b></p></td>
<td width="22%"><font face="Verdana" size="1" color="black"><p align="right"><b>ENVI.DI.A.</b></font></p></td>
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
	if (($userid==7)){
/***************************************************************************************************/

//EL PAS DE VARIABLES NO FUNCIONAVA A INTERNET (SI EN INTRANET) DEU ESTAR "REGISTERGLOBALS" A "OFF" AL SERVIDOR, PER QUESTIONS DE SEGURETAT

$id = $_GET["id"];
$tipus = $_POST["tipus"];
$data1 = $_POST["data1"];
$data2 = $_POST["data2"];

// ESBRINO NOM ALUMNE

$sql="SELECT * FROM mdl_user WHERE id = '$id'";
$result=mysql_query($sql, $conexion);
while($row=mysql_fetch_row($result)){
$alumne=$row[11].", ".$row[10];

}

echo "<p align='center'><font face='Verdana' size='1' color='red'>Estàs segur que vols enviar missatge amb les incidències setmanals a tots els usuaris (aproximadament 1.000)?</font></p>";

//TAULA AMB FORMULARI

echo "
<table  style='text-align: center margin-left: auto; margin-right: auto; width:100%; height: 44px;' border='0'>
	<tbody>
		<tr align='center'>
			<td width='100%'>	
				<form method='post' action='incidencies_email_llistat.php?id=$id&data1=$data1&data2=$data2&tipus=$tipus&vista=$vista&triacurs=$triacurs&triagrup=$triagrup'>
					<input value='Procedeix' type='submit'>
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
<hr><p align="center"><font face="Verdana" size="1">(c) V.L.G.A. 2013</font></p></body></html>