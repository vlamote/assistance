<html><head><title>JU.FAL.O.</title> <script language="javascript" type="text/javascript" src="datetimepicker.js"></script></head>
<table border="0" width="100%" id="table2"><tr>
<td width="22%"><font face="Verdana" size="1"><p align="left"><b><a href="/assistencia/justifica_formulari_profes.php">Justifica'n més</a></b></font></p></td>
<td width="56%"><font face="Verdana" size="1" color="red"><p align="center"><b>1. Tria grup. 2. Tria alumne. 3. Tria data. 4. Posa observacions. 5. Prem el boto</b></p></td>
<td width="22%"><font face="Verdana" size="1"><p align="right"><b>JUstificacio de FALtes Online</b></p></font></td>
</tr></table><hr>

<?php include "connectaBD.php";include "PassaVars.php";

/***************************/
/* DEFINICIO DE VARIABLES */
/***************************/
$idalumne= $_POST["idalumne"];
$data1= $_POST["data1"];
$tipus= $_POST["tipus"];
$observacions= $_POST["observacions"];
$dataentrada1 = strtotime($data1)+7*3600;
$dataentrada2 = strtotime($data1)+21*3600;
$dataentrada11=date("d/m/y", $dataentrada1);
$dataentrada22=date("d/m/y", $dataentrada2);
$identificador=0;

if($tipus=="I"){$tipus=14;}
if($tipus=="B"){$tipus=16;}
if($tipus=="J"){$tipus=22;}
if($tipus=="M"){$tipus=88;}
if($tipus=="U"){$tipus=1395;}
if($tipus=="D"){$tipus=1396;}

/**************************/
/*ESBRINO NOM ALUMNE */
/*************************/
$sql2 = "SELECT * FROM mdl_user WHERE id=$idalumne";
$result2=mysql_query($sql2, $conexion);
while($row2=mysql_fetch_row($result2)){
	$alumne=$row2[11].", ".$row2[10];
}

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
	}

	/******************************************************/
	/*SI LA DATA DE LA SESSIO CORRESPON A LA D'ENTRADA*/
	/******************************************************/
        
	if ($dataentrada==$dataentrada11){
	        
		/***************************************************************************/
		/*ACTUALITZO LA BASE DE DADES EL REGISTRS AMB ESTAT 'F' I POSO 'J' I 'OBS'*/
		/**************************************************************************/

		/*************************************/
		/*PER SI LA FRASE CONTE APOSTROFS*/
		/*************************************/
		$observacions=str_replace("'","`",$observacions);

   		$sql4 = "UPDATE mdl_attendance_log SET mdl_attendance_log.statusid='$tipus', mdl_attendance_log.remarks='$observacions' WHERE (mdl_attendance_log.id='$id_registre')";
		$result4=mysql_query($sql4, $conexion);  

		$identificador=$identificador+1;		
	}
}

$identificador=$identificador;

echo "<p align='center'><font face='Verdana' size='2'>";
echo"<b>Faltes justificades: </b>$identificador<br>";
echo"<b>Professor: </b> $alumne ($idalumne)<br>";
echo"<b>Data: </b>$dataentrada<br>" ;
echo"<b>Motiu: </b> $tipus<br>" ;
echo"<b>Observacions: </b> $observacions<br>" ;
echo"</font></p>";

include "desconnectaBD.php"; 

?>

<p align="center"><input type="button" value="Justifica'n més" onclick="window.open('justifica_formulari_profes.php')"></p>

<hr><p align="center"><font face="Verdana" size="1">(c) V.L.G.A. 2014</font></p></font></body></html>