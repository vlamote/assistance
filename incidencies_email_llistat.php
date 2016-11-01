<html>
	<head>
		<title>ENVI.DI.A.</title>
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
				<td width="10%"><p align="left"><font face="Verdana" size="1"><a href="/assistencia/justifica_profes_formulari.php"></a></td>
				<td width="65%"><p align="center"><font face="Verdana" size="1" color="black">ENVIament DIgital d'Assistències</font></p></td>
				<td width="30%"><p align="right"><font face="Verdana" size="1"><b>ENVI.DI.A.</b></font></p></td>
			</tr>
		</table>
		<hr>

<?php include "connectaBD.php";include "PassaVars.php";include "connectaMAIL.php";require_once ('../config.php');

/**************************/
/* DEFINICIO DE VARIABLES */
/**************************/
global $USER;
$userid=$USER->id;
$alumne="---";
$profe="---";
$sessio="---";
$identificador=1;
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
$data1= $_POST["data1"];
$data2= $_POST["data2"];
$tipus = "T";
$triacurs = "Tots";
$triagrup = "Tots";
$dataentrada1= strtotime($data1);
$dataentrada2= strtotime($data2);
$abans=time();
$cos_email="";
$correus_ok=0;
$correus_ko=0;

/************************************/
/**MIRA UNA SETMANA ENDARRERA**/
/*CAL UN CRONTAB QUE HO EXECUTI*/
/****CADA DIVENDRES A LES 22:00***/
/**********************************/
/*
if ($data1=="" AND $data2==""){
	$dataentrada1=time()-518400;
	$data1=date("d-m-y",$dataentrada1);
	$dataentrada2=time();
	$data2=date("d-m-y",$dataentrada2);
}
*/

/************************************/
/******MIRA UN DIA ENDARRERA*****/
/*CAL UN CRONTAB QUE HO EXECUTI*/
/********CADA DIA A LES 22:00******/
/**********************************/
if ($data1=="" AND $data2==""){
	$dataentrada1=time()-86400;
	$data1=date("d-m-y",$dataentrada1);
	$dataentrada2=time();
	$data2=date("d-m-y",$dataentrada2);
}

/**************************/
/*ENCAPSALAMENT DEL TITOL**/
/**************************/
echo "<p align='center'><font face='Verdana' size='1'><b>Missatge MERAMENT INFORMATIU.<br>NO el contesteu. El genera automàticament el sistema.<br>Si teniu comentaris adreceu-vos al tutor.<br>Incidències del periode: </b>";
echo $data1." al ".$data2;
echo"<br></font></p>";

/**********************************************/
/*PER A CADA USUARI ESBRINO NOM I CORREU */
/*********************************************/

$sql2 = "SELECT * FROM mdl_user WHERE deleted='0' AND suspended='0' AND confirmed='1' ORDER BY lastname ASC";
$result2=mysql_query($sql2, $conexion);
while($row2=mysql_fetch_row($result2)){

	$alumid=$row2[0];
	$alumne=$row2[11].", ".$row2[10];
	$correu=$row2[12];

	/*********************************/
	/*SI TRIAT TOT NO FILTRA PER GRUP*/
	/*********************************/
	$triacurs="Tots";
	$triagrup="Tots";
	
	/**********************************************************/   
	/*TRIO LES SESSIONS QUE TENEN DATES ENTRE LES TRIADES */
	/**********************************************************/   
	$sql01 = "SELECT * FROM mdl_attendance_sessions WHERE ((sessdate>= '$dataentrada1') AND (sessdate<='$dataentrada2')) order by sessdate asc";
	$result01=mysql_query($sql01, $conexion);
	while($row01=mysql_fetch_row($result01)){
	
		$sessio=$row01[0];
		$assistencia=$row01[1];
		$grup=$row01[2];
		$datasessio=$row01[3];
		$descripcio=$row01[8];
		$dataentrada=date("d-m-y H:i", $datasessio);

		/*********************************/   
		/*MOSTRO ELS LOGS DE LA SESSIO*/
		/*********************************/   
		$sql1 = "SELECT * FROM mdl_attendance_log WHERE ((sessionid= '$sessio') AND (studentid='$alumid')) order by id asc";
		$result1=mysql_query($sql1, $conexion);
		while($row1=mysql_fetch_row($result1)){
	
			/******************************/
			/*ESBRINO ESTAT D'AQUELL LOG*/
			/******************************/		
			$estat=$row1[3];
			$numero_log=$row1[0];

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
	
			/*!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
			/***ATENCIO QUE EN MODERNES VERSIONS DEL MODUL ATTENDANCE JA NO ES FA SERVIR EL MDL_ATTFORBLOCK SINO ATTENDANCE!!!!!!!***/
			/*!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
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
			(($tipus=="E")  AND ($acronim=="E") AND ($observacions<>"Sense observacions")) OR
			(($tipus=="S")  AND ($acronim=="S") AND ($observacions<>"Sense observacions")) OR
			(($tipus=="P")  AND ($acronim=="P") AND ($observacions<>"Sense observacions")) OR
			(($tipus=="J")  AND ($acronim=="J") AND ($observacions<>"Sense observacions")) OR
			(($tipus=="E")  AND ($acronim=="E") AND ($observacions<>"Sense observacions")) OR
			(($tipus=="S")  AND ($acronim=="S") AND ($observacions<>"Sense observacions")) OR
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
	
				/********************/
				/*NOM INCIDENCIA*/
				/******************/
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

				$nova_incidencia="<font face='Verdana' size='2'>$identificador: $nom_acronim ($observacions) el $dataentrada ($numero_log) a $nomcurs $alumne<hr></font><br>";
				$cos_email=$cos_email.$nova_incidencia;
				$estat='';
				$identificador=$identificador+1;
			}
		}			
	}

	/**********************/
	/*ENVIAMENT EMAILS*/
	/*********************/

	/******************/
	/****  NETEJA     ***/
	/*****************/
	$mail->ClearAddresses();
	
	/********************/
	/*CONFIGURA DESTÍ*/
	/*******************/
	$mail->AddAddress($correu);
	
	/******************/
	/*CREA MISSATGE*/
	/*****************/
	$mail->Subject = "Missatge automàtic MERAMENT informatiu (Excepte per a CCFF). NO EL CONTESTEU. Si teniu comentaris ADRECEU-VOS AL TUTOR";
	$mail->Body = $cos_email;
	$mail->AltBody = "Resum Incidencies Setmanals";
	
	/*****************************/
	/*MOSTRA - ENVIA MISSATGE*/
	/***************************/
	echo $cos_email;

	/****************************/
	/*SI EL MISSATGE NO ES BUIT*/
	/***************************/
	if ($mail->Body<>"" ){

		/****************/
		/*ENVIA CORREU*/
		/****************/
		if($mail->Send())
		{
			/***********************/
			/*MOSTRA MISSATGE OK*/
			/***********************/
			echo "CORREU ENVIAT CORRECTAMENT";
			$correus_ok=$correus_ok+1;
		}
		/*******/
		/*SI NO*/
		/*******/
		else
		{
			/***********************/
			/*MOSTRA MISSATGE KO*/
			/***********************/
			echo "<br>CORREU ENVIAT INCORRECTAMENT: ".$mail->ErrorInfo;
			$correus_ko=$correus_ko+1;
		}

	/***********************/
	/*NETEJA INFO USUARI*/
	/**********************/
	$cos_email="";	
	$identificador=1;
	}
}

/*******************/
/*LOG ENVIAMENT*/
/******************/
$durada=time()-$abans;
echo "<br><p align='center'><font face='Verdana' size='1'>Durada del procés: <b>$durada</b> [sg] | Correus OK: $correus_ok | Correus KO: $correus_ko</font></p><br>";

/**************ENVIA MISSATGE DE RESUM AL GESTOR********************/
	$mail->ClearAddresses();
	$mail->AddAddress("vlamote@gmail.com");
	$mail->Subject = "Resum Incidencies Setmanals";
	$cos_email="Durada del procés: <b>".$durada."</b> [sg] | Correus OK: ".$correus_ok." | Correus KO: $correus_ko";
	$mail->Body = $cos_email;
	$mail->AltBody = "Resum Incidencies Setmanals";
	if ($mail->Body<>"" ){
		if($mail->Send())
		{
			echo "CORREU ENVIAT CORRECTAMENT AL GESTOR";
		}
		else
		{
			echo "<br>CORREU ENVIAT INCORRECTAMENT AL GESTOR: ".$mail->ErrorInfo;
		}
		$cos_email="";	
		$identificador=1;
	}

/********************************************************************************/

include "desconnectaBD.php"; ?>
<hr><p align="center"><font face="Verdana" size="1">(c) V.L.G.A. & J.J.M.R. 2015</font></p></font></body></html>