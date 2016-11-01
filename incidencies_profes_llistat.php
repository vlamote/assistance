<html>
	<head>
		<title>ES.FAL.P.R.O.</title>
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
				<td width="10%"><p align="left"><font face="Verdana" size="1"><a href="/assistencia/justifica_profes_formulari.php">Nova consulta</a></td>
				<td width="65%"><p align="center"><font face="Verdana" size="1" color="red">Passa per sobre del nom per a veure les dates. Pica sobre el nom per justificar-la.</font> <font face="Verdana" size="1" color="black">Contacta al <a href="http://iessitges.xtec.cat/message/index.php?id=2845" title="Samuel Valls" target="blank">director</a></font></P></td>
				<td width="30%"><p align="right"><font face="Verdana" size="1"><b>EStadistiques   FALtes PROfessors</b></font></p></td>
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
			$identificador=1;
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
			$compta_justificacions=0;/*J*/
			$compta_sortides=0;/*D*/
			$compta_baixes=0;/*B*/
			$compta_reunions=0;/*U*/
			$compta_permisos=0;/*I*/
			$compta_errors=0;/*M*/
			$compta_retards=0;/*R*/
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
			/*****************************/
			echo"<p align='center'><font face='Verdana' size='1'><b>Periode de consulta: </b>$data1<b> a </b>$data2</p></font>";
		echo"
		<div align='center'>
			<table id='estadistiquesprofes' width='200px' class='tablesorter'>
			        <thead>
			            <tr>
				            <th width='080px' align='center'><b><a href='' title='N'>Professor</a></b></th>
				            <th width='030px' align='center'><b><a href='' title='T'>Absencies totals</a></b></th>
				            <th width='030px' align='center'><b><a href='' title='F'>Absencies personals</a></b></th>
				            <th width='030px' align='center'><b><a href='' title='D'>Absencies professionals</a></b></th>
				            <th width='030px' align='center'><b><a href='' title='R'>Retards</a></b></th>
			            </tr>
			        </thead>
		</div>";


				/***********************/
				/*MIRO PROFE A PROFE*/
				/***********************/
				$sql33="SELECT * FROM mdl_user a, mdl_cohort_members b WHERE ((b.cohortid=43) AND (a.id=b.userid)) ORDER BY a.lastname";
				$result33=mysql_query($sql33, $conexion);
				while($row33=mysql_fetch_row($result33)){
					$compta_alumnes=$compta_alumnes+1;
					$idalumne=$row33[0];
					$alumne=$row33[11].", ".$row33[10];

			/*********************************************************/   
			/*TRIO LES SESSIONS QUE TENEN DATES ENTRE LES TRIADES*/
			/*********************************************************/
			$sql01 = "SELECT * FROM mdl_attendance_sessions WHERE (attendanceid='3' AND (sessdate>= '$dataentrada1') AND (sessdate<='$dataentrada2')) order by sessdate desc";
			$result01=mysql_query($sql01, $conexion);
			while($row01=mysql_fetch_row($result01)){

				$sessio=$row01[0];
				$assistencia=$row01[1];
				$grup=$row01[2];
				$datasessio=$row01[3];
				$descripcio=$row01[8];
				$dataentrada=date("Y/m/d H:i", $datasessio);

					/*********************************/
					/*MOSTRO ELS LOGS DE LA SESSIO*/
					/*********************************/   
					$sql1 = "SELECT * FROM mdl_attendance_log WHERE (sessionid= '$sessio') AND (studentid='$idalumne')";
					$result1=mysql_query($sql1, $conexion);
					while($row1=mysql_fetch_row($result1)){
						$estat=$row1[3];
						$datasessio2=date("d-m-y",$datasessio);
						if(substr_count($llista_dates,$datasessio2)==0){
							$llista_dates=$llista_dates."/".$datasessio2;
						}
			
						/*************************************/
						/*ESBRINO ACRONIM D'AQUELL ESTAT*/
						/*************************************/
						$sql31 = "SELECT * FROM mdl_attendance_statuses WHERE (attendanceid='$assistencia' AND id='$estat')";
						$result31=mysql_query($sql31, $conexion);
						while($row31=mysql_fetch_row($result31)){
							$acronim=$row31[2];		
						}
						/*****************************************/
						/*VA ACUMULANT INCIDENCIES PER TIPUS*/
						/*****************************************/
						if($acronim=="R"){$compta_retards=$compta_retards+1;}
						if($acronim=="F"){$compta_faltes=$compta_faltes+1;}
						if($acronim=="I"){$compta_permisos=$compta_permisos+1;}
						if($acronim=="B"){$compta_baixes=$compta_baixes+1;}
						if($acronim=="J"){$compta_justificacions=$compta_justificacions+1;}
						if($acronim=="M"){$compta_errors=$compta_errors+1;}
						if($acronim=="U"){$compta_reunions=$compta_reunions+1;}
						if($acronim=="D"){$compta_sortides=$compta_sortides+1;}
	
					}
				}
				$compta_totals=$compta_retards+$compta_faltes+$compta_errors+$compta_baixes+$compta_reunions+$compta_sortides+$compta_permisos+$compta_justificacions;

				if($compta_totals<>0){

					echo"
					<tr>
					<td align='center' bgcolor='$color' width='080px'><font face='Verdana' size='1'><a href='justifica_personal_profes_formulari.php?idalumne=$idalumne' title='Absencies: $llista_dates' target='blank'>$alumne</a></font></td>
					<td align='center' bgcolor='$color' width='030px'><font face='Verdana' size='1'><a href='' title='Hores totals'><b>$compta_totals</b></a></font></td>
					<td align='center' bgcolor='$color' width='030px'><font face='Verdana' size='1'><a href='justifica_personal_profes_formulari.php?idalumne=$idalumne' title='Hores per absencies personals' target='blank'>$compta_faltes</a></font></td>
					<td align='center' bgcolor='$color' width='030px'><font face='Verdana' size='1'><a href='' title='Hores per absencies professionals (sortides, excursions, ...)'>$compta_sortides</a></font></td>
					<td align='center' bgcolor='$color' width='030px'><font face='Verdana' size='1'><a href='' title='Hores de retards'>$compta_retards</a></font></td>
					</tr>
					";

					$identificador=$identificador+1;				
}						
				$estat='';
				$llista_dates='/';
				
					//////////////////////////////////////////////////////////////////////////////////////////////////////
					//Afegit Juanjo, preparem els nostres arrays que necessitarem per les impressions a pdf...//
					/////////////////////////////////////////////////////////////////////////////////////////////////////
					$registres[0]=$alumne;
					$registres[1]=$compta_faltes;
					$registres[2]=$compta_justificacions;
					$registres[3]=$compta_baixes;
					$registres[4]=$compta_reunions;
					$registres[5]=$compta_permisos;
					$registres[6]=$compta_sortides;
					$registres[7]=$compta_totals;
					$totals_hores_falta=$totals_hores_falta+$compta_totals;

					foreach ( $registres as $valor){
						$registrespdf[$x][$z]=$valor;
						$z=$z+1; 
					}
		
					$x=$x+1; 
					$z=0;
		
					/////////////////////////////////////////////////////////////////////////////////////////////////
					// FI Juanjo, preparem els nostres arrays que necessitarem per les impressions a pdf...//
					////////////////////////////////////////////////////////////////////////////////////////////////		

			$compta_faltes=0;/*I*/
			$compta_justificacions=0;/*J*/	
			$compta_sortides=0;/*D*/
			$compta_baixes=0;/*B*/
			$compta_reunions=0;/*U*/
			$compta_permisos=0;/*I*/
			$compta_errors=0;/*M*/
			$compta_totals=0;/*M*/
			$compta_retards=0;/*R*/

}

$durada=time()-$abans;
echo "<br><p align='center'><font face='Verdana' size='1'><b>Trobades </b>$totals_hores_falta <b>hores d'absencia repartides entre</b> $identificador <b>professors (recerca feta en </b>$durada <b>[sg])</b></font></p><br>";

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
echo "</tbody>";
echo"</table>";
include "desconnectaBD.php";

?>

<?php

////////////////////
//Afeigt juanjo///
//////////////////

if ($numregistres > 1){ 

	?>

	<form action="impressiofaltesprofespdf.php" method="POST">
		<input type="hidden" name="llistapdf" value='<?php echo serialize($registrespdf) ?>'</input>
		<input type="submit" value="Llistar en pdf">
	</form>

<?php

}

?>

<hr><p align="center"><font face="Verdana" size="1">(c) V.L.G.A. & J.J.M.R. 2013</font></p></font></body></html>