<html><head><title>ESB.US.</title></head>
	<table border="0" width="100%" id="table2"><tr>
		<td width="22%"><font face="Verdana" size="1"><p align="left"><b>ESB.US.</b></font></p></td>
		<td width="56%"><font face="Verdana" size="1" color="red"><p align="center"><b>ESBORRAT D'USUARI</b></p></td>
		<td width="22%"><font face="Verdana" size="1"><p align="right"><b>Esborra Usuasri</b></p></font></td>
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
	$cohort=45;
	/*****************************************************/
	/*COHORTS DE TUTORS: 35 36 37 38 39 40 41 42  83 84 85*/
	/*COHORT DE COORDINADORS: 44*/
	/*COHORT DE PROFESSORS: 43*/
	/*COHORT DE DIRECCIO: 45*/
	/*****************************************************/
	$sql2 = "SELECT * FROM mdl_cohort_members WHERE ((userid='$userid') AND (cohortid='$cohort'))";
	$result2=mysql_query($sql2, $conexion);
	while($row2=mysql_fetch_row($result2)){
		$idprofe=$row2[0];
            }
	if (($userid==7) OR (($userid <> 1) AND ($userid <> 7) AND ($idprofe <> 0))){
/***************************************************************************************************/

		$id_usuari= $_GET["id_usuari"];
		$sql4 = "UPDATE mdl_user SET deleted='1' WHERE (id='$id_usuari')";
		$result4=mysql_query($sql4, $conexion);    
		while($row4=mysql_fetch_row($result4)){
		}
    		$sql2 = "SELECT * FROM mdl_user WHERE id=$id_usuari";
    		$result2=mysql_query($sql2, $conexion);
    		while($row2=mysql_fetch_row($result2)){
    			$alumne=$row2[11].", ".$row2[10];
    		 }
		include "desconnectaBD.php";
		echo "Usuari ".$id_usuari." (".$alumne.") esborrat";
/*******************CONTROL DE ACCES FINAL********************************************************/
}
else{
echo"<p align='center'><font face='Verdana' size='2' color='red'><b>ACCES DENEGAT!</b></font></p>";
}
}
/******************************************************************************************************/

?>
	<hr><p align="center"><font face="Verdana" size="1">(c) V.L.G.A. 2014</font></p></font></body>
</html>