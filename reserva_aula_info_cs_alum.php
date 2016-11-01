<html>
	<head>
	<title>R.O.C.S.</title>
	<LINK href="jquery/themes/blue/style.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="jquery/jquery-latest.js"></script>
	<script type="text/javascript" src="jquery/jquery.tablesorter.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#reservescs").tablesorter({
			sortList: [[0,0],[1,0]]
			});
		});
	</script>
	</head>
	<table border="0" width="100%" id="table2"><tr>
		<td width="25%"><font face="Verdana" size="1"><p align="left"><a href="reserva_aula_info_cs_formulari.php" title="Reserva un PC per a dos alumnes una hora">Reserva</a> | <a href="reserva_aula_info_cs_alum.php" title="Llista de les reserves fetes fins ara">Llista</a> | <a href="reserva_aula_info_cs.php" title="Ocupació de les aules a vista d'ocell">Ocupació</a> | <a href="reserva_aula_info_cs_cerca_formulari.php" title="Consulta les reserves fetes d'un alumne">Consulta</a> | <a href="reserva_crea_aula_info_cs.php" title="Esborra TOTES les reserves">Esborra</a> | <a href="reserva_aula_info_cs_baixa_formulari.php" title="Dona de baixa un PC">Baixa</a></font></p></td>
		<td width="50%"><font face="Verdana" size="1" color="red"><p align="center"><b>Cursor a sobre per a detalls. Clic per a més accions</b></p></td>
		<td width="25%"><font face="Verdana" size="1"><p align="right"><b>Reserva d'Ordinadors per al Crèdit de Síntesi</b></p></font></td>
	</tr></table><hr>

<?php include "connectaBD.php";include "PassaVars.php";include "Funcions_Temporals.php";

/*******************CONTROL DE ACCES INICI********************************************************/
require_once ('../config.php');
global $USER;
$userid=$USER->id;
if(!isloggedin()){
	header('Location: http://iessitges.xtec.cat/login/index.php?id=284'); 
}
else {

	$idprofe=0;

	/*****************************************************/
	/*COHORTS DE TUTORS: 35 36 37 38 39 40 41 42  83 84 85*/
	/*COHORT DE COORDINADORS: 44*/
	/*COHORT DE PROFESSORS: 43*/
	/*COHORT DE DIRECCIO: 45*/
	/*****************************************************/

	$sql = "SELECT * FROM mdl_cohort_members WHERE ((userid='$userid') AND ((cohortid=43) OR (cohortid=44) OR (cohortid=45) OR (cohortid=59)))";
	$result=mysql_query($sql, $conexion);
	while($row=mysql_fetch_row($result)){
		$idprofe=$row[0];
	}

	if ($userid <> 1){

		/***************************************************************************************************/

		$comptador_alumnes=0;	

		echo "
		<div align='center'>
			<table id='reservescs' class='tablesorter' width='800px'>
			<thead><tr>
				<th width='020px' align='center'>Dia</th>
				<th width='020px' align='center'>Hora</th>
				<th width='020px' align='center'>Aula</th>
				<th width='020px' align='center'>PC</th>
				<th width='250px' align='center'>Alumne 1</th>
				<th width='250px' align='center'>Alumne 2</th>
				<th width='200px' align='center'>Professor</th>
				<th width='020px' align='center'>#</font></th>
			</tr></thead></div>";

		//CERQUEM TOTS ELS REGISTRES DIA A DIA
		$sql2 = "SELECT * FROM mdl_zzz_attendance_cs WHERE reservat='1' ORDER BY dia";
		$result2=mysql_query($sql2, $conexion);
		while($row2=mysql_fetch_row($result2)){

			$id=$row2[0];
			$diet=$row2[1];
			$horeta=$row2[2];
			$auleta=$row2[3];
			$pcet=$row2[4];
			$idalumne1=$row2[5];
			$idalumne2=$row2[6];
			$reservadet=$row2[7];
			$confirmadet=$row2[8];
			$observacionetes=$row2[9];
			$idprofe=$row2[10];
			$iddata=$row2[11];
			$LED="/assistencia/imatges/LED_incidencia_B.gif";

			/*CREEM MATRIUS AMB EL MARC HORARI CS*/
			/***************************/
			/*MarcHorariCS($i,$j)               */
			/*FUNCIO QUE RETORNA      */
			/*SEGONS EL PARAMETRE j:*/
			/*0: DESCRIPCIO                         */
			/*1: TIMBRE1                                */
			/*2: INICI CLASSE                       */
			/*3: FINAL CLASSE                    */
			/* DE L'HORA PASSADA EN  */
			/*EL PARAMETRE i (0 a 3)  */
			/*************************/
			$Marc_HorariCS_Dies=         array(MarcHorariCS(0,1),MarcHorariCS(0,2),MarcHorariCS(0,3),MarcHorariCS(0,4));
			$Marc_HorariCS_Hores=      array(MarcHorariCS(0,5),MarcHorariCS(1,5),MarcHorariCS(2,5));

			if($diet=="1"){$dia_real=$Marc_HorariCS_Dies[0];}
			if($diet=="2"){$dia_real=$Marc_HorariCS_Dies[1];}
			if($diet=="3"){$dia_real=$Marc_HorariCS_Dies[2];}
			if($diet=="4"){$dia_real=$Marc_HorariCS_Dies[3];}

			if($horeta=="1"){$hora_real=$Marc_HorariCS_Hores[0];}
			if($horeta=="2"){$hora_real=$Marc_HorariCS_Hores[1];}
			if($horeta=="3"){$hora_real=$Marc_HorariCS_Hores[2];}		

			/*ESBRINO NOM ALUMNE1*/
			$sql1 = "SELECT * FROM mdl_user WHERE id=$idalumne1";
			$result1=mysql_query($sql1, $conexion);
			while($row1=mysql_fetch_row($result1)){				
				$nom_alumne1=$row1[11].", ".$row1[10];			
			}					
			/*ESBRINO NOM ALUMNE2*/
			$sql11 = "SELECT * FROM mdl_user WHERE id=$idalumne2";
			$result11=mysql_query($sql11, $conexion);
			while($row11=mysql_fetch_row($result11)){
				$nom_alumne2=$row11[11].", ".$row11[10];
			}
			/*ESBRINO NOM PROFE*/
			$sql1 = "SELECT * FROM mdl_user WHERE id=$idprofe";
			$result1=mysql_query($sql1, $conexion);
			while($row1=mysql_fetch_row($result1)){
				$nom_profe=$row1[11].", ".$row1[10];
			}

			/*ENCEN EL LED DES COLOR QUE TOCA*/
			if($confirmadet=='1'){
				$enllas="";
				$LED="/assistencia/imatges/LED_incidencia_U.gif";
				$missatget="Reserva_confirmada";
				$valor_led="1";
			}
			else{
				$enllas="reserva_confirmada_aula_info_cs.php?id=$id";
				$LED="/assistencia/imatges/LED_incidencia_S.gif";
				$missatget="Pica_per_confirmar_la_reserva";
				$valor_led="0";
			}

			echo"
			<td align='center' width='020px'>$dia_real</td>
			<td align='center' width='020px'>$hora_real</td>
			<td align='center' width='020px'>$auleta</td>
			<td align='center' width='020px'>$pcet</td>
			<td align='center' width='250px'>$nom_alumne1</td>
			<td align='center' width='250px'>$nom_alumne2</td>
			<td align='center' width='200px'>$nom_profe</td>
			<td align='center' width='020px'><font face='Verdana' size='0' color='white'>$valor_led</font><a href='$enllas' title=$missatget><img src='$LED'></a></font></td></tr>";
			$comptador_alumnes=$comptador_alumnes+1;
		}

		echo "<font face='Verdana' size='1'><b>".$comptador_alumnes." reserves de les 864 possibles</b></tbody></table>";
		include "desconnectaBD.php";

		/*******************CONTROL DE ACCES FINAL********************************************************/
	}
	else{
	
		echo"<p align='center'><font face='Verdana' size='2' color='red'><b>ACCES DENEGAT!</b></font></p>";
	}
}
/******************************************************************************************************/
?>
<hr><p align="center"><font face="Verdana" size="1">(c) V.L.G.A. 2013</font></p></font></body></html>