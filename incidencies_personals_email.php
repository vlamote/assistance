<html><head><title>ENV.I.DI.A.</title></head><body bgcolor="#FFFFFF">

<?php include "connectaBD.php";include "PassaVars.php";include "connectaMAIL.php";

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
$data1= $_GET["data1"];
$data2= $_GET["data2"];
$tipus = "T";
$triacurs = "Tots";
$triagrup = "Tots";
$dataentrada1= strtotime($data1);
$dataentrada2= strtotime($data2);
$abans=time();

/************************************/
/**MIRA UNA SETMANA ENDARRERA**/
/*CAL UN CRONTAB QUE HO EXECUTI*/
/****CADA DIVENDRES A LES 23:00***/
/**********************************/
if ($data1=="" AND $data2==""){
	$dataentrada1=time()-518400;
	$data1=date("d-m-y",$dataentrada1);
	$dataentrada2=time();
	$data2=date("d-m-y",$dataentrada2);
}

/**************************/
/*ENCAPSALAMENT DEL TITOL**/
/**************************/
echo"<p align='center'><font face='Verdana' size='1'><b>Totes les incidencies del periode: </b>";
echo $data1;
echo" al ";
echo $data2;
echo"<br></font></p>";

/************************************/
/********PER A CADA USUARI********/
/* ESBRINO NOM I CORREU ALUMNE */
/**********************************/
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
	$sql01 = "SELECT * FROM mdl_attendance_sessions WHERE ((sessdate>= '$dataentrada1') AND (sessdate<='$dataentrada2')) order by sessdate desc";
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
			
				echo"$alumne $dataentrada $nomcurs $acronim <img src='$LED'></a>$observacions<br>";
	
				$estat='';
				$identificador=$identificador+1;
			}
		}			
	}
}

$durada=time()-$abans;
echo "<br><p align='center'><font face='Verdana' size='1'>Durada de la recerca: $durada <b>[sg]</b></font></p><br>";

include "desconnectaBD.php"; ?>

</body></html>