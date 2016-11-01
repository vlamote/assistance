<html>
	<head><title>CON.EX.A.</title></head>

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
				sortList: [[0,0],[1,0]]
			});
		});
	</script>
	</head>

	<body bgcolor="#FFFFFF">

		<?php include "connectaBD.php";include "PassaVars.php";

/***********************************************************************************************************************/
/*PER A QUE DONI RESULTATS FIABLES CAL QUE LA ESTRUCTURA DE CATEGORIES DE TOTES LES MATERIES SIGUI LA SEGÜENT:*/
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

/*On la formula de calcul del total del curs hauria de ser: =max((([[1T]]+[[2T]]+[[3T]])/3);[[ExtraJun]];[[ExtraSet]])*/

/***********************************************************************************************************************/
	
			/***************************/
			/* DEFINICIO DE VARIABLES */
			/***************************/
			$numero_notes_suspeses=0;
			$numero_notes=0;
			$idcurs=$_POST["idcurs"];
			$nom_nota= $_POST["nom_nota"];

			if (strpos($idcurs, 'ALUM') <> 'FALSE'){
					$sql="SELECT * FROM mdl_course WHERE id = '$idcurs'";
					$result=mysql_query($sql, $conexion);
					while($row=mysql_fetch_row($result)){
						$nom_curs=$row[3];
					}
					$nom_curset=str_replace ("ALUM","",$nom_curs);
			}
			else{
				$nom_curset=$idcurs;
			}

			$nom_curs_retocat=str_replace("'", "-", $row4[3]);
			$popup_notes=$popup_notes."\n".$nom_curs_retocat;

			echo "<p align='center'><font face='Verdana' size='2'><b>Estadistica notes ".$nom_nota." ".$nom_curset." -".$idcurs."-</b></font></p>";
			echo "<p align='center'><font face='Verdana' size='2' color='red'>Si un alumne <b>no surt</b> a la llista és perquè la nota final és 0 ó no te cap nota posada.</font>";

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

			/**********************************************/
			/*TRIO EL CURS QUE M'HAN DIT AL FORMULARI*/
			/*********************************************/

/*IF1*/		$sql="SELECT * FROM mdl_course WHERE id = '$idcurs'";
			$result=mysql_query($sql, $conexion);
			while($row=mysql_fetch_row($result)){

				$nom_curs=$row[3];

				echo "<div align='center'>
				<table id='grupal' class='tablesorter' width='100px'>
					<thead>
						<tr>
							<th width='50px' align='center'>$nom_curs</th>
							<th width='50px' align='center'>Nota $nom_nota</th>
						</tr>
					</thead><tbody></div>";

					/*******************************************************************************************************/
					/*PER A CADA CURS BUSCO A 'MDL_GRADE_ITEMS' L'ID DELS REGISTRES AMB ITEMTYPE COURSE I CATEGORY*/
					/*******************************************************************************************************/

/*IF6*/				$sql5 = "SELECT * FROM mdl_grade_items WHERE ((courseid='$idcurs')  AND (itemname='$nom_nota'))";
					$result5=mysql_query($sql5, $conexion);
					while($row5=mysql_fetch_row($result5)){

						$item_nota=$row5[0];
						$nom_nota2=$row5[3];
						$tipus_nota=$row5[4];

						/**********************************************************************/
						/*BUSCO A 'MDL_GRADE_GRADES' ELS REGISTRES AMB L'ITEMID I USERID*/
						/*********************************************************************/

/*IF7*/					$sql6 = "SELECT * FROM mdl_grade_grades WHERE (itemid='$item_nota') AND (finalgrade<>'NULL')";
						$result6=mysql_query($sql6, $conexion);
						while($row6=mysql_fetch_row($result6)){

							$numero_notes=$numero_notes+1;
							$nota_maxima=number_format($row6[4],0);
							$nota=number_format($row6[8],0);
							$alumne=$row6[2];
	
/*IF8*/						$sql61 = "SELECT * FROM mdl_user WHERE id=$alumne";
							$result61=mysql_query($sql61, $conexion);
							while($row61=mysql_fetch_row($result61)){
								$nom_alumne=$row61[11].", ".$row61[10];
								$numero_notes=0;
								$numero_notes_suspeses=0;
								echo"<td align='left' width='50px'><font face='Verdana' size='1'><a href='/user/profile.php?id=$idalumne' target='blank'>$nom_alumne</a></font></td>";

							$color_nota="black";

/*IF9*/						if($nota<($nota_maxima/2) OR $nota==""){
								$color_nota="red";
								$numero_notes_suspeses=$numero_notes_suspeses+1;
/*FIIF9*/					}

$nota=number_format(($nota*10/$nota_maxima),2);

						/*ACTUALITZO LLISTA DE SUSPESOS*/

						if ($numero_notes_suspeses=='0'){$alumnes_amb_suspeses[0]=$alumnes_amb_suspeses[0]+1;}
						if ($numero_notes_suspeses=='1'){$alumnes_amb_suspeses[1]=$alumnes_amb_suspeses[1]+1;}
						if ($numero_notes_suspeses=='2'){$alumnes_amb_suspeses[2]=$alumnes_amb_suspeses[2]+1;}
						if ($numero_notes_suspeses=='3'){$alumnes_amb_suspeses[3]=$alumnes_amb_suspeses[3]+1;}
						if ($numero_notes_suspeses=='4'){$alumnes_amb_suspeses[4]=$alumnes_amb_suspeses[4]+1;}
						if ($numero_notes_suspeses>='5'){$alumnes_amb_suspeses[5]=$alumnes_amb_suspeses[5]+1;}

						/****************************************************************/
						/*BUSCO EL $CONTEXTID I EL $MODIFIERID DE TOTS ELS REGISTRES*/
						/*DE L'ALUMNE A 'MDL_ROLE_ASSIGNMENT.USERID=IDALUMNE' */
						/*ORDENAT PER TIMEMODIFIED CREIXENT (CURSOS MES RECIENTS PRIMER)*/
						/************************************************************************/		

/*IF4*/					$sql2 = "SELECT * FROM mdl_role_assignments WHERE (userid='$idalumne') ORDER BY timemodified DESC";
						$result2=mysql_query($sql2, $conexion);
						while($row2=mysql_fetch_row($result2)){
		
							$contexte=$row2[2];

							/**************************************************************/
							/*PER A CADA CURS BUSCO A 'MDL_CONTEXT.$id=$CONTEXTID'*/
							/************************************************************/

/*IF5*/						$sql3 = "SELECT * FROM mdl_context WHERE (id='$contexte')";
							$result3=mysql_query($sql3, $conexion);
							while($row3=mysql_fetch_row($result3)){
								$instancia=$row3[2];
								$enllas="http://iessitges.xtec.cat/grade/report/grader/index.php?id=".$instancia;			
/*FIIF5*/					}
/*FIIF4*/				}
						$num_alumnes_grup=$num_alumnes_grup+1;
						echo "<td align='right' width='50px'><font face='Verdana' size='1' color='$color_nota'>".$nota."</a> <a href='/assistencia/notes_personal.php?id=$alumne' target='blank' title='Notes'><img src='http://iessitges.xtec.cat/assistencia/imatges/nota.svg'></a></font></td></tr>";
/*FIIF7*/				}
/*FIIF6*/			}
/*FIIF8*/		}
/*FIIF1*/	}

			echo "<p align='center'><font face='Verdana' size='2'>";
			echo $alumnes_amb_suspeses[1]." de ".$num_alumnes_grup." (".number_format($alumnes_amb_suspeses[1]*100/$num_alumnes_grup, 2, '.', '')."%)"." suspen <b>".$nom_nota."</b> de: ".$nom_curs."<br>";
			echo "</p></font>";
			include "desconnectaBD.php";
			echo "</tbody></table>";
		?>
		<hr>
		<p align="center">
			<font face="Verdana" size="1">(c) V.L.G.A. 2016</font>
		</p>
	</body>
</html>