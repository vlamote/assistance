<html><head><title>LLI.PRO.</title>  

<LINK href="jquery/themes/blue/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="jquery/jquery-latest.js"></script>
<script type="text/javascript" src="jquery/jquery.tablesorter.js"></script>
<script type="text/javascript">

$(document).ready(function() {
$("#Incidencies").tablesorter({
sortList: [[0,0],[1,0]]
});
});

</script></head><body bgcolor="#FFFFFF">

<table border="0" width="100%" id="table2"><tr>
<td width="30%"><font face="Verdana" size="1"><p align="left"><b>LLI.PRO.</b></font></p></td>
<td width="40%"><font face="Verdana" size="1" color="red"><p align="center"><b>Passa per sobre els botons de la dreta per saber que fan.<br>Pica'ls per a realitzar les diferents opcions</b></font></p></td>
<td width="30%"><font face="Verdana" size="1"><p align="right"><b>LLIstat de PROfessors</b></p></font></td>
</tr></table><hr>

<?php include "connectaBD.php";include "PassaVars.php";

$id = $_POST["id"];
$comptador_cursos=0;
$comptador_alumnes=0;

/************CONTROL DE ACCES INICI********************/
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
	if (($userid == 7) OR (($userid <> 1) AND ($idprofe <> 0))){
/******************************************************/

echo "<div align='center'>
<table id='Incidencies' class='tablesorter' width='100px'>
<thead><tr>
<th width='80px' align='center'>Professor</th>
<th width='20px' align='center'>Accions</th>
</tr></thead></div>";

$sql="SELECT * FROM mdl_cohort WHERE idnumber LIKE 'PROFE'";
$result=mysql_query($sql, $conexion);
while($row=mysql_fetch_row($result)){

$sql1="SELECT * FROM mdl_cohort_members WHERE cohortid = '$row[0]'";
$result1=mysql_query($sql1, $conexion);
while($row1=mysql_fetch_row($result1)){

$sql2="SELECT * FROM mdl_user WHERE id = '$row1[2]'";
$result2=mysql_query($sql2, $conexion);
while($row2=mysql_fetch_row($result2)){

/*$grup=str_replace("PROFE","",$row[3]);*/
$grup=$row[3];

echo"                                   
<td align='left' width='80px'><font face='Verdana' size='1'>$row2[11], $row2[10]</font></td>
<td align='center' width='20px'><font face='Verdana' size='1'>

<a href='/user/profile.php?id=$row1[2]' target='blank' title='Perfil'><img src='http://iessitges.xtec.cat/assistencia/imatges/preview.svg'></a>
<a href='/message/index.php?id=$row1[2]' target='blank' title='Missatge'><img src='http://iessitges.xtec.cat/assistencia/imatges/mstge.svg'></a>
<a href='/assistencia/horari_personal_profe_llistat.php?id=$row1[2]' target='blank' title='Horari'><img src='http://iessitges.xtec.cat/assistencia/imatges/cal.svg'></a>
<a href='/assistencia/incidencies_personals_formulari.php?id=$row1[2]' target='blank' title='Incidencies'><img src='http://iessitges.xtec.cat/assistencia/imatges/incid.svg'></a>
<a href='/assistencia/justifica_personal_profes_formulari.php?id=$row1[2]' target='blank' title='Justificar'><img src='http://iessitges.xtec.cat/assistencia/imatges/just.svg'></a>

</font></td>
</tr>";
}
$comptador_alumnes=$comptador_alumnes+1;
}
$comptador_cursos=$comptador_cursos+1;
}
echo"<font face='Verdana' size=2>Total de professors: $comptador_alumnes</font>";
echo "</tbody>";
echo "</table>";
include "desconnectaBD.php";

/************CONTROL DE ACCES FINAL*********************/
}
else{
echo"<p align='center'><font face='Verdana' size='2' color='red'><b>ACCES DENEGAT!</b></font></p>";
}
}
/**********************************************************/
?>
<hr><p align="center"><font face="Verdana" size="1">(c) V.L.G.A. 2014</font></p></font></body></html>