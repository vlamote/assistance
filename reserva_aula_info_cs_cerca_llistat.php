<html><head><title>R.O.C.S.</title></head>
<table border="0" width="100%" id="table2"><tr>
<td width="25%"><font face="Verdana" size="1"><p align="left"><a href="reserva_aula_info_cs_formulari.php" title="Reserva un PC per a dos alumnes una hora">Reserva</a> | <a href="reserva_aula_info_cs_alum.php" title="Llista de les reserves fetes fins ara">Llista</a> | <a href="reserva_aula_info_cs.php" title="Ocupació de les aules a vista d'ocell">Ocupació</a> | <a href="reserva_aula_info_cs_cerca_formulari.php" title="Consulta les reserves fetes d'un alumne">Consulta</a> | <a href="reserva_crea_aula_info_cs.php" title="Esborra TOTES les reserves">Esborra</a> | <a href="reserva_aula_info_cs_baixa_formulari.php" title="Dona de baixa un PC">Baixa</a></font></p></td>
<td width="50%"><font face="Verdana" size="1" color="red"><p align="center"><b>Cursor a sobre per a detalls. Clic per a més accions</b></p></td>
<td width="25%"><font face="Verdana" size="1"><p align="right"><b>Reserva d'Ordinadors per al Crèdit de Síntesi</b></p></font></td>
</tr></table><hr>

<?php include "connectaBD.php";mysql_query("SET NAMES 'utf8'");include "PassaVars.php";include "Funcions_Temporals.php";

/*PER A NO TENIR PROBLEMES AMB CARACTERS ESTRANYS*/
header("Content-Type: text/html;charset=utf-8");

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

	if (($userid==7) OR (($userid <> 1) AND ($idprofe <> 0))){
	/***************************************************************************************************/

		/*VARIABLES INICIALS*/
		$dia = $_POST["dia"];
		$hora = $_POST["hora"];
		$idalumne1 = $_POST["idalumne1"];
		$idalumne2 = $_POST["idalumne2"];
		$idprofe = $userid;
		$datareserva=time();
		$ara=$datareserva;
		$any_ara=date("y",$ara);
		$mes_ara='6';
		$dia_ara=$dia_real;
		$hora_ara=date("h",strtotime($hora_real));
		$minut_ara=date("i",strtotime($hora_real));
		$data_ara=date("Y-m-d h:i:s",$ara);
		$flag=0;		

		/*ESBRINO NOM*/
		$sql1 = "SELECT * FROM mdl_user WHERE id=$idalumne1";
		$result1=mysql_query($sql1, $conexion);
		while($row1=mysql_fetch_row($result1)){	
			$nom_alumne1=$row1[11].", ".$row1[10];
		}

		echo "<p align='center'><font face='Verdana' size='2' color='black'><b>Reserves d'aules d'informàtica per a ".$nom_alumne1."</b></font></p>";

		//CERQUEM TOTS ELS REGISTRES ON RESERVAT=0 EL DIA I HORA TRIATS
		$sql2 = "SELECT * FROM mdl_zzz_attendance_cs WHERE (reservat='1' AND alum1='$idalumne1' or alum2='$idalumne1')";
		$result2=mysql_query($sql2, $conexion);
		while($row2=mysql_fetch_row($result2)){

			$i=$row2[0];
			$confirmada=$row2[8];
			if($confirmada=='0'){$confir="Reserva NO confirmada";}
			if($confirmada=='1'){$confir="Reserva   SI   confirmada";}

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
			if($row2[1]=="1"){$dia_real=$Marc_HorariCS_Dies[0];}
			if($row2[1]=="2"){$dia_real=$Marc_HorariCS_Dies[1];}
			if($row2[1]=="3"){$dia_real=$Marc_HorariCS_Dies[2];}
			if($row2[1]=="4"){$dia_real=$Marc_HorariCS_Dies[3];}

			if($row2[2]=="1"){$hora_real=$Marc_HorariCS_Hores[0];}
			if($row2[2]=="2"){$hora_real=$Marc_HorariCS_Hores[1];}
			if($row2[2]=="3"){$hora_real=$Marc_HorariCS_Hores[2];}
			$any_ara=date("Y",$ara);
			$mes_ara='06';
			$dia_ara=$dia_real;
			$hora_ara=date("h",strtotime($hora_real));
			$minut_ara=date("i",strtotime($hora_real));
			$data_ara=date("Y-m-d h:i:s",$ara);
			echo "<p align='left'><font face='Verdana' size='2' color='black'><b>".$confir. "</b> el <b>".$dia_real."/".$mes_ara."/".$any_ara."</b> a les <b>".$hora_real."</b> a l'ordinador <b>".$row2[4]."</b>, a l'aula <b>Info".$row2[3]."</b> (reserva feta el <b>".$row2[11]."</b>)</font></p>";

			if($confirmada=='0'){
				$enllas="reserva_confirmada_aula_info_cs.php?id=$i";
				echo "<a href='$enllas'><font face='Verdana' size='2' color='black'>Confirma la reserva</font></a>";
			}
		}
		include "desconnectaBD.php";
	/*******************CONTROL DE ACCES FINAL********************************************************/
	}
	else{	
		echo"<p align='center'><font face='Verdana' size='2' color='red'><b>ACCES DENEGAT!</b></font></p>";
	}
}
/******************************************************************************************************/
?>
<hr><p align="center"><font face="Verdana" size="1" color="black">(c) V.L.G.A. 2015</font></p></font></body></html>