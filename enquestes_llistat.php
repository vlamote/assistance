<html>
	<head><title>B.ES.EN.</title>
		<LINK href="jquery/themes/blue/style.css" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="jquery/jquery-latest.js"></script>
		<script type="text/javascript" src="jquery/jquery.tablesorter.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$("#Optatives").tablesorter({
					sortList: [[0,0],[1,0]]
				});
			});
		</script>
	</head>
	<body bgcolor="#FFFFFF">
		<table border="0" width="100%" id="table2"><tr>
			<td width="10%"><p align="left"><font face="Verdana" size="1"><a href="/assistencia/enquestes_formulari.php">Nova consulta</a></td>
			<td width="65%"><p align="center"><font face="Verdana" size="1" color="black" style="BACKGROUND-COLOR: white">Contacta amb: <a href="http://iessitges.xtec.cat/user/index.php?contextid=3017&roleid=0&id=24&perpage=20&accesssince=0&search=&group=6" title="Coordinadors" target="blank">Coordinacio</a> | <a href="http://iessitges.xtec.cat/user/index.php?contextid=3017&roleid=0&id=24&perpage=20&accesssince=0&search=&group=18" title="Direccio" target="blank">Direccio</a><font></P></td>
			<td width="30%"><p align="right"><font face="Verdana" size="1"><b>Bolcat EStadistiques ENquestes</b></font></p></td></tr>
		</table><hr>
		<?php include "connectaBD.php";include "PassaVars.php";include "Funcions_Matrius.php";
		/***************************/
		/* DEFINICIO DE VARIABLES */
		/**************************/
		$alumne="---";
		$profe="---";
		$sessio="---";
		$identificador=0;
		$enllas="mod/attforblock/view.php";
		$LED="imatges/LED_incidencies_OFF.gif";
		$sessio="---";
		$assistencia="---";
		$curs="---";
		$vista="1";
		$nomcurs="---";
		$nomgrup="---";
		$cursoficial="N/A";
		$grupoficial="N/A";
		$tipus = $_GET["tipus"];
		$data1= $_GET["data1"];
		$data2 = $_GET["data2"];
		$vista = $_GET["vista"];
		$triacurs = $_GET["triacurs"];
		$triagrup = $_GET["triagrup"];
		$dataentrada1= strtotime($data1);
		$dataentrada2= strtotime($data2);
		$abans=time();

		/*****************************************************/
		/*MOSTRO O NO NOM USUARI ENQUESTES ANONIMES*/
		/****************************************************/
		$nom_alumne="Anonim";
		$mostra_usuari_enquestes_anonimes=FALSE;

		/*******************CONTROL DE ACCES INICI********************************************************/
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
			if (($userid==7) OR (($userid <> 1) AND ($userid <> 7) AND ($idprofe <> 0))){ 
			/***************************************************************************************************/
				/***************************/
				/*ESBRINO NOM ENQUESTA*/
				/**************************/
				$sql022 = "SELECT * FROM mdl_feedback WHERE (id='$tipus') ORDER BY timemodified desc";
				$result022=mysql_query($sql022, $conexion);
				while($row022=mysql_fetch_row($result022)){
					$nom_enquesta=$row022[2];
				}
				/***************************/
				/*ESBRINO NUMERO ENQUESTA*/
				/**************************/
				$sql0222 = "SELECT * FROM mdl_log WHERE (info='$tipus') AND (module='feedback') ORDER BY time desc";
				$result0222=mysql_query($sql0222, $conexion);
				while($row0222=mysql_fetch_row($result0222)){
					$numero_enquesta=$row0222[6];
				}
				/*****************************/
				/*ENCAPSALAMENT DEL TITOL*/
				/*****************************/
				echo"<p align='center'><font face='Verdana' size='1'><b>";
				echo "<a target='_blank' href='/mod/feedback/view.php?id=".$numero_enquesta."'>".$nom_enquesta." (".$tipus.")</a>";
				echo"</b><br><br>";
				echo"<font color='red'>Pica als titols per a ordenar segons aquell criteri. Sobre al grup per a informacio de data.<br><br>LES ESTADISTIQUES ESTAN AL FINAL!";
				echo"</font></p>";
				/*********************************/
				/* ENCAPSALAMENT DE LA TAULA */
				/*********************************/
				echo "
				<div align='center'>
			        	<table id='Optatives' width='550px' class='tablesorter'>
				        	<thead>
					        	<tr>
								<th width='010px' align='center'>Curs</th>
								<th width='190px' align='center'>Usuari</th>";
								$sqly="SELECT * FROM mdl_feedback_item WHERE feedback='$tipus' AND name<>'' ORDER BY id ASC";
								$resulty=mysql_query($sqly, $conexion);
								$j=0;
								while($rowy=mysql_fetch_row($resulty)){
									$item_id=$rowy[0];
									$item_nom=$rowy[3];
									$pregunta[$j]=$item_nom;
									echo "<th align='center' bgcolor='$color' width='340px'>$item_nom ($item_id)</th>";
									$j=$j+1;
								}
							echo "</tr>";
						echo "</thead>";
						$preguntes=$j;
						$resposteta=0;
						$pregunteta=0;
						/************************************************/
						/* LLEGIR LA TAULA MDL_FEEDBACK_COMPLETED*/
						/************************************************/
						$sql01 = "SELECT * FROM mdl_feedback_completed WHERE (feedback='$tipus') ORDER BY id ASC";
						$result01=mysql_query($sql01, $conexion);
						while($row01=mysql_fetch_row($result01)){
							$id_enquesta=$row01[1];
							$id_usuari=$row01[2];
							$data_registre=$row01[3];
							$aleatoria=$row01[4];
							$anonima=$row01[5];
							$moment=date("Y-m-d-H:i", $data_registre);
							/************************************************/
							/*INTERPRETAR CAMP USERID AMB MDL_USER*/
							/************************************************/
							$sql03 = "SELECT * FROM mdl_user WHERE (id='$id_usuari') ORDER BY id asc";
							$result03=mysql_query($sql03, $conexion);
							while($row03=mysql_fetch_row($result03)){

								/*****************************************************/
								/*MOSTRO O NO NOM USUARI ENQUESTES ANONIMES*/
								/****************************************************/
								if ($anonima<>'1' OR $mostra_usuari_enquestes_anonimes==TRUE){
									$nom_alumne=$row03[11].", ".$row03[10];
								}
							}
							/*DE QUINES COHORTS ES MEMBRE*/
							$sql1="SELECT * FROM mdl_cohort_members WHERE userid = '$id_usuari'";
							$result1=mysql_query($sql1, $conexion);
							while($row1=mysql_fetch_row($result1)){
								$id_cohort=$row1[1];
								/*ESBRINA NOM COHORT*/
								$sql="SELECT * FROM mdl_cohort WHERE id='$id_cohort' and name NOT LIKE '%GF%'";
								$result=mysql_query($sql, $conexion);
								while($row=mysql_fetch_row($result)){

									/*****************************************************/
									/*MOSTRO O NO NOM USUARI ENQUESTES ANONIMES*/
									/****************************************************/
									if ($anonima<>'1' OR $mostra_usuari_enquestes_anonimes==TRUE){
										$grup=str_replace("ALUM","",$row[3]);
									}
								}
							}
							echo "<tr>
								<td align='center' bgcolor='$color' width='010px'><font face='Verdana' size='1'><a href='' title=$moment>$grup</a></td>
								<td align='left'       bgcolor='$color' width='190px'><font face='Verdana' size='1'>$nom_alumne</td>";
								/**********************/
								/*ESBRINA RESPOSTES*/
								/**********************/
								/**************************************************************************/
								/*AMB EL FEEDBACK_ID I USER_ID A MDL_FEEDBACK_COMPLETED OBTINC ID*/
								/*************************************************************************/
								$sqlxx="SELECT * FROM mdl_feedback_completed WHERE (feedback='$tipus') AND (userid='$id_usuari')";
								$resultxx=mysql_query($sqlxx, $conexion);
								while($rowxx=mysql_fetch_row($resultxx)){
									$id_feedback_completed=$rowxx[0];
								}
								$pregunteta=0;
								/******************************************************************/
								/*AMB ID ANTERIOR A MDL_FEEDBACK_VALUE OBTINC ITEM I VALUE*/
								/*****************************************************************/
								$sqlxxx="SELECT * FROM mdl_feedback_value WHERE completed='$id_feedback_completed'";
								$resultxxx=mysql_query($sqlxxx, $conexion);
								while($rowxxx=mysql_fetch_row($resultxxx)){
									$item_value=$rowxxx[2];
									$value_value=$rowxxx[5];							
									/*******************************************************/
									/*AMB ITEM I VALUE ANTERIORS A MDL_FEEDBACK_ITEM*/
									/*OBTINC ENUNCIAT A NAME I OPCIONS A PRESENTATION*/
									/******************************************************/
									/***********************************/
									/*TOTES LES POSSIBLES RESPOSTES*/
									/**********************************/
									$sqly="SELECT * FROM mdl_feedback_item WHERE id='$item_value' AND name<>'' ORDER BY id ASC";
									$resulty=mysql_query($sqly, $conexion);
									while($rowy=mysql_fetch_row($resulty)){
										$item_nom=$rowy[3];
										/*******************/
										/*ESBORRO r>>>>>*/
										/*******************/
										$value_nom=str_replace("r>>>>>","",$rowy[5]);
										/*****************************************************************/
										/*FAIG UNA MATRIU AMB LES DIFERENTS OPCIONS DE VALUE_NOM*/
										/*****************************************************************/
										$resposta=explode ("|",$value_nom);
										echo "<td align='center' bgcolor='$color' width='350px'><font face='Verdana' size='1'>".$resposta[$value_value-1]."</td>";
										$incidencies[$pregunteta][$resposteta]=$resposta[$value_value-1];
										$pregunteta=$pregunteta+1;
								}
							}
							$resposteta=$resposteta+1;
						}
						echo "</tr>";
					echo "</table>";
				echo "</div>";

				echo "<hr><b>ESTADISTIQUES</b><br><br>";
				echo "Preguntes=".$preguntes."<br>";
				echo "Respostes=".$resposteta."<br><br>";

				for($i=0;$i<$preguntes;$i++){
					echo "<b>Pregunta: ".($i+1).": ".$pregunta[$i]."</b><br>";
					$submatriu=repeatedElements($incidencies[$i],true);
					foreach ($submatriu as $key => $row) {
						$color="#FFFFFF";
						$vumetre="";
						for ($k=0; $k<$row['vegades']; $k++){
							$vumetre=$vumetre."#";
						}
						echo $row['valor'].$vumetre.$row['vegades']."<br>";
					}
					echo "<br>";
				}
				/*******************CONTROL DE ACCES FINAL********************************************************/
				}
			else{
				echo"<p align='center'><font face='Verdana' size='2' color='red'><b>ACCÉS DENEGAT!</b></font></p>";
			}
		}
		/******************************************************************************************************/
		?>
		<hr><p align="center"><font face="Verdana" size="1">(c) V.L.G.A. & J.J.M.R. 2016</font></p></font>
	</body>
</html>