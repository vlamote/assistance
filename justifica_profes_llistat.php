<html><head><title>JU.FA.P.</title> <script language="javascript" type="text/javascript" src="datetimepicker.js"></script></head>
<table border="0" width="100%" id="table2"><tr>
<td width="22%"><font face="Verdana" size="1"><p align="left"><b><a href="/assistencia/incidencies_profes_formulari.php">Justifica'n m�s</a></b></font></p></td>
<td width="56%"><font face="Verdana" size="1" color="red"><p align="center"><b>1. Tria grup. 2. Tria alumne. 3. Tria data. 4. Posa observacions. 5. Prem el boto</b></p></td>
<td width="22%"><font face="Verdana" size="1"><p align="right"><b>JUstificacio de FALtes Profes</b></p></font></td>
</tr></table><hr>

<?php include "connectaBD.php";include "PassaVars.php";

/***************************/
/* DEFINICIO DE VARIABLES */
/***************************/
date_default_timezone_set("Europe/Madrid");

$idalumne= $_GET["idalumne"];
$data1= $_POST["data1"];
$tipus= $_POST["tipus"];
$observacions= $_POST["observacions"];
$dataentrada1 = strtotime($data1)+7*3600;
$dataentrada2 = strtotime($data1)+21*3600;
$dataentrada11=date("d/m/y", $dataentrada1);
$dataentrada22=date("d/m/y", $dataentrada2);
$identificador=0;

if($tipus=="F"){$tipus=13;$motiu="Falta";}
if($tipus=="I"){$tipus=14;$motiu="Perm�s";}
if($tipus=="B"){$tipus=16;$motiu="Baixa";}
if($tipus=="J"){$tipus=22;$motiu="Malaltia";}
if($tipus=="M"){$tipus=88;$motiu="Error";}
if($tipus=="U"){$tipus=1395;$motiu="Reuni�";}
if($tipus=="D"){$tipus=1396;$motiu="Sortida";}

/***********************************************************************************************/
/* 1. TROBAR A 'MDL_ATTENDANCE_LOG' ELS REGISTRES ASSOCIATS A L'ACRONIM 'F' I A L'ALUMNE*/
/**********************************************************************************************/
$sql1 = "SELECT * FROM mdl_attendance_log WHERE (studentid='$idalumne') AND (statusid='13') ";
$result1=mysql_query($sql1, $conexion);
while($row1=mysql_fetch_row($result1)){

	$sessio=$row1[1];
	$id_registre=$row1[0];

	/*****************************************************************************************/
	/*2. TROBAR A 'MDL_ATTENDANCE_SESSIONS' ELS REGISTRES AMB LA 'SESSIONID' ANTERIOR*/
	/*****************************************************************************************/

	$sql2 = "SELECT * FROM mdl_attendance_sessions WHERE (id='$sessio')";
        $result2=mysql_query($sql2, $conexion);
        while($row2=mysql_fetch_row($result2)){

		$id_attendance=$row2[1];
                $dataentrada=date("d/m/y", $row2[3]);
		/*echo "trobada sessio: $dataentrada $dataentrada11<br>";*/
	}

	/******************************************************/
	/*SI LA DATA DE LA SESSIO CORRESPON A LA D'ENTRADA*/
	/******************************************************/
        
	if ($dataentrada==$dataentrada11){
	        
		/***************************************************************************/
		/*ACTUALITZO LA BASE DE DADES EL REGISTRES AMB ESTAT 'F' I POSO 'J' I 'OBS'*/
		/**************************************************************************/

		/*************************************/
		/*PER SI LA FRASE CONTE APOSTROFS*/
		/*************************************/
		$observacions=str_replace("'","`",$observacions);

   		$sql4 = "UPDATE mdl_attendance_log SET mdl_attendance_log.statusid='$tipus' WHERE (mdl_attendance_log.id='$id_registre')";
		$result4=mysql_query($sql4, $conexion);  

		$identificador=$identificador+1;		
	}
}

$identificador=$identificador;

/**************************/                          
/*ESBRINO NOM PROFE */
/*************************/   
$sql2 = "SELECT * FROM mdl_user WHERE id=$idalumne";
$result2=mysql_query($sql2, $conexion);
while($row2=mysql_fetch_row($result2)){
	$alumne=$row2[11].", ".$row2[10];
}

echo "<p align='center'><font face='Verdana' size='2'>";
echo"<b>Faltes justificades: </b>$identificador<br>";
echo"<b>Entre: </b>$dataentrada11 <b>i</b> $dataentrada22<br>" ;
echo"<b>Professor: </b> $alumne ($idalumne)<br>";
/*echo"<b>Data: </b>$dataentrada<br>" ;*/
echo"<b>Motiu: </b> $motiu<br>" ;
/*echo"<b>Observacions: </b> $observacions<br>" ;*/
echo"</font></p>";

include "desconnectaBD.php"; 

?>

<p align="center"><input type="button" value="Justifica'n m�s" onclick="window.open('justifica_formulari_profes.php')"></p>

<hr><p align="center"><font face="Verdana" size="1">(c) V.L.G.A. 2014</font></p></font></body></html>