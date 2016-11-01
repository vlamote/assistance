<html>
	<head>
		<title>ES.PRO.</title>
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
				<td width="10%"><p align="left"><font face="Verdana" size="1"><a href="/assistencia/esdeveniments_profes_formulari.php">Nova consulta</a></td>
				<td width="65%"><p align="center"><font face="Verdana" size="1" color="red">Pica a l'esdeveniment per veure detalls. Al final hi ha un botó per a imprimir</font></p></td>
				<td width="30%"><p align="right"><font face="Verdana" size="1"><b>ESdeveniments PROfessors</b></font></p></td>
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
				$curs="---";
				$nomcurs="---";
				$nomgrup="---";
				$cursoficial="N/A";
				$grupoficial="N/A";	
				$compta_alumnes=1;
				$data1= $_GET["data1"];
				$data2 = $_GET["data2"];
				$pista = $_GET["pista"];
				$dataentrada1= strtotime($data1);
				$dataentrada2= strtotime($data2);
				$abans=time();
	
				///////////////////////////////////
				/// Afegit Juanjo 12/12/2013 ///
				///////////////////////////////////

				//Aquesta variable la ompliré amb els valors definitius resultants $datasessio,$cursoficial...per després muntar un array bidimensional que passaré a la funció que printarà el pdf...
				$registres=array(); 
				
				 //Array bidimensional que contindrà tots els registres definitius i que passarem a imprimir a pdf
				$registrespdf[][]="";

				//Contador per número de files de l'array bidimensional 
				$x=0;

				//Contador per número de columnes de l'array bidimensional
				$z=0;

				///////////////////////////////////
				/// FI          Juanjo 12/12/2013 ///
				///////////////////////////////////

				/***************************************************/
				/***SI NO POSA DATES MIRA UN MES ENDAVANT****/
				/***************************************************/
				if ($data1=="" AND $data2==""){
					$dataentrada1=time();
					$data1=date("d-m-y",$dataentrada1);
					$dataentrada2=time()+2592000;
					$data2=date("d-m-y",$dataentrada2);
				}
		
				/*****************************/
				/*ENCAPSALAMENT DEL TITOL*/
				/*****************************/
				echo"<p align='center'><font face='Verdana' size='1'><b>Cerca $pista en periode de consulta: </b>$data1<b> a </b>$data2</p></font>";
				echo"
				<div align='center'>
					<table id='estadistiquesprofes' width='200px' class='tablesorter'>
					        <thead>
					            <tr>
						            <th width='010px' align='center'><b>Dia</b></th>
						            <th width='010px' align='center'><b>Durada [h]</b></th>
						            <th width='170px' align='center'><b>Esdeveniment</b></th>
						            <th width='010px' align='center'><b>Convocats</b></th>
					            </tr>
					        </thead>
				</div>";
	
				/*********************************************************/   
				/*TRIO LES SESSIONS QUE TENEN DATES ENTRE LES TRIADES*/
				/*********************************************************/
				$sql01 = "SELECT * FROM mdl_event WHERE ((timestart>= '$dataentrada1') AND (timestart<='$dataentrada2') AND (courseid='24') AND ((name LIKE '%$pista%') OR (description LIKE '%$pista%'))) ORDER BY timestart desc";
				$result01=mysql_query($sql01, $conexion);
				while($row01=mysql_fetch_row($result01)){

					$id_event=$row01[0];
					$identificador=$identificador+1;
					$nom_event1=$row01[1];
					$nom_event=utf8_encode($nom_event1);
					$grup=$row01[5];
					$datasessio=$row01[11];
					$durada=$row01[12]/3600;
					$repeticio=$row01[7];
					$descripcio=$row01[2];

					$dataentrada=date("d-m-y H:i", $datasessio);
					$dia_inici=date("d", $datasessio);
					$mes_inici=date("m", $datasessio);
					$any_inici=date("y", $datasessio);
					$hora_inici=date("H:i", $datasessio);

					$datafinal=$datasessio+$durada;
					$datasortida=date("d-m-y H:i", $datafinal);
					$dia_final=date("d", $datafinal);
					$mes_final=date("m", $datafinal);
					$any_final=date("y", $datafinal);
					$hora_final=date("H:i", $datafinal);

					$data_sencera=date("Y/m/d H:i", $datafinal);

					/**********************/
					/*ESBRINO NOM GRUP*/
					/**********************/
					$nom_grup="Tots";
					$sql02 = "SELECT * FROM mdl_groups WHERE (id='$grup')";
					$result02=mysql_query($sql02, $conexion);
					while($row02=mysql_fetch_row($result02)){				
						$nom_grup=$row02[3];
					}

					echo"
					<td align='center' bgcolor='$color' width='010px'><font face='Verdana' size='1'>$data_sencera</font></td>
					<td align='center' bgcolor='$color' width='010px'><font face='Verdana' size='1'>$durada</font></td>
					<td align='left' bgcolor='$color' width='170px'><font face='Verdana' size='1'><a href='/calendar/view.php?course=24&view=day&cal_d=$dia_inici&cal_m=$mes_inici&cal_y=$any_inici#event_$id_event' title='Pica per a detalls'>$nom_event</a></font></td>
					<td align='center' bgcolor='$color' width='010px'><font face='Verdana' size='1'>$nom_grup</font></td></tr>";

					//////////////////////////////////////////////////////////////////////////////////////////////////////
					//Afegit Juanjo, preparem els nostres arrays que necessitarem per les impressions a pdf...//
					/////////////////////////////////////////////////////////////////////////////////////////////////////
					$registres[0]=$data_sencera;
					$registres[1]=$durada;
					$registres[2]=$nom_event;
					$registres[3]=$nom_grup;

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
				echo "</table></div>";				
				$durada=time()-$abans;
				echo "<br><p align='center'><font face='Verdana' size='1'><b>Trobats </b>$identificador <b>events (recerca feta en </b>$durada <b>[sg])</b></font></p><br>";

				/*******************CONTROL DE ACCES FINAL********************************************************/
			}
			else{	
				echo"<p align='center'><font face='Verdana' size='2' color='red'><b>ACCÉS DENEGAT!</b></font></p>";
			}
		}
		/******************************************************************************************************/

		////////////////////////////////////////////////////////////////////////////////////
		//Comprobem que tenim registres al nostre array per processar a pdf...////
		/////////////////////////////////////////////////////////////////////////////////////

		$numregistres=count($registrespdf);
		include "desconnectaBD.php";
?>


<?php
////////////////////
//Afegit juanjo///
//////////////////
if ($numregistres > 0){  
?>
<form action="esdeveniments_profes_llistat_pdf.php" method="POST">
<input type="hidden" name="esdeveniments_profes_llistat_pdf" value='<?php echo base64_encode(serialize($registrespdf)) ?>'</input>
<p align="center"><input type="submit" value="Llistar en pdf"></p>
</form>
<?php
}
////////////////////
//Fi          juanjo///
//////////////////
?>
<hr><p align="center"><font face="Verdana" size="1">(c) V.L.G.A. & J.J.M.R. 2015</font></p></font></body></html>
	</body>
</html>