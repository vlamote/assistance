<html>
	<head>
		<title>RE.G.</title>
		<style>
			.TextRotat{
						-webkit-transform: rotate(-90deg); 
		    				-moz-transform: rotate(-90deg);
		   				-o-transform: rotate(-90deg);
						transform: rotate(-90deg);
						filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
						height:20px;
						width:20px;
						}
			.inline-block{
						display:-moz-inline-stack;
						display:inline-block;
						zoom:1;
						*display:inline; 
						}
		</style>
	</head>

	<table border="0" width="100%" id="table2">
	<tr>
		<td width="22%"><font face="Verdana" size="1"><p align="left"><b>
			<a href="http://iessitges.xtec.cat/assistencia/llistat_alumnes.php" target="_self" title="Consulta per alumne">Alumne</a> |
			<a href="http://iessitges.xtec.cat/assistencia/notes_grups_formulari.php" target="_self" title="Consulta per grup">Grup</a> |
			<a href="http://iessitges.xtec.cat/assistencia/notes_materies_formulari.php" target="_self" title="Consulta per materia">Materia</a> | 
			<a href="https://saga.xtec.cat/entrada/nodes" target="_blank" title="Ves al SAGA">Saga</a></font></td>
		</td>
		<td width="56%"><font face="Verdana" size="1" color="black"><p align="center"><b>CONSULTA DELS EXPEDIENTS DELS ALUMNES</b></p></td>
		<td width="22%"><font face="Verdana" size="1"><p align="right"><b>CONsulta.EXpedient.Alumnes.</b></p></font></td>
	</tr>
</table>
	<hr>
	<LINK href="jquery/themes/blue/style.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="jquery/jquery-latest.js"></script>
	<script type="text/javascript" src="jquery/jquery.tablesorter.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#grupal").tablesorter({
				sortList: [[1,0],[0,0]]
			});
		});
	</script>
	</head>

	<body bgcolor="#FFFFFF">

		<?php include "connectaBD.php";include "PassaVars.php";include "Funcions_Usuaris.php";

mysql_query("SET NAMES 'utf8'");
/*******************************************************************/
/*PER A QUE DONI RESULTATS FIABLES*/
/*CAL QUE LA ESTRUCTURA DE CATEGORIES*/
/*DE TOTES LES MATERIES SIGUI LA SEGÜENT:*/
/*Final*/
/**Inicial*/
/***Nota inicial*/
/**1r. trimestre*/
/***Nota 1r. trimestre*/
/**2n. trimestre*/
/***Nota 2n. trimestre*/
/**3r. trimestre*/
/***Nota 3r. trimestre*/
/**Extraordinària de juny*/
/***Nota Extraordinària de juny*/
/**Extraordinària de setembre*/
/***Nota Extraordinària de setembre*/
/*Total del curs*/
/*On la formula de calcul del total del curs*/ 
/*hauria de ser: =max((([[1T]]+[[2T]]+[[3T]])/3);[[ExtraJun]];[[ExtraSet]])*/
/********************************************************************/
	
			/***************************/
			/* DEFINICIO DE VARIABLES */
			/***************************/
			$numero_notes_suspeses=0;
			$numero_notes=0;
			$idcohort=$_POST["idcohort"];
			$nom_nota= $_POST["nom_nota"];
			$numero_notes_major=0;
			$id_alumne_amb_numero_notes_major=0;
			$nom_curset=$idcohort;

			echo "<p align='center'><font face='Verdana' size='2'><b>Nota ".$nom_nota." ".$nom_curset."</b></font></p>";

			/**********************************************************************************************/
			/*AQUESTA MATRIU DESA A LA COORDENADA i LA QUANTITAT D'ALUMNES QUE TENEN i SUSPESES*/
			/**********************************************************************************************/
			$alumnes_amb_suspeses[0]=0;
			$alumnes_amb_suspeses[1]=0;
			$alumnes_amb_suspeses[2]=0;
			$alumnes_amb_suspeses[3]=0;
			$alumnes_amb_suspeses[4]=0;
			$alumnes_amb_suspeses[5]=0;
			$num_alumnes_grup=0;

			/**************/
			/*CAPSALERA*/
			/*************/
			echo "
			<div align='center'>
				<table id='grupal' class='tablesorter' width='2000px'>
					<thead>
						<tr height='150px'>
							<th width='500px' align='center'>ALUMNE</th>
							<th width='50px' align='center'><div class='TextRotat'>GRUP</div></th>";
								If($nom_curset=="BAT1"){$nom_materia="1BAT";}
								If($nom_curset=="BAT2"){$nom_materia="2BAT";}
								If($nom_curset=="CAGS"){$nom_materia="CAGS";}
								If($nom_curset=="CFGM1"){$nom_materia="1CFGM";}
								If($nom_curset=="CFGM2"){$nom_materia="2CFGM";}
								If($nom_curset=="CFGS1"){$nom_materia="1CFGS";}
								If($nom_curset=="CFGS2"){$nom_materia="2CFGS";}
								If($nom_curset=="ESO1"){$nom_materia="1ESO";}
								If($nom_curset=="ESO2"){$nom_materia="2ESO";}
								If($nom_curset=="ESO3"){$nom_materia="3ESO";}
								If($nom_curset=="ESO4"){$nom_materia="4ESO";}
								If($nom_curset=="PFI"){$nom_materia="PFI";}

								$sql4 = "SELECT * FROM mdl_course WHERE (shortname LIKE '%$nom_materia%') AND visible =TRUE ORDER BY shortname";
								$result4=mysql_query($sql4, $conexion);
								while($row4=mysql_fetch_row($result4)){
									$caracters_separadors = array(" ", "'");
									$nom_materia2= str_replace($caracters_separadors, "_", $row4[3]);
									echo "<th width='100px' align='center'><a href='' title=$nom_materia2><div class='TextRotat'>$row4[4]</div></a></th>";
								}
							echo "<th width='50px' align='center'><div class='TextRotat'>SUSPESES</div></th>";
							echo "
							</tr>
					</thead>
				</div>";

			/*************************************************/
			/*TRIO LA COHORT QUE M'HAN DIT AL FORMULARI*/
			/*************************************************/
			$num_alumnes_grup=0;

			$sql="SELECT * FROM mdl_cohort WHERE idnumber LIKE  '%$nom_curset%' AND idnumber NOT LIKE  '%PROFE%' AND idnumber NOT LIKE  '%TUTOR%'";
			$result=mysql_query($sql, $conexion);
			while($row=mysql_fetch_row($result)){

				$nom_cohort=$row[3];
				$id_cohort=$row[0];
				if(strpos($nom_cohort,"1A")<>FALSE){$lletra_grup="A";}
				if(strpos($nom_cohort,"1B")<>FALSE){$lletra_grup="B";}
				if(strpos($nom_cohort,"1C")<>FALSE){$lletra_grup="C";}
				if(strpos($nom_cohort,"1D")<>FALSE){$lletra_grup="D";}

				/***************************************/
				/*AGAFO CADA ALUMNE DE LA COHORT*/
				/**************************************/
				$sql1="SELECT * FROM mdl_cohort_members WHERE cohortid = '$id_cohort'";
				$result1=mysql_query($sql1, $conexion);
				while($row1=mysql_fetch_row($result1)){
					$idalumne=$row1[2];
					$numero_notes=0;
					echo"<tr>";
						echo"<td align='left' width='500px'><font face='Verdana' size='1'><a href='http://iessitges.xtec.cat/user/view.php?id=".$idalumne."' target='blank' title='Perfil de: ".$idalumne."'>".NomUsuari($idalumne)."</a></font></td>";
						echo"<td align='left' width='50px'><font face='Verdana' size='1'><a href='' target='blank'>".$lletra_grup."</a></font></td>";
						$notes_suspeses=0;
						$i=0;
						/**********************************/
						/*PER A CADA CURS DE MOODLE ...*/
						/*********************************/
						$sql4 = "SELECT * FROM mdl_course WHERE (shortname LIKE '%$nom_materia%') AND visible =TRUE ORDER BY shortname";
						$result4=mysql_query($sql4, $conexion);
						while($row4=mysql_fetch_row($result4)){
							$caracters_separadors = array(" ", "'");
							$nom_materia3= str_replace($caracters_separadors, "_", $row4[3]);
							$id_curs=$row4[0];
							$item_nota="";
							$nom_nota2="Curs sense aquesta categoria";
							$tipus_nota=0;
							$nota="";
							/*************************************************/
							/*ESBRINO ID DE LA NOTA D'AQUELLA AVALUACIO*/
							/************************************************/
							$sql5 = "SELECT * FROM mdl_grade_items WHERE ((courseid='$id_curs')  AND (itemname='$nom_nota'))";
							$result5=mysql_query($sql5, $conexion);
							while($row5=mysql_fetch_row($result5)){
								$item_nota=$row5[0];
								$nom_nota2=$row5[3];
								$tipus_nota=$row5[4];
							}
							/*******************************************/
							/*ESBRINO NOTA D'AQUELL ITEM I ALUMNE*/
							/*****************************************/
							if($item_nota<>""){
								$sql6 = "SELECT * FROM mdl_grade_grades WHERE (userid='$idalumne') AND (itemid='$item_nota')";
								$result6=mysql_query($sql6, $conexion);
								while($row6=mysql_fetch_row($result6)){
									$numero_notes=$numero_notes+1;
									$nota_maxima=number_format($row6[4],2);
									$nota=number_format(($row6[8]*10/$nota_maxima),2);
									if($nota<'5.00'){
										$notes_suspeses=$notes_suspeses+1;
										$suspeses_materia[$i]=$suspeses_materia[$i]+1;
									}
									$profe=$row6[7];
								}
							}
							echo"<td align='left' width='50px'><font face='Verdana' size='1'><a href='http://iessitges.xtec.cat/grade/report/user/index.php?id=".$id_curs."&userid=".$idalumne."' target='blank' title='".$nom_materia3."'>".$nota."</a></font></td>";
							$i=$i+1;
						}
					echo"<td align='left' width='50px'><font face='Verdana' size='1'><a href='notes_personal.php?id=$idalumne' target='blank' title='Notes nomes de: ".NomUsuari($idalumne)."'>".$notes_suspeses."</a></font></td>";
					echo"</tr>";

					/*ACTUALITZO LLISTA DE SUSPESOS*/
					if ($notes_suspeses=='0'){$alumnes_amb_suspeses[0]=$alumnes_amb_suspeses[0]+1;}
					if ($notes_suspeses=='1'){$alumnes_amb_suspeses[1]=$alumnes_amb_suspeses[1]+1;}
					if ($notes_suspeses=='2'){$alumnes_amb_suspeses[2]=$alumnes_amb_suspeses[2]+1;}
					if ($notes_suspeses=='3'){$alumnes_amb_suspeses[3]=$alumnes_amb_suspeses[3]+1;}
					if ($notes_suspeses=='4'){$alumnes_amb_suspeses[4]=$alumnes_amb_suspeses[4]+1;}
					if ($notes_suspeses>='5'){$alumnes_amb_suspeses[5]=$alumnes_amb_suspeses[5]+1;}
					$num_alumnes_grup=$num_alumnes_grup+1;
				}
			}
			echo "<p align='left'><font face='Verdana' size='1'><b>1. Estadistica global:</b><br><br>";
			echo $alumnes_amb_suspeses[0]." de ".$num_alumnes_grup." (".number_format($alumnes_amb_suspeses[0]*100/$num_alumnes_grup, 2, '.', '')."%)"." amb cap suspesa<br>";
			echo $alumnes_amb_suspeses[1]." de ".$num_alumnes_grup." (".number_format($alumnes_amb_suspeses[1]*100/$num_alumnes_grup, 2, '.', '')."%)"." amb 1 suspesa<br>";
			echo $alumnes_amb_suspeses[2]." de ".$num_alumnes_grup." (".number_format($alumnes_amb_suspeses[2]*100/$num_alumnes_grup, 2, '.', '')."%)"." amb 2 suspeses<br>";
			echo $alumnes_amb_suspeses[3]." de ".$num_alumnes_grup." (".number_format($alumnes_amb_suspeses[3]*100/$num_alumnes_grup, 2, '.', '')."%)"." amb 3 suspeses<br>";
			echo $alumnes_amb_suspeses[4]." de ".$num_alumnes_grup." (".number_format($alumnes_amb_suspeses[4]*100/$num_alumnes_grup, 2, '.', '')."%)"." amb 4 suspeses<br>";
			echo $alumnes_amb_suspeses[5]." de ".$num_alumnes_grup." (".number_format($alumnes_amb_suspeses[5]*100/$num_alumnes_grup, 2, '.', '')."%)"." amb +5 suspeses ";
			echo "<br><br><b>2. Detalls individuals:</b><br>";

				echo "</font></tbody></table>";

echo "<p align='left'><font face='Verdana' size='1'><b>3. Estadistica per materies:</b><br><br>";

			/**************/
			/*CAPSALERA*/
			/*************/
			echo "
			<div align='center'>
				<table id='grupal2' class='tablesorter' width='2000px'>
					<thead>
						<tr height='150px'>";
								If($nom_curset=="BAT1"){$nom_materia="1BAT";}
								If($nom_curset=="BAT2"){$nom_materia="2BAT";}
								If($nom_curset=="CAGS"){$nom_materia="CAGS";}
								If($nom_curset=="CFGM1"){$nom_materia="1CFGM";}
								If($nom_curset=="CFGM2"){$nom_materia="2CFGM";}
								If($nom_curset=="CFGS1"){$nom_materia="1CFGS";}
								If($nom_curset=="CFGS2"){$nom_materia="2CFGS";}
								If($nom_curset=="ESO1"){$nom_materia="1ESO";}
								If($nom_curset=="ESO2"){$nom_materia="2ESO";}
								If($nom_curset=="ESO3"){$nom_materia="3ESO";}
								If($nom_curset=="ESO4"){$nom_materia="4ESO";}
								If($nom_curset=="PFI"){$nom_materia="PFI";}

								$sql4 = "SELECT * FROM mdl_course WHERE (shortname LIKE '%$nom_materia%') AND visible =TRUE ORDER BY shortname";
								$result4=mysql_query($sql4, $conexion);
								while($row4=mysql_fetch_row($result4)){
									$caracters_separadors = array(" ", "'");
									$nom_materia2= str_replace($caracters_separadors, "_", $row4[3]);
									echo "<th width='100px' align='center'><a href='' title=$nom_materia2><div class='TextRotat'>$row4[4]</div></a></th>";
								}
							echo "
							</tr>
					</thead>
				</div>";

echo"<tr>";
	$num_alumnes_grup=0;
	$i=0;
	$sql4 = "SELECT * FROM mdl_course WHERE (shortname LIKE '%$nom_materia%') AND visible =TRUE ORDER BY shortname";
	$result4=mysql_query($sql4, $conexion);
	while($row4=mysql_fetch_row($result4)){
		echo"<td align='left' width='50px'><font face='Verdana' size='1'>".$suspeses_materia[$i]."</font></td>";
		$i=$i+1;
	}


echo "</tr></font></tbody></table>";

		include "desconnectaBD.php";
		?>
		<hr>
		<p align="center"><font face="Verdana" size="1">(c) V.L.G.A. 2016</font></p>
	</body>
</html>