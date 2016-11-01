<html><head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<title>C.HO.ZO.PRO.</title> <script language="javascript" type="text/javascript" src="datetimepicker.js"></script></head>
<table border="0" width="100%" id="table2"><tr>
<td width="22%"><font face="Verdana" size="1"><p align="left"><b>C.HO.ZO.PRO.</b></font></p></td>
<td width="56%"><font face="Verdana" size="1" color="red"><p align="center"><b>CONFIRMACIÓ DE CREACIÓ DE L'HORARI DE LA ZONA PROFES</b></p></td>
<td width="22%"><font face="Verdana" size="1"><p align="right"><b>Crea HOrari ZOna PROfes</b></p></font></td>
</tr></table><hr>

<?php include "connectaBD.php";include "PassaVars.php";include "Funcions_Temporals.php";

/*PER A NO TENIR PROBLEMES AMB CARACTERS ESTRANYS*/
mysql_query("SET NAMES 'utf8'");
header("Content-Type: text/html;charset=utf-8");

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

	if (($userid==7) OR ($userid==2848)){
/***************************************************************************************************/

echo "
<p align='center'>
<font face='Verdana' size='3' color='red'>
Estàs segur que vols crear les vora a 3.000 sessions de l'horari de la Zona Profes?????
<br>
<br>
Des del 15 de setembre d'AQUEST ANY fins al 30 de juny de l'any que ve?????
<br>
<br>
Des de la primera hora del matí fins a la darrera de la tarda?????
<br>
<br>
Recorda de comprovar els voltants de final de mes d'octubre i març
<br>
<br>
per veure els desfassaments horaris del canvi d'hora
<p align='left'><font face='Verdana' size='2' color='blue'>
===========================================<br>
NOVETATS DE L'APLICATIU A 23 DE FEBRER DE 2016:<br>
===========================================<br><br>
1.- Ja no es permet repetir sessions.<br><br>
2.- Ja no crea sessions els festius i vacances.<br><br>
Això fa que les estadístiques de sessions a les que es passa  llista o que no, JA SON FIABLES.<br>
</p>
<table  style='text-align: center margin-left: 200px; margin-right: auto; width:100%; height: 44px;' border='0'>
  <tbody>
    <tr align='center'>
      <td width='100%'>
	<form method='POST' action='crea_horari_zona_profes_llistat.php'>
		<input value='Confirma la creacio' type='submit'>
	</form>
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

<hr><p align="center"><font face="Verdana" size="1" color='black'>(c) V.L.G.A. 2016</font></p></font></body></html>