<html><head>
<script language="javascript" type="text/javascript" src="datetimepicker.js"></script></head><body>
<title>LL.E.P.A.M.</title></head><body bgcolor="#FFFFFF">
<table border="0" width="100%" id="table2"><tr>
<td width="22%"><font face="Verdana" size="1" color="black"><p align="left"><b><a href="/assistencia/profes_materies_formulari.php">LL.E.P.A.M.</a> | <a href="/assistencia/profes_cohorts_quadrant.php">Quadrant</a></b></p></td>
<td width="46%"><font face="Verdana" size="1" color="red"><p align="center"><b>Tria el curs del qual en vols veure els professors</b></p></td>
<td width="32%"><font face="Verdana" size="1" color="black"><p align="right"><b>LListat d'Equivalencies de Professor Amb Materia</b></font></p></td>
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

//EL PAS DE VARIABLES NO FUNCIONAVA A INTERNET (SI EN INTRANET) DEU ESTAR "REGISTERGLOBALS" A "OFF" AL SERVIDOR, PER QUESTIONS DE SEGURETAT

$nivell = $_POST["nivell"];

//TAULA AMB FORMULARI

echo "<table  style='text-align: center margin-left: auto; margin-right: auto; width:100%; height: 44px;' border='0'>
  <tbody>
    <tr align='center'>
      <td width='100%'>
	
      <form method='get' action='profes_materies_llistat.php?nivell=$nivell'>

        <font face='Arial' size='2'>
 
        <select name='nivell'>
        <option value='Tots'>Tots els cursos</option>
        <option value='1ESO'>1ESO</option>
        <option value='2ESO'>2ESO</option>
        <option value='3ESO'>3ESO</option>
        <option value='4ESO'>4ESO</option>
        <option value='1BAT'>1BAT</option>
        <option value='2BAT'>2BAT</option>
        <option value='1CFGM'>1CFGM</option>
        <option value='2CFGM'>2CFGM</option>
        <option value='1CFGS'>1CFGS</option>
        <option value='2CFGS'>2CFGS</option>
        <option value='PFI'>PFI</option>
        <option value='CAGS'>CAGS</option>
        </select>";

echo "
        </font>
        <input value='Mostra profes' type='submit'>
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