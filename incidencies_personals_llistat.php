<html><head><title>G.R.I.AL.</title>

<LINK href="jquery/themes/blue/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="jquery/jquery-latest.js"></script>
<script type="text/javascript" src="jquery/jquery.tablesorter.js"></script>

<script type="text/javascript">

$(document).ready(function() {
$("#Incidencies").tablesorter({
sortList: [[1,0],[0,0],[2,0]]
});
});
</script>

</head><body bgcolor="#FFFFFF">

<table border="0" width="100%" id="table2"><tr>
<td width="20%"><p align="left"><font face="Verdana" size="1">Nova consulta: <a href="/assistencia/llistat_profes.php">profes</a> | <a href="/assistencia/llistat_alumnes.php">alumnes</a></td>
<td width="35%"><p align="right"><font face="Verdana" size="1" color="black" style="BACKGROUND-COLOR: white">Informa a la coordinadora de: <a href="http://iessitges.xtec.cat/message/index.php?id=2853" title="Teresa Barragan" target="blank">ESO1i2</a>, <a href="http://iessitges.xtec.cat/message/index.php?id=3239" title="Gemma Giralt" target="blank">ESO3i4</a>, <a href="/message/index.php?id=2823" title="Laia Querol" target="blank">BAT1i2</a> i <a href="http://iessitges.xtec.cat/message/index.php?id=2801" title="Anna Monasterio" target="blank">CCFF</a> | Informa al <a href="http://iessitges.xtec.cat/message/index.php?id=2845" title="Samuel Valls" target="blank">director</a></font></p> </td><td width="40%"><p align="right"><font face="Verdana" size="1"><b>Gestió Remota d'Incidències d'ALumnes (G.R.I.AL.)</b></font></p></td></tr>
</table><hr>

<?php include "connectaBD.php";include "PassaVars.php";

/**************************/
/* DEFINICIO DE VARIABLES */
/**************************/
$alumne="---";
$profe="---";
$sessio="---";
$identificador=0;
$enllas='mod/attforblock/view.php';
$sessio="---";
$assistencia="---";
$curs="---";
$nomcurs="---";
$nomgrup="---";
$cursoficial="N/A";
$grupoficial="N/A";
$comptador=0;
$LED="imatges/LED_incidencies_OFF.gif";
$idalumne= $_GET["idalumne"];
$alumid=$idalumne;

$data1= $_POST["data1"];
$data2= $_POST["data2"];
$tipus = $_POST["tipus"];
$triacurs = $_GET["triacurs"];
$triagrup = $_GET["triagrup"];

$dataentrada1= strtotime($data1);
$dataentrada2= strtotime($data2);

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

/**************************/
/* ESBRINO NOM ALUMNE */
/**************************/
$alumid=$id;
$sql2 = "SELECT * FROM mdl_user WHERE id=$alumid";
$result2=mysql_query($sql2, $conexion);
while($row2=mysql_fetch_row($result2)){
	$alumne=$row2[11].", ".$row2[10];
}

/**************************/
/*ENCAPSALAMENT DEL TITOL**/
/**************************/
echo"<p align='center'><font face='Verdana' size='1'><b>";
echo"Usuari: </b>".$alumne." (".$alumid.") ";
echo "| <b>Incidències: </b>";
if ($tipus=="T"){echo"Totes les incidències |";}
if ($tipus=="F"){echo"Faltes d'assistència |";}
if ($tipus=="R"){echo"Retards |";}
if ($tipus=="E"){echo"Expulsions |";}
if ($tipus=="S"){echo"Sancions |";}
if ($tipus=="J"){echo"Justificacions |";}
if ($tipus=="P"){echo"Observacions |";}
echo "<b> Periode: </b>";echo $data1;echo" al ";echo $data2;echo"<br>";echo"<br>";
echo"<font color='red'>Passa el ratolí per sobre del LED (<img src='$LED'>) per a veure més info i/o clica per a anar al detall.<br>L'ordenació per defecte és per alumne, per data i per incidència.<br>Pica a la capçalera que vulguis per a ordenar segons aquell criteri.";
echo"</font></p>";

/*********************************/
/*SI TRIAT TOT NO FILTRA PER GRUP*/
/*********************************/
$triacurs="Tots";
$triagrup="Tots";

?>

<!--/****************************/-->
<!--/**ENCAPSALAMENT DE LA TAULA*/-->
<!--/****************************/-->   
<div align='center'>
        <table id="Incidencies" width="400px" class="tablesorter">
		<thead>
			<tr>
            			<th width='030px' align='center'>Dia i hora</th>
            			<th width='100px' align='center'>Matèria</th>
           			<th width='100px' align='center'>Incidència</th>
			        <th width='100px' align='center'>Observacions</th>
			</tr>
		</thead>
</div>

<?php

/**********************************************************/   
/*TRIO LES SESSIONS QUE TENEN DATES ENTRE LES TRIADES */
/**********************************************************/   
$sql01 = "SELECT * FROM mdl_attendance_sessions WHERE ((sessdate>= '$dataentrada1') AND (sessdate<='$dataentrada2')) order by sessdate desc";
$result01=mysql_query($sql01, $conexion);
while($row01=mysql_fetch_row($result01)){

	$sessio=$row01[0];
	$assistencia=$row01[1];
	$grup=$row01[2];
	$datasessio=$row01[3];
	$descripcio=$row01[8];

	$dataentrada=date("Y/m/d H:i", $datasessio);
	$dataentrada2=date("Ymd H:i", $datasessio);
	$dia_entrada=date("d", $datasessio);
	$mes_entrada=date("m", $datasessio);
	$any_entrada=date("y", $datasessio);
	$hora_entrada=date("H:i", $datasessio);

	/*********************************/   
	/*MOSTRO ELS LOGS DE LA SESSIO*/
	/*********************************/   
	$sql1 = "SELECT * FROM mdl_attendance_log WHERE (sessionid= '$sessio') AND (studentid='$alumid')";
	$result1=mysql_query($sql1, $conexion);
	while($row1=mysql_fetch_row($result1)){

		/******************************/
		/*ESBRINO ESTAT D'AQUELL LOG*/
		/******************************/		
		$estat=$row1[3];

		/*************************************/
		/*ESBRINO ACRONIM D'AQUELL ESTAT*/
		/*************************************/
		$sql31 = "SELECT * FROM mdl_attendance_statuses WHERE (attendanceid='$assistencia' AND id='$estat')";
		$result31=mysql_query($sql31, $conexion);
		while($row31=mysql_fetch_row($result31)){
			$acronim=$row31[2];
		}

		$observacions="Cap observació";

		if ($row1[7]<>'') {
			$observacions=$row1[7];
		}
		else {
			$observacions="Sense observacions";
		}

		/**************************/   
		/* 3. ESBRINO NOM PROFE*/
		/**************************/   
		$sql3 = "SELECT * FROM mdl_user WHERE id=$row1[6]";
		$result3=mysql_query($sql3, $conexion);
		while($row3=mysql_fetch_row($result3)){
			$profe=$row3[11].", ".$row3[10];
		}

		/*******************************************/   
		/*ESBRINO ENLLAÇ AL MODUL ASSISTENCIA*/
		/******************************************/   

		/*!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
		/***ATENCIO QUE EN MODERNES VERSIONS DEL MODUL ATTENDANCE JA NO ES FA SERVIR EL MDL_ATTFORBLOCK SINO ATTENDANCE!!!!!!!***/
		/*!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
		$sql5 = "SELECT * FROM mdl_attforblock WHERE id=$assistencia";
		$result5=mysql_query($sql5, $conexion);
		while($row5=mysql_fetch_row($result5)){
			$curs=$row5[1];
		}

		$sql6 = "SELECT * FROM mdl_course_modules WHERE (course=$curs AND instance=$assistencia)";
		$result6=mysql_query($sql6, $conexion);
		while($row6=mysql_fetch_row($result6)){
			$enllas='http://iessitges.xtec.cat/mod/attforblock/view.php?id='.$row6[0].'&studentid='.$row1[2].'&view='."5";
		}

		/*******************/   
		/*ESBRINO EL CURS*/
		/*******************/ 
		$sql7 = "SELECT * FROM mdl_course WHERE (id=$curs)";
		$result7=mysql_query($sql7, $conexion);
		while($row7=mysql_fetch_row($result7)){
			$nomcurs=$row7[4];
		}

		/*********************/   
		/*ESBRINO EL GRUP*/           
		/**********************/   
		$sql8 = "SELECT * FROM mdl_groups WHERE (id=$grup)";
		$result8=mysql_query($sql8, $conexion);
		while($row8=mysql_fetch_row($result8)){
			$nomgrup=$row8[3];
		}

		/**************************************************************/   
		/* NOMES MOSTRA ELS REGISTRES SI PERTANYEN AL ESTAT TRIAT*/
		/*************************************************************/   
		if(
		(($tipus=="T") AND ($acronim=="P") AND ($observacions<>"Sense observacions")) OR
		(($tipus=="P") AND ($acronim=="P") AND ($observacions<>"Sense observacions")) OR
		(($tipus=="J")  AND ($acronim=="J") AND ($observacions<>"Sense observacions")) OR
		(($tipus=="E") AND ($acronim=="E") AND ($observacions<>"Sense observacions")) OR
		(($tipus=="S") AND ($acronim=="S") AND ($observacions<>"Sense observacions")) OR
		(($tipus=="P") AND ($acronim=="P") AND ($observacions<>"Sense observacions")) OR
		(($tipus=="J")  AND ($acronim=="J") AND ($observacions<>"Sense observacions")) OR
		(($tipus=="E") AND ($acronim=="E") AND ($observacions<>"Sense observacions")) OR
		(($tipus=="S") AND ($acronim=="S") AND ($observacions<>"Sense observacions")) OR
		(($tipus=="T") AND ($acronim<>"P")) OR
		(($tipus=="R") AND ($acronim=="R")) OR
		(($tipus=="F") AND ($acronim=="F")) OR
		(($tipus=="T") AND ($acronim=="I")) OR
		(($tipus=="T") AND ($acronim=="D")) OR
		(($tipus=="T") AND ($acronim=="U")) OR
		(($tipus=="T") AND ($acronim=="J")) OR
		(($tipus=="T") AND ($acronim=="B"))
		){

			/*************************************/
			/*PER SI LA FRASE CONTE APOSTROFS*/
			/*************************************/
			$observacions=str_replace("'","`",$observacions);
	
			/************************************************************/
			/*SEGONS LA INCIDENCIA ENCEN EL LED D'UN O ALTRE COLOR*/
			/************************************************************/
			if($acronim=="F"){$nom_acronim="Falta no justificada";}
			if($acronim=="J"){$nom_acronim="Falta justificada";}
			if($acronim=="R"){$nom_acronim="Retard";}
			if($acronim=="E"){$nom_acronim="Expulsio";}
			if($acronim=="S"){$nom_acronim="Sancio";}
			if($acronim=="P"){$nom_acronim="Observacions";}
			if($acronim=="U"){$nom_acronim="Reunio";}
			if($acronim=="I"){$nom_acronim="Permis";}
			if($acronim=="M"){$nom_acronim="Marcat per error";}		
			if($acronim=="D"){$nom_acronim="Sortida";}
			if($acronim=="B"){$nom_acronim="Baixa";}

			$LED="imatges/LED_incidencia_".$acronim.".gif";
			$popup="Grup: ".$nomgrup.".  Incidencia: ".$nom_acronim.". Notificada per: ".$profe;
		
			echo"                                    
			<td align='center' bgcolor='$color' width='040px'><font face='Verdana' size='1'>$dataentrada2
			<td align='center' bgcolor='$color' width='100px'><font face='Verdana' size='1'>$nomcurs
			<td align='center' bgcolor='$color' width='100px'><font face='Verdana' size='1'>$acronim <a href='$enllas' title='$popup'  target='blank'><img src='$LED'></a>
			<td align='center' bgcolor='$color' width='100px'><font face='Verdana' size='1'>$observacions
			</font></td></tr>";
	
			$estat='';
			$identificador=$identificador+1;
		
			//////////////////////////////////////////////////////////////////////////////////////////////////////
			//Afegit Juanjo, preparem els nostres arrays que necessitarem per les impressions a pdf...//
			/////////////////////////////////////////////////////////////////////////////////////////////////////
			$registres[0]=$dataentrada;
			$registres[1]=$nomcurs;
			$registres[2]=$alumne;
			$registres[3]=$acronim;
			$registres[4]=$observacions;

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
	}			
}

////////////////////////////////////////////////////////////////////////////////////
//Comprobem que tenim registres al nostre array per processar a pdf...////
/////////////////////////////////////////////////////////////////////////////////////

$numregistres=count($registrespdf);

echo "<font face='Verdana' size='1'><b>Total incidències: </b>".$identificador."</font>" ;
echo "</tbody>";
echo"</table>";include "desconnectaBD.php";

?>


<?php

////////////////////
//Afegit juanjo///
//////////////////

if ($numregistres > 1){  
//echo "El numero de registros es $numregistres";
//echo "Tengo mas registros de 1";

?>

<form action="impressiofaltespersonalspdf.php" method="POST">
<input type="hidden" name="llistapdf" value='<?php echo serialize($registrespdf) ?>'</input>
<input type="submit" value="Llistar en pdf">
</form>

<?php

}

?>

<hr><p align="center"><font face="Verdana" size="1">(c) V.L.G.A. & J.J.M.R. 2013</font></p></font></body></html>