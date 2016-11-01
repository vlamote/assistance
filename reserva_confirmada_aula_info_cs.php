<html><head><title>R.O.C.S.</title></head>
<table border="0" width="100%" id="table2"><tr>
<td width="25%"><font face="Verdana" size="1"><p align="left"><a href="reserva_aula_info_cs_formulari.php" title="Reserva un PC per a dos alumnes una hora">Reserva</a> | <a href="reserva_aula_info_cs_alum.php" title="Llista de les reserves fetes fins ara">Llista</a> | <a href="reserva_aula_info_cs.php" title="Ocupació de les aules a vista d'ocell">Ocupació</a> | <a href="reserva_aula_info_cs_cerca_formulari.php" title="Consulta les reserves fetes d'un alumne">Consulta</a> | <a href="reserva_crea_aula_info_cs.php" title="Esborra TOTES les reserves">Esborra</a> | <a href="reserva_aula_info_cs_baixa_formulari.php" title="Dona de baixa un PC">Baixa</a></font></p></td>
<td width="50%"><font face="Verdana" size="1" color="red"><p align="center"><b>Cursor a sobre per a detalls. Clic per a més accions</b></p></td>
<td width="25%"><font face="Verdana" size="1"><p align="right"><b>Reserva d'Ordinadors per al Crèdit de Síntesi</b></p></font></td>
</tr></table><hr>

<?php include "connectaBD.php";include "PassaVars.php";

/*PER A NO TENIR PROBLEMES AMB CARACTERS ESTRANYS*/
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

	/*SI L'USUARI QUE CONFIRMA ES LAMOTE O MURCIEGO O QUEROL O VILLAR O GARCIA*/
	if (($userid==7) OR ($userid==2848) OR ($userid==2822) OR ($userid==2823) OR ($userid==3330) OR ($userid==3088)){
	/***************************************************************************************************/

		$id = $_GET["id"];
		$sql3="UPDATE mdl_zzz_attendance_cs SET confirmat='1' WHERE id='$id'";
		$result3=mysql_query($sql3, $conexion);
		if($result3==TRUE){
			echo "<p align='center'>Reserva ".$id." confirmada</p>";
			header('Location: http://iessitges.xtec.cat/assistencia/reserva_aula_info_cs_alum.php');
		}
		else{
			echo "<p align='center'>eserva ".$id." NO confirmada</p>";
		};
		include "desconnectaBD.php";

	/*******************CONTROL DE ACCES FINAL********************************************************/
	}
	else{
		echo"<p align='center'><font face='Verdana' size='2' color='red'><b>ACCES DENEGAT!</b></font></p>";
	}
}
/******************************************************************************************************/

?>

<hr><p align="center"><font face="Verdana" size="1">(c) V.L.G.A. 2015</font></p></font></body></html>