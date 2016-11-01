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

	if ($userid <> 1){
	/***************************************************************************************************/

		/*VARIABLES INICIALS*/
		$dia = $_POST["dia"];
		$id = $_POST["id"];
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
		$diet=1;
		$color_dia="black";

		do{

			$horeta=1;

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
	
			$any_ara=date("Y",$ara);
			$mes_ara='06';
			$dia_ara=$dia_real;
			$hora_ara=date("h",strtotime($hora_real));
			$minut_ara=date("i",strtotime($hora_real));
			$data_ara=date("Y-m-d h:i:s",$ara);

			echo "<br><font size='2' color='".$color_dia."'><b>".$dia_real."-".$mes_ara."-".$any_ara."</b><br>";

			do{

				$auleta=1;	

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
	
				$any_ara=date("Y",$ara);
				$mes_ara='06';
				$dia_ara=$dia_real;
				$hora_ara=date("h",strtotime($hora_real));
				$minut_ara=date("i",strtotime($hora_real));
				$data_ara=date("Y-m-d h:i:s",$ara);
	
				echo "<br><b><font size='2'>".$hora_real."</b></font><br>";

				do{

					if($auleta==1){
						$color_aula="green";
					};
					if($auleta==2){
						$color_aula="orange";
					};

/*AFEGIT PER VICTOR A DATA 260516 PER A AFEGIR LES ALTRES 2 AULES PORTATILS*/

					if($auleta==3){
						$color_aula="red";
					};
					if($auleta==4){
						$color_aula="blue";
					};

					echo "<br><font size='2' color='".$color_aula."'><b>INFO".$auleta.": </font></b>";

					//CERQUEM TOTS ELS REGISTRES DIA A DIA
					$sql2 = "SELECT * FROM mdl_zzz_attendance_cs WHERE dia='$diet' AND hora='$horeta' AND aula='$auleta'";
					$result2=mysql_query($sql2, $conexion);
					while($row2=mysql_fetch_row($result2)){

						$id=$row2[0];
						$pcet=$row2[4];
						$reservadet=$row2[7];
						$confirmadet=$row2[8];
						$idalumne1=$row2[5];
						$idalumne2=$row2[6];
						$idprofe=$row2[10];
						$iddata=$row2[11];

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

						if($confirmadet==0){
							if($reservadet==0){
								$color_reserva="green";
								echo "<font size='2' color='".$color_reserva."'>PC".$pcet." </a></font>";
							}
							else{
								$color_reserva="red";
								echo "<font size='2' color='".$color_reserva."'>"."*<a href='reserva_confirmada_aula_info_cs.php?id=$id' title='No confirmats: ".$nom_alumne1." i ".$nom_alumne2." (".$nom_profe." ".$iddata.")'>PC".$pcet."</a> </font>";
							};
						}
						else{
							if($reservadet==0){
								$color_reserva="green";
								echo "<font size='2' color='".$color_reserva."'>PC".$pcet." </a></font>";
							}
							else{
								$color_reserva="red";
								echo "<font size='2' color='".$color_reserva."'>"."<a href='' title='Confirmats: ".$nom_alumne1." i ".$nom_alumne2." (".$nom_profe." ".$iddata.")'>PC".$pcet."</a> </font>";
							};
						};
					}
					$auleta=$auleta+1;
					echo "<br>";
/*CANVIAT PER VICTOR A DATA 260516 PER A AFEGIR LES ALTRES 2 AULES PORTATILS*/
/*				}while ($auleta<=2);*/
				}while ($auleta<=$AULES_DISPONIBLES);
				$horeta=$horeta+1;
			}while ($horeta<=$HORES_CS);
			$diet=$diet+1;
			echo "<hr>";
		}while ($diet<=$DIES_CS);

		include "desconnectaBD.php";

	/*******************CONTROL DE ACCES FINAL********************************************************/
	}
	else{
	
		echo"<p align='center'><font face='Verdana' size='2' color='red'><b>ACCES DENEGAT!</b></font></p>";
	}
}
/******************************************************************************************************/
?>
<p align="center"><font face="Verdana" size="1" color="black">(c) V.L.G.A. 2015</font></p></font></body></html>