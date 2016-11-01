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
			$data_avui=time();
			$data_mig_any_des_de_avui=$data_avui-6*30*24*60*60;	
			$sql="UPDATE mdl_user SET deleted=1 WHERE (deleted=0) AND (department NOT LIKE 'Gestio') AND (lastaccess<'$data_mig_any_des_de_avui') AND (id NOT IN (SELECT userid FROM mdl_user_enrolments)) ORDER BY lastaccess DESC";
			$result=mysql_query($sql, $conexion);
			while($row=mysql_fetch_row($result)){
				$comptador_alumnes=$comptador_alumnes+1;
			}			
			ECHO "<p align='center'><font face='Verdana' size='2' color='black'><b>Esborrats $comptador_alumnes alumnes</b></font></p>";
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