<html><head><title>CON.EX.A.</title> <script language="javascript" type="text/javascript" src="datetimepicker.js"></script></head>
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
</table><hr>

<LINK href="jquery/themes/blue/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="jquery/jquery-latest.js"></script>
<script type="text/javascript" src="jquery/jquery.tablesorter.js"></script>
<script type="text/javascript">
$(document).ready(function() {
$("#notes").tablesorter({
sortList: [[0,0],[1,0]]
});
});
</script></head><body bgcolor="#FFFFFF">

<?php include "connectaBD.php";include "PassaVars.php";

///////////////////////////////////
/// Afegit Juanjo 12/12/2013 ///
///////////////////////////////////

$registres=array();  //Aquesta variable la ompliré amb els valors definitius resultants $datasessio,$cursoficial...per després muntar un array bidimensional que passaré a la funció que printarà el pdf...
$registrespdf[][]="";  //Array bidimensional que contindrà tots els registres definitius i que passarem a imprimir a pdf
$x=0; //Contador per número de files de l'array bidimensional 
$z=0; //Contador per número de columnes de l'array bidimensional

///////////////////////////////////
/// FI          Juanjo 12/12/2013 ///
///////////////////////////////////

/***************************/
/* DEFINICIO DE VARIABLES */
/***************************/

$id = $_GET["id"];
$idalumne=$id;
$numero_notes_suspeses=0;
$numero_notes=0;

/**************************/
/*ESBRINO NOM ALUMNE */
/*************************/

$sql1 = "SELECT * FROM mdl_user WHERE id=$idalumne";
$result1=mysql_query($sql1, $conexion);
while($row1=mysql_fetch_row($result1)){

	$alumne=$row1[11].", ".$row1[10];

}

?>

<!--/****************************/-->
<!--/**ENCAPSALAMENT DE LA TAULA*/-->
<!--/****************************/-->   
<div align='center'>
	<table id='notes' class='tablesorter' width='50px' align='center'>
		<thead>
			<tr>
				<th width='020px' align='center'><font face='Verdana' size='1'><b>Matèria</font></b></th>
				<th width='020px' align='center'><font face='Verdana' size='1'><b>Concepte</font></b></th>
				<th width='005px' align='center'><font face='Verdana' size='1'><b>Nota</font></b></th>
				<th width='005px' align='center'><font face='Verdana' size='1'><b>#</font></b></th>
			</tr>
		</thead>
</div>

<?php

/***************************************************************************************************************************************************************************************************/
/*BUSCO EL $CONTEXTID I EL $MODIFIERID DE TOTS ELS REGISTRES DE L'ALUMNE A 'MDL_ROLE_ASSIGNMENT.USERID=IDALUMNE' ORDENAT PER TIMEMODIFIED CREIXENT (CURSOS MES RECIENTS PRIMER)*/
/***************************************************************************************************************************************************************************************************/

$sql2 = "SELECT * FROM mdl_role_assignments WHERE (userid='$idalumne') ORDER BY timemodified DESC";
$result2=mysql_query($sql2, $conexion);
while($row2=mysql_fetch_row($result2)){

	$contexte=$row2[2];

	/********************************************************************************************************************/
	/*PER A CADA CURS BUSCO A 'MDL_CONTEXT.$id=$CONTEXTID' L'ID DELS REGISTRES AMB ITEMTYPE COURSE I CATEGORY*/
	/********************************************************************************************************************/

	$sql3 = "SELECT * FROM mdl_context WHERE (id='$contexte')";
	$result3=mysql_query($sql3, $conexion);
	while($row3=mysql_fetch_row($result3)){

		$instancia=$row3[2];
		$enllas="http://iessitges.xtec.cat/grade/report/grader/index.php?id=".$instancia;

		/*****************/
		/*NOM DEL CURS*/
		/*****************/

		$sql4 = "SELECT * FROM mdl_course WHERE (id='$instancia')";
		$result4=mysql_query($sql4, $conexion);
		while($row4=mysql_fetch_row($result4)){

			$nom_curs=$row4[3];
			$curs=$row4[4];
		}

		/*******************************************************************************************************/
		/*PER A CADA CURS BUSCO A 'MDL_GRADE_ITEMS' L'ID DELS REGISTRES AMB ITEMTYPE COURSE I CATEGORY*/
		/*******************************************************************************************************/
		$sql5 = "SELECT * FROM mdl_grade_items WHERE (courseid='$instancia')";
		$result5=mysql_query($sql5, $conexion);
		while($row5=mysql_fetch_row($result5)){

			$item_nota=$row5[0];
			$nom_nota=$row5[3];
			$tipus_nota=$row5[4];
			$amagat=$row5[23];

			/*********************************************************************/
			/*BUSCO A 'MDL_GRADE_GRADES' ELS REGISTRES AMB L'ITEMID I USERID*/
			/*********************************************************************/
  
			$sql6 = "SELECT * FROM mdl_grade_grades WHERE (userid='$idalumne') AND (itemid='$item_nota')";
			$result6=mysql_query($sql6, $conexion);
			while($row6=mysql_fetch_row($result6)){
		
				$nota_maxima=number_format($row6[4],2);
				$nota=number_format($row6[8],2);
				$profe=$row6[7];

				$sql61 = "SELECT * FROM mdl_user WHERE id=$profe";
				$result61=mysql_query($sql61, $conexion);
				while($row61=mysql_fetch_row($result61)){

					$nom_profe=$row61[11].", ".$row61[10];
				}

				$es_un_trimestre=stristr($nom_nota, "trimestre");

				/**************************************************/
				/*HO LLISTO SI ES CATEGORIA DE TRIMESTRE O CURS*/
				/**************************************************/

				if(($tipus_nota=="course") OR (($tipus_nota=="category") AND ($es_un_trimestre<>"FALSE") AND ($amagat=0))){

					/*PER A QUE DONI LES NOTES EN TANT PER 10*/
					$nota=number_format ($nota/$nota_maxima*10,2);

					echo "<td align='center' width='020px'><font face='Verdana' size='1'><a href='/course/view.php?id=$instancia' target='blank' title='$nom_curs ($nom_profe)'>$curs</a>";

					if($nom_nota=="Total del curs"){
						$color_nota="black";
						if($nota<5){
							$color_nota="red";
							$numero_notes_suspeses=$numero_notes_suspeses+1;
						}
						$numero_notes=$numero_notes+1;

						echo "<td align='center' width='020px'><font face='Verdana' size='1'><b>$nom_nota</b></font></td>";
						echo "<td align='right' width='005px'><font face='Verdana' size='1' color=$color_nota><b>$nota</b></font></td>";
					}
					else{
						echo "<td align='center' width='020px'><font face='Verdana' size='1'>$nom_nota</font></td>";
						echo "<td align='right' width='005px'><font face='Verdana' size='1' color=$color_nota>$nota</font></td>";
					}

					echo"<td align='center' width='025px'><font face='Verdana' size='1'><a href='$enllas' target='blank' title='Edita'><img src='http://iessitges.xtec.cat/assistencia/imatges/edit.svg'></a>
					</font></td></tr>";

					//////////////////////////////////////////////////////////////////////////////////////////////////////
					//Afegit Juanjo, preparem els nostres arrays que necessitarem per les impressions a pdf...//
					/////////////////////////////////////////////////////////////////////////////////////////////////////
					$registres[0]=$alumne;
					$registres[1]=$curs;
					$registres[2]=$nom_nota;
					$registres[3]=$nota." / ".$nota_maxima;

					foreach ( $registres as $valor){
						$registrespdf[$x][$z]=$valor;
						$z=$z+1; 
					}

					$x=$x+1; 
					$z=0;

					/////////////////////////////////////////////////////////////////////////////////////////////////
					// FI Juanjo, preparem els nostres arrays que necessitarem per les impressions a pdf...//
					////////////////////////////////////////////////////////////////////////////////////////////////	

				}
			}
		}
	}
}

echo "<p align='center'><font face='Verdana' size='2'><b>Alumne: </b> $alumne ($idalumne). <b>Suspeses:</b> $numero_notes_suspeses de $numero_notes<br></font></p>";

////////////////////////////////////////////////////////////////////////////////////
//Comprobem que tenim registres al nostre array per processar a pdf...////
/////////////////////////////////////////////////////////////////////////////////////

$numregistres=count($registrespdf);

echo "</tbody></table>";

include "desconnectaBD.php";

if ($numregistres > 1){  
//echo "El numero de registros es $numregistres";
//echo "Tengo mas registros de 1";

?>

<form action="impressio_notes_pdf.php" method="POST">
<input type="hidden" name="llistapdf" value='<?php echo serialize($registrespdf) ?>'</input>
<input type="submit" value="Llistar en pdf">
</form>

<?php

}

?>

<hr><p align="center"><font face="Verdana" size="1">(c) V.L.G.A. 2014</font></p></font></body></html>