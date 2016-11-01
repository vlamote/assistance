<html>
	<head>
		<title>SI.S.PA.LLI.</title>
		<LINK href="jquery/themes/blue/style.css" rel="stylesheet" type="text/css">
		<script type=	"text/javascript" src="jquery/jquery-latest.js"></script>
		<script type="text/javascript" src="jquery/jquery.tablesorter.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
			$("#estadistiquesprofes").tablesorter({
			sortList: [[0,0]]
			});
			});
		</script>
	</head>
	<body>
		<table border="0" width="100%" id="table2">
			<tr>
				<td width="10%"><p align="left"><font face="Verdana" size="1"><a href="/assistencia/passat_llista_SI_formulari.php">Nova consulta</a></td>
				<td width="65%"><p align="center"><font face="Verdana" size="1" color="red"><b>Piqueu a <i>Professor</i> per a ordenar-ho per ordre alfabetic o useu el cercador del navegador per trobar algun professor determinat</b></font></P></td>
				<td width="30%"><p align="right"><font face="Verdana" size="1"><b>S'ha passat llista DES DEL CENTRE ...</b></font></p></td>
			</tr>
		</table>
		<hr>
		<?php include "connectaBD.php";include "PassaVars.php";
		/*******************CONTROL DE ACCES INICI********************************************************/
		require_once ('../config.php');
		global $USER;
		$userid=$USER->id;
		if(!isloggedin()){
			header('Location: http://iessitges.xtec.cat/login/index.php?id=284'); }
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
				/* DEFINICIO DE VARIABLES */
				/**************************/
				$alumne="---";
				$profe="---";
				$sessio="---";
				$identificador=0;
				$enllas="mod/attforblock/view.php";
				$sessio="---";
				$assistencia="---";
				$curs="---";
				$nomcurs="---";
				$nomgrup="---";
				$cursoficial="N/A";
				$grupoficial="N/A";	
				$compta_alumnes=1;
				$data1= $_GET["data1"];
				$data2 = $_GET["data2"];
				$dataentrada1= strtotime($data1);
				$dataentrada2= strtotime($data2);
				$compta_faltes=0;/*I*/
				$llista_dates='/';
				$abans=time();
				$totals_hores_falta=0;

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

				/***************************************************/
				/***SI NO POSA DATES MIRA UN MES ENDARRERA****/
				/***************************************************/
				if ($data1=="" AND $data2==""){
					$dataentrada1=time()-2592000;
					$data1=date("d-m-y",$dataentrada1);
					$dataentrada2=time();
					$data2=date("d-m-y",$dataentrada2);
				} 
				/*****************************/
				/*ENCAPSALAMENT DEL TITOL*/
				/****************************/
				echo"<p align='center'><font face='Verdana' size='1'><b>Periode de consulta: </b>$data1<b> a </b>$data2</p></font>";
				echo"<div align='center'>
				<table id='estadistiquesprofes' width='300px' class='tablesorter'>
					 <thead>
						<tr>
							<th width='100px' align='center'><b>Data</b></th>
							<th width='100px' align='center'><b>Professor</b></th>
							<th width='100px' align='center'><b>Descripcio sessio</b></th>
						</tr>
					</thead>";
					/********************************************************/   
					/*TRIO LES SESSIONS QUE TENEN DATES ENTRE LES TRIADES*/
					/*********************************************************/
					$sql01 = "SELECT * FROM mdl_log WHERE ((module LIKE '%attforblock%') AND (ip LIKE '%192.168.%') AND (action LIKE '%attendance taked%') AND (time>='$dataentrada1') AND (time<='$dataentrada2')) order by time asc";
					$result01=mysql_query($sql01, $conexion);
					while($row01=mysql_fetch_row($result01)){
						$datasessio=date("Y-m-d H:i",$row01[1]);
						$profe=$row01[9];
						$curs=$row01[4];

						/*********************/   
						/*ESBRINO EL GRUP*/           
						/**********************/   
						$sql8 = "SELECT * FROM mdl_course WHERE id=$curs";
						$result8=mysql_query($sql8, $conexion);
						while($row8=mysql_fetch_row($result8)){
							$nom_curs=$row8[3];
						}

						echo"
					<tr>
						<td align='center' bgcolor='$color' width='100px'><font face='Verdana' size='1'>$datasessio</font></td>
						<td align='center' bgcolor='$color' width='100px'><font face='Verdana' size='1'>$profe</a></font></td>
						<td align='center' bgcolor='$color' width='100px'><font face='Verdana' size='1'>$nom_curs</font></td>
					</tr>";

					$identificador=$identificador+1;	

					//////////////////////////////////////////////////////////////////////////////////////////////////////
					//Afegit Juanjo, preparem els nostres arrays que necessitarem per les impressions a pdf...//
					/////////////////////////////////////////////////////////////////////////////////////////////////////
					$registres[0]=$datasessio;
					$registres[1]=$profe;
		
					//echo "Para \$z igual a $z valor vale $valor i /n";
					foreach ( $registres as $valor){
						$registrespdf[$x][$z]=$valor;
						$z=$z+1; 
					}
		
					//print $registrespdf[$x][4];
					$x=$x+1; 
					$z=0;
		
					/////////////////////////////////////////////////////////////////////////////////////////////////
					// FI Juanjo, preparem els nostres arrays que necessitarem per les impressions a pdf...//
					////////////////////////////////////////////////////////////////////////////////////////////////	
								
				}				
				/*******************CONTROL DE ACCES FINAL********************************************************/
			}	
			else{
				echo"<p align='center'><font face='Verdana' size='2' color='red'><b>ACCÉS DENEGAT!</b></font></p>";
			}
		}
echo "</tbody>";
echo"</table>";
include "desconnectaBD.php";

////////////////////////////////////////////////////////////////////////////////////
//Comprobem que tenim registres al nostre array per processar a pdf...////
/////////////////////////////////////////////////////////////////////////////////////
$numregistres=count($registrespdf);
////////////////////
//Fi          juanjo///
//////////////////

$durada=time()-$abans;
echo "<p align='center'><font face='Verdana' size='1' color='black'>Trobades <b>$identificador</b> sessions on s'ha passat llista DES DEL CENTRE(Durada del proces: <b>$durada [sg]</b>).</font></p>";
echo "</tbody>";
echo"</table>";include "desconnectaBD.php";

?>


<?php
////////////////////
//Afegit juanjo///
//////////////////

if ($numregistres > 1){  

?>

<form action="passat_llista_SI_llistat_pdf.php" method="POST">
<input type="hidden" name="passat_llista_SI_llistat_pdf" value='<?php echo serialize($registrespdf) ?>'</input>
<input type="submit" value="Llistar en pdf">

</form>

<?php

}

////////////////////
//Fi          juanjo///
//////////////////
?>

<hr><p align="center"><font face="Verdana" size="1">(c) V.L.G.A. & J.J.M.R. 2015</font></p></font></body></html>