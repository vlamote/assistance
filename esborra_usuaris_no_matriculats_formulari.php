<html><head><title>ES.U.N.MAT.</title>  

<LINK href="jquery/themes/blue/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="jquery/jquery-latest.js"></script>
<script type="text/javascript" src="jquery/jquery.tablesorter.js"></script>
<script type="text/javascript">
$(document).ready(function() {
$("#Incidencies").tablesorter({
sortList: [[2,1]]
});
});
</script></head><body bgcolor="#FFFFFF">

<table border="0" width="100%" id="table2"><tr>
<td width="30%"><font face="Verdana" size="1"><p align="left"><b>ES.U.N.MAT.</b></font></p></td>
<td width="40%"><font face="Verdana" size="1" color="red"><p align="center"><b>Llistat d'usuaris que no estan inscrits a cap curs i que no han entrat en mig any</b></font></p></td>
<td width="30%"><font face="Verdana" size="1"><p align="right"><b>ESborra Usuaris No MATriculats</b></p></font></td>
</tr></table><hr>

<?php include "connectaBD.php";include "PassaVars.php";

	$comptador_alumnes=0;

	/************CONTROL DE ACCES INICI********************/
	require_once ('../config.php');
	global $USER;
	$userid=$USER->id;
	if(!isloggedin()){
		header('Location: http://iessitges.xtec.cat/login/index.php?id=284'); 
	}
	else { 	
		$idprofe=0;
		$cohort=43;
		$sql2 = "SELECT * FROM mdl_cohort_members WHERE ((userid='$userid') AND (cohortid='$cohort'))";
		$result2=mysql_query($sql2, $conexion);
		while($row2=mysql_fetch_row($result2)){
			$idprofe=$row2[0];
	         }
		if ($userid == 7){
		/******************************************************/
			echo "<div align='center'>
			<table id='Incidencies' class='tablesorter' width='400px'>
			<thead><tr>
			<th width='100px' align='center'>Id</th>
			<th width='200px' align='center'>Alumne</th>
			<th width='100px' align='center'>Darrer Acces</th>
			</tr></thead></div>";
			$data_avui=time();
			$data_mig_any_des_de_avui=$data_avui-6*30*24*60*60;
			$sql="SELECT * FROM mdl_user WHERE (deleted=0) AND (department NOT LIKE 'Gestio') AND (lastaccess<'$data_mig_any_des_de_avui') AND (id NOT IN (SELECT userid FROM mdl_user_enrolments)) ORDER BY lastaccess DESC";
			$result=mysql_query($sql, $conexion);
			while($row=mysql_fetch_row($result)){
				$data_matricula=date("Y/m/d",$row[30]);
				echo"                                   
				<td align='left' width='100px'><font face='Verdana' size='1'>$row[0]</font></td>
				<td align='left' width='200px'><font face='Verdana' size='1'><a href='/user/profile.php?id=$row[0]' target='blank'>$row[11], $row[10]</a></font></td>
				<td align='center' width='100px'>$data_matricula<font face='Verdana' size='1'></font></td>
					</tr>";
			$comptador_alumnes=$comptador_alumnes+1;
			}			
			echo"<form method='POST' action='esborra_usuaris_no_matriculats_llistat.php'><input value='Confirma esborrat dels $comptador_alumnes alumnes' type='submit'></form>";
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
<hr><p align="center"><font face="Verdana" size="1">(c) V.L.G.A. 2015</font></p></font></body></html>