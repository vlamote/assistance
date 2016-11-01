<html>
<head>
	<title>LL.A.C.</title>  
	<LINK href="jquery/themes/blue/style.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="jquery/jquery-latest.js"></script>
	<script type="text/javascript" src="jquery/jquery.tablesorter.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#Incidencies").tablesorter({
			sortList: [[0,0],[1,0]]
			});
		});
	</script>
</head>

<body bgcolor="#FFFFFF">

	<table border="0" width="100%" id="table2">
	<tr>
		<td width="22%"><font face="Verdana" size="1"><p align="left"><b>
			<a href="http://iessitges.xtec.cat/assistencia/llistat_alumnes.php" target="_self" title="Consulta per alumne">Alumne</a> |
			<a href="http://iessitges.xtec.cat/assistencia/notes_grups_formulari.php" target="_self" title="Consulta per grup">Grup</a> |
			<a href="http://iessitges.xtec.cat/assistencia/notes_materies_formulari.php" target="_self" title="Consulta per materia">Materia</a> | 
			<a href="https://saga.xtec.cat/entrada/nodes" target="_blank" title="Ves al SAGA">Saga</a></font></td>
		</td>
		<td width="40%"><font face="Verdana" size="1" color="red"><p align="center"><b>Passa per sobre els botons de la dreta per saber que fan.<br>Pica'ls per a realitzar les diferents opcions</b></font></p></td>
		<td width="30%"><font face="Verdana" size="1"><p align="right"><b>LListat d'alumnes per Cursos</b></p></font></td>
	</tr>
</table>


<hr>

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
<table id='Incidencies' class='tablesorter' width='400px'>
<thead><tr>
<th width='100px' align='center'>Cohort</th>
<th width='200px' align='center'>Alumne</th>
<th width='100px' align='center'>Accions</th>
</tr></thead></div>";

$sql="SELECT * FROM mdl_cohort WHERE idnumber LIKE '%ALUM%' AND name NOT LIKE '%GF%'";
$result=mysql_query($sql, $conexion);
while($row=mysql_fetch_row($result)){

$sql1="SELECT * FROM mdl_cohort_members WHERE cohortid = '$row[0]'";
$result1=mysql_query($sql1, $conexion);
while($row1=mysql_fetch_row($result1)){

$sql2="SELECT * FROM mdl_user WHERE id = '$row1[2]'";
$result2=mysql_query($sql2, $conexion);
while($row2=mysql_fetch_row($result2)){

$grup=str_replace("ALUM","",$row[3]);

echo"                                   
<td align='left' width='100px'><font face='Verdana' size='1'>$grup</font></td>
<td align='left' width='200px'><font face='Verdana' size='1'>$row2[11], $row2[10]</font></td>
<td align='center' width='100px'><font face='Verdana' size='1'>

<a href='/user/profile.php?id=$row1[2]' target='blank' title='Perfil'><img src='http://iessitges.xtec.cat/assistencia/imatges/preview.svg'></a>
<a href='/message/index.php?id=$row1[2]' target='blank' title='Missatge'><img src='http://iessitges.xtec.cat/assistencia/imatges/mstge.svg'></a>
<a href='/assistencia/horari_personal_alum_llistat.php?id=$row1[2]' target='blank' title='Horari'><img src='http://iessitges.xtec.cat/assistencia/imatges/cal.svg'></a>
<a href='/assistencia/incidencies_personals_formulari.php?id=$row1[2]' target='blank' title='Incidencies'><img src='http://iessitges.xtec.cat/assistencia/imatges/incid.svg'></a>
<a href='/assistencia/justifica_personal_formulari.php?id=$row1[2]' target='blank' title='Justificar'><img src='http://iessitges.xtec.cat/assistencia/imatges/just.svg'></a>
<a href='/assistencia/sanciona_personal_formulari.php?id=$row1[2]' target='blank' title='Sancionar'><img src='http://iessitges.xtec.cat/assistencia/imatges/san.svg'></a>
<a href='/assistencia/notes_personal.php?id=$row1[2]' target='blank' title='Notes'><img src='http://iessitges.xtec.cat/assistencia/imatges/nota.svg'></a>

</font></td>
</tr>";
}
$comptador_alumnes=$comptador_alumnes+1;
}
$comptador_cursos=$comptador_cursos+1;
}

echo "<font face='Verdana' size='1'>".$comptador_alumnes." alumnes en ".$comptador_cursos;
echo " cursos</font>";
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
<hr><p align="center"><font face="Verdana" size="1">(c) V.L.G.A. 2013</font></p></font></body></html>