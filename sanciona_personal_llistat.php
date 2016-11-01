<html><head><title>SAN.AL.O.</title> <script language="javascript" type="text/javascript" src="datetimepicker.js"></script></head>
<table border="0" width="100%" id="table2"><tr>
<td width="22%"><font face="Verdana" size="1"><p align="left"><b><a href="/assistencia/sanciona_personal_formulari.php">Sanciona'n més</a></b></font></p></td>
<td width="56%"><font face="Verdana" size="1" color="red"><p align="center"><b>Comunica-ho als <a href="http://iessitges.xtec.cat/user/index.php?contextid=3017&roleid=0&id=24&perpage=5000&search&ssort=lastname>professors</a></b></p></td>
<td width="22%"><font face="Verdana" size="1"><p align="right"><b>SANciona ALumnes Online</b></p></font></td>
</tr></table><hr>

<?php include "connectaBD.php";include "PassaVars.php";

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
		
	$sql2 = "SELECT * FROM mdl_cohort_members WHERE ((userid='$userid') AND ((cohortid=44) OR (cohortid=45)))";
	$result2=mysql_query($sql2, $conexion);
	while($row2=mysql_fetch_row($result2)){
		
		$idprofe=$row2[0];
	}
		
	if ((($userid <> 1) AND ($idprofe <> 0)) OR ($userid==7)){

/**************************************************************************************************/

   /***************************/
   /* DEFINICIO DE VARIABLES */
   /***************************/

		$idalumne= $_GET["idalumne"];
		$data1= $_POST["data1"];
		$observacions= $_POST["observacions"];

		$dataentrada1 = strtotime($data1)+8*3600;
		$dataentrada2 = strtotime($data1)+22*3600;
		$dataentrada11=date("d/m/y h:i a", $dataentrada1);
		$dataentrada21=date("d/m/y h:i a", $dataentrada2);
		$ara=time();
		$dataara=date("d/m/y h:i a",$ara);
		$acronim='S';

		/*ESBRINO NOM ALUMNE*/
		$sql2 = "SELECT * FROM mdl_user WHERE id=$idalumne";
		$result2=mysql_query($sql2, $conexion);
		while($row2=mysql_fetch_row($result2)){	
			$alumne=$row2[11].", ".$row2[10];	
			echo "<p align='center'><b><font face='Verdana' size='2'>Alumne sancionat:</b> $alumne ($idalumne)<b><br><br>Data de sanció:</b> $data1<b><br><br>Motiu:</b> $observacions</font></p>";
		}

		/*BUSCO SESSIONS AL DIA DONAT D'AQUELLES ASSISTENCIES. POT HAVER MES D'UNA*/
		$sql5 = "SELECT * FROM mdl_attendance_sessions WHERE ((sessdate>='$dataentrada1') AND (sessdate<='$dataentrada2')) ORDER BY sessdate";
		$result5=mysql_query($sql5, $conexion);
		while($row5=mysql_fetch_row($result5)){/*WHILE1*/
				
			$ID_sessio=$row5[0];
			$hora_sessio=$row5[3];
			$hora_sessio1=date("d/m/y h:i a", $hora_sessio);
			$grup=$row5[2];
			$assistencia=$row5[1];

			/*BUSCO QUINES SESSIONS TENEN GRUPS ON ESTA L'ALUMNE*/
			$sql115 = "SELECT * FROM mdl_groups_members WHERE ((userid='$idalumne') AND (groupid='$grup'))";
			$result115=mysql_query($sql115, $conexion);
			if ($row115=mysql_fetch_row($result115)){/*IF2*/
				
				/*BUSCO ASSISTENCIA DE CADA SESSIO. POT HAVER MES D'UNA*/
				$sql4 = "SELECT * FROM mdl_attforblock WHERE (id='$assistencia')";
				$result4=mysql_query($sql4, $conexion);
				while($row4=mysql_fetch_row($result4)){/*WHILE3*/
				
					$ID_curs=$row4[1];

					/*TRANSFORMO CURS EN CONTEXT*/
					$sql2 = "SELECT * FROM mdl_context WHERE (instanceid='$ID_curs')";
					$result2=mysql_query($sql2, $conexion);
					while($row2=mysql_fetch_row($result2)){
		
						$contexte=$row2[0];
					}

					/*ESBRINO NOM DEL CURS*/
					$sql3 = "SELECT * FROM mdl_course WHERE (id='$ID_curs')";
					$result3=mysql_query($sql3, $conexion);
					while($row3=mysql_fetch_row($result3)){
		
						$curs=$row3[4];	
					}

					/*MIRO SI HI HA ALGUNA ASSIGNACIO DE ROLS D'AQUELL ALUMNE EN AQUELL CONTEXTE (SI L'ALUMNE PERTANY A AQUELL CURS)*/
					$sql1 = "SELECT * FROM mdl_role_assignments WHERE (userid='$idalumne') AND (contextid='$contexte')";
					$result1=mysql_query($sql1, $conexion);
					if($row1=mysql_fetch_row($result1)){/*IF4*/
					
						echo"<p align='center'><font face='Verdana' size='2'>$hora_sessio1 ($ID_sessio). Curs: $curs ($ID_curs). ";
						
						/*SI HI HA CREADA ALGUNA INCIDENCIA PER A AQUELLA ASSISTENCIA PER A AQUELL ALUMNE*/
						$sql7 = "SELECT * FROM mdl_attendance_log WHERE ((sessionid='$ID_sessio') AND (studentid='$idalumne'))";
						$result7=mysql_query($sql7, $conexion);
						if($row7=mysql_fetch_row($result7)){/*IF5*/
						
							/*BUSCO L'ESTAT DE L'ACRONIM*/	
							$sql8 = "SELECT * FROM mdl_attendance_statuses WHERE (attendanceid='$assistencia' AND acronym='$acronim')";
							$result8=mysql_query($sql8, $conexion);
							while($row8=mysql_fetch_row($result8)){
											
									$estat=$row8[0];										
						
									/*MODIFICO L'ESTAT DE LA INCIDENCIA*/
									$sql9 = "UPDATE mdl_attendance_log SET statusid='$estat', remarks='$observacions' WHERE (studentid='$idalumne' AND sessionid='$ID_sessio')";
									$result9=mysql_query($sql9, $conexion); 
									echo "Trobada incidencia i modificada.</font></p>";
							}
						}/*FI IF5*/

						/*SI NO HI HA CREADA CAP INCIDENCIA PER A AQUELLA ASSISTENCIA PER A AQUELL ALUMNE*/
						else{/*ELSE6*/
						
							/*BUSCO IDS ESTATS D'AQUELLA SESSIO*/
							$estat_P=0;
							$estat_R=0;
							$estat_J=0;
							$estat_F=0;
							$estat_E=0;
							$estat_S=0;
						
							$sql31 = "SELECT * FROM mdl_attendance_statuses WHERE (attendanceid='$assistencia' AND acronym='P')";
							$result31=mysql_query($sql31, $conexion);
							while($row31=mysql_fetch_row($result31)){
								$estat_P=$row31[0];
								if($acronim=='P'){
									$estat=$estat_P;
								}
							}		
						
							$sql32 = "SELECT * FROM mdl_attendance_statuses WHERE (attendanceid='$assistencia' AND acronym='R')";
							$result32=mysql_query($sql32, $conexion);
						    	while($row32=mysql_fetch_row($result32)){
								$estat_R=$row32[0];
								if($acronim=='R'){
									$estat=$estat_R;
								}
							}
						
							$sql33= "SELECT * FROM mdl_attendance_statuses WHERE (attendanceid='$assistencia' AND acronym='J')";
							$result33=mysql_query($sql33, $conexion);
							while($row33=mysql_fetch_row($result33)){
								$estat_J=$row33[0];
								if($acronim=='J'){
									$estat=$estat_J;
								}
							}
						
							$sql34 = "SELECT * FROM mdl_attendance_statuses WHERE (attendanceid='$assistencia' AND acronym='F')";
							$result34=mysql_query($sql34, $conexion);
							while($row34=mysql_fetch_row($result34)){
								$estat_F=$row34[0];
								if($acronim=='F'){
									$estat=$estat_F;
								}	
							}
						
							$sql35 = "SELECT * FROM mdl_attendance_statuses WHERE (attendanceid='$assistencia' AND acronym='E')";
							$result35=mysql_query($sql35, $conexion);
							while($row35=mysql_fetch_row($result35)){
								$estat_E=$row35[0];
								if($acronim=='E'){
									$estat=$estat_E;
								}
							}
						
							$sql36 = "SELECT * FROM mdl_attendance_statuses WHERE (attendanceid='$assistencia' AND acronym='S')";
							$result36=mysql_query($sql36, $conexion);
							while($row36=mysql_fetch_row($result36)){
								$estat_S=$row36[0];
								if($acronim=='S'){
									$estat=$estat_S;
								}
							}		
							
							/*CREO UNA INCIDENCIA*/
							$estats=$estat_P.",".$estat_R.",".$estat_J.",".$estat_F.",".$estat_E.",".$estat_S;

							$sql1114 = "INSERT INTO mdl_attendance_log  (sessionid, studentid, statusid, statusset, timetaken, takenby, remarks) VALUES ('$ID_sessio', '$idalumne', '$estat', '$estats', '$ara', '$userid', '$observacions')";
							$result1114=mysql_query($sql1114, $conexion);	

							$sql1115 = "UPDATE mdl_attendance_sessions SET lasttaken='$ara',lasttakenby='$userid' WHERE (id='$ID_sessio')";
							$result1115=mysql_query($sql1115, $conexion);

							echo "No trobada incidencia. Creació d'una nova.</font></p>";

						}/*FI ELSE6*/
					}/*FI IF4*/
				}/*FI WHILE3*/
			}/*FI IF2*/
		}/*FI WHILE1*/

		include "desconnectaBD.php";

/*******************CONTROL D'ACCES FINAL********************************************************/

	}
	else{
			echo"<p align='center'><font face='Verdana' size='2' color='red'><b>ACCES DENEGAT!</b></font></p>";
	}
}

/****************************************************************************************************/

?>

<hr><p align="center"><font face="Verdana" size="1">(c) V.L.G.A. 2014</font></p></body></html>