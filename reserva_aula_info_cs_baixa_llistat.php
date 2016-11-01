<html><head><title>R.O.C.S.</title></head>
	<table border="0" width="100%" id="table2"><tr>
		<td width="25%"><font face="Verdana" size="1"><p align="left"><a href="reserva_aula_info_cs_formulari.php" title="Reserva un PC per a dos alumnes una hora">Reserva</a> | <a href="reserva_aula_info_cs_alum.php" title="Llista de les reserves fetes fins ara">Llista</a> | <a href="reserva_aula_info_cs.php" title="Ocupació de les aules a vista d'ocell">Ocupació</a> | <a href="reserva_aula_info_cs_cerca_formulari.php" title="Consulta les reserves fetes d'un alumne">Consulta</a> | <a href="reserva_crea_aula_info_cs.php" title="Esborra TOTES les reserves">Esborra</a> | <a href="reserva_aula_info_cs_baixa_formulari.php" title="Dona de baixa un PC">Baixa</a></font></p></td>
		<td width="50%"><font face="Verdana" size="1" color="red"><p align="center"><b>Cursor a sobre per a detalls. Clic per a més accions</b></p></td>
		<td width="25%"><font face="Verdana" size="1"><p align="right"><b>Reserva d'Ordinadors per al Crèdit de Síntesi</b></p></font></td>
	</tr></table><hr>
<?php include "connectaBD.php";mysql_query("SET NAMES 'utf8'");include "PassaVars.php";include "Funcions_Temporals.php";
	header("Content-Type: text/html;charset=utf-8");
	require_once ('../config.php');
	global $USER;
	$userid=$USER->id;
	if(!isloggedin()){
		header('Location: http://iessitges.xtec.cat/login/index.php?id=284'); 
	}
	else{
		$idprofe=0;
		$sql = "SELECT * FROM mdl_cohort_members WHERE ((userid='$userid') AND ((cohortid=43) OR (cohortid=44) OR (cohortid=45) OR (cohortid=59)))";
		$result=mysql_query($sql, $conexion);
		while($row=mysql_fetch_row($result)){
			$idprofe=$row[0];
		}
		if (($userid=='7') OR ($userid=='2848')){
			$aula = $_POST["aula"];
			$pc = $_POST["pc"];
			$idprofe = $userid;
			$datareserva=time();
			$ara=$datareserva;
			$any_ara=date("y",$ara);
			$mes_ara='6';
			$dia_ara=$dia_real;
			$hora_ara=date("h",strtotime($hora_real));
			$minut_ara=date("i",strtotime($hora_real));
			$data_ara=date("Y-m-d h:i:s",$ara);
			$nom_profe="DONAT DE BAIXA";
			$sql2 = "SELECT * FROM mdl_zzz_attendance_cs WHERE (aula='$aula' AND pc='$pc')";
			$result2=mysql_query($sql2, $conexion);
			while($row2=mysql_fetch_row($result2)){
				$i=$row2[0];
				$dieta=$row2[1];
				$horeta=$row2[2];
				$sql3="UPDATE mdl_zzz_attendance_cs SET reservat='1', confirmat='1', alum1='7', alum2='7', quireserva='$idprofe', quanreserva='$data_ara' WHERE id='$i'";
				$result3=mysql_query($sql3, $conexion);
				echo "<p align='left'><font face='Verdana' size='2' color='black'>Dia: ".$dieta." Hora: ".$horeta." -> Ordinador ".$pc." de l'Aula".$aula." donat de baixa</font></p>";
			}
		}
		else{	
			echo"<p align='center'><font face='Verdana' size='2' color='red'><b>ACCES DENEGAT!</b></font></p>";
		}
	}
	include "desconnectaBD.php";
?>
<hr><p align="center"><font face="Verdana" size="1" color="black">(c) V.L.G.A. 2016</font></p></font></body></html>