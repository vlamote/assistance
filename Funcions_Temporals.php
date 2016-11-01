<?php

include "connectaBD.php";
include "PassaVars.php";

/*PER A NO TENIR PROBLEMES AMB CARACTERS ESTRANYS*/
mysql_query("SET NAMES 'utf8'");
header("Content-Type: text/html;charset=utf-8");

/**********************/
/*INICI I FINAL DE CURS*/
/**********************/
$Primer_Dia_Curs=12;
$Darrer_Dia_Curs=2;

/*******************************/
/*DADES DEL CREDIT DE SINTESI*/
/******************************/
$DIES_CS=4;
$HORES_CS=3;
$AULES_DISPONIBLES=3;

/*******************************************/
/*MATRIU QUE CONTÉ ELS FESTIUS DEL CURS*/
/*S'EMPRA ALS FITXERS:                                             */
/*CREA_HORARI_PROPI_LLISTAT.PHP,               */
/*CREA_HORARI_PROFE_LLISTAT.PHP,              */
/*ESBORRA_HORARI_PROPI_LLISTAT.PHP,    */
/*ESBORRA_HORARI_PROFE_LLISTAT.PHP,   */
/*****************************************/
function EsFestiu($d,$m,$a){

	/*CREO DIA*/
	$Dia_Analitzat=$d.$m.$a;
	$Es_Festiu=FALSE;

	/*LLISTAT FESTIUS*/
	$Llistat_Festius = array(

		/*DIADA*/
		"110916",
		
		/*LLIURE DISPOSICIÓ*/
		"230916",

		/*EL PILAR*/
		"121016",

		/*TOTS SANTS*/
		"311016",
		"011116",

		/*CONSTITUCIO*/
		"051216",
		"061216",
		"081216",

		/*NADAL*/
		"231216",
		"241216",
		"251216",
		"261216",
		"271216",
		"281216",
		"291216",
		"301216",
		"311216",
		"010117",
		"020117",
		"030117",
		"040117",
		"050117",
		"060117",
		"070117",
		"080117",

		/*CARNAVAL*/
		"270217",
		"280217",

		/*SETMANA SANTA*/
		"080417",
		"090417",
		"100417",
		"110417",
		"120417",
		"130417",
		"140417",
		"150417",
		"160417",
		"170417",

		/*DIA DEL TREBALL*/
		"010517",

		/*SANT JOAN*/
		"240617"
	);

	/*COMPTO FESTES*/
	$voltes=count($Llistat_Festius);

	/*REVISO TOTES LES FESTES*/
	for($volta = 0; $volta <=$voltes; $volta++){
		if($Llistat_Festius[$volta]==$Dia_Analitzat){
			$Es_Festiu=TRUE;
		};
	};
	return($Es_Festiu);
}

/*PER A NO TENIR PROBLEMES AMB CARACTERS ESTRANYS*/
header("Content-Type: text/html;charset=utf-8");

/****************************************/
/*FUNCIO QUE RETORNA EL DIA DEL MES*/
/* QUE ES EL DARRER DISSABTE DEL MES*/
/**************************************/

function DarrerDissabteMes($m,$a){

	/*Primer possible darrer dissabte del mes*/
	$j=25;

	/*Fes fins al dia 31*/
	do
	{
		/*Crea data*/
		$k=mktime(0,0,0,$m,$j,$a);

		/*Mira dia setmana de la data*/
		$l=date("w",$k);

		/*És dissabte?*/
		if($l==6){
			$q=$j;
		};

		/*Agafa dia següent*/
		$j=$j+1;

	} while ($j<32);

	/*Retorna dia mes*/
	return $q;
}

/********************************************/
/*FUNCIO QUE PASSA UNA HORA EN FORMAT */
/* SEXAGESSIMAL A FORMAT DECIMAL                */
/*                             DE 13:22 A 13,367                             */
/********************************************/

function Sexa2Dec($h){

//TREC ELS DOS PUNTS A L'HORA (1322)
$temps_sexa = str_replace(":","",$h);
//echo $temps_sexa;echo "<br>";

//DIVIDEIXO PER CENT PER A SABER L'HORA (13,22)
$temps=$temps_sexa/100;
//echo $temps;echo "<br>";

//TREC L'HORA SENCERA (13)
$hora_sencera=intval($temps);
//echo $hora_sencera;echo "<br>";

//TREC MINUTS SENCERS (22)
$minuts_sencers=$temps_sexa-$hora_sencera*100;
//echo $minuts_sencers;echo "<br>";

//ESBRINO MINUTS EN DECIMAL (0,367)
$minuts_dec=$minuts_sencers/60;
//echo $minuts_dec;echo "<br>";

//ELS SUMO A L'HORA (13,367)
$hora_dec=$hora_sencera+$minuts_dec;
//echo $hora_dec;echo "<br>";

return $hora_dec;
}

/***************************/
/*FUNCIO QUE RETORNA      */
/*SEGONS EL PARAMETRE j:*/
/*0: DESCRIPCIO                         */
/*1: TIMBRE1                                */
/*2: INICI CLASSE                       */
/*3: FINAL CLASSE                    */
/* DE L'HORA PASSADA EN  */
/*EL PARAMETRE i (0 a 14)  */
/*************************/

/*ATENCIÓ! TAMBÉ CALDRÀ CANVIAR EL MARC HORARI A SOGRA*/
/*http://iessitges.xtec.cat/admin/settings.php?section=blocksettingmrbs*/

function MarcHorari($i,$j){

	$marc_horari = array(
		array("Mati:   Hora 1",Sexa2Dec("08:25"),Sexa2Dec("08:29"),Sexa2Dec("09:22")),
		array("Mati:   Hora 2",Sexa2Dec("09:22"),Sexa2Dec("09:26"),Sexa2Dec("10:19")),
		array("Mati:   Pati 1",	Sexa2Dec("10:19"),Sexa2Dec("10:19"),Sexa2Dec("10:44")),
		array("Mati:   Hora 3",Sexa2Dec("10:44"),Sexa2Dec("10:48"),Sexa2Dec("11:41")),
		array("Mati:   Hora 4",Sexa2Dec("11:41"),Sexa2Dec("11:45"),Sexa2Dec("12:38")),
		array("Mati:   Pati 2",	Sexa2Dec("12:38"),Sexa2Dec("12:38"),Sexa2Dec("13:03")),
		array("Mati:   Hora 5",Sexa2Dec("13:03"),Sexa2Dec("13:07"),Sexa2Dec("13:59")),
		array("Mati:   Hora 6",Sexa2Dec("13:59"),Sexa2Dec("14:03"),Sexa2Dec("14:55")),
		array("Tarda: Hora 1",Sexa2Dec("15:00"),Sexa2Dec("15:04"),Sexa2Dec("15:58")),
		array("Tarda: Hora 2",Sexa2Dec("15:58"),Sexa2Dec("16:02"),Sexa2Dec("16:56")),
		array("Tarda: Hora 3",Sexa2Dec("16:56"),Sexa2Dec("17:00"),Sexa2Dec("17:54")),
		array("Tarda: Pati",	Sexa2Dec("17:54"),Sexa2Dec("18:24"),Sexa2Dec("18:29")),
		array("Tarda: Hora 4",Sexa2Dec("18:29"),Sexa2Dec("18:29"),Sexa2Dec("19:23")),
		array("Tarda: Hora 5",Sexa2Dec("19:23"),Sexa2Dec("19:27"),Sexa2Dec("20:21")),
		array("Tarda: Hora 6",Sexa2Dec("20:21"),Sexa2Dec("20:25"),Sexa2Dec("21:18"))
	);
	
	$resultat=$marc_horari[$i][$j];
	return $resultat;
}

/***************************/
/*FUNCIO QUE RETORNA      */
/*SEGONS EL PARAMETRE j:*/
/*0: DESCRIPCIO				*/
/*1: PRIMER DIA CS                    */
/*2: SEGON DIA CS                   */
/*3: TERCER DIA CS                    */
/*4: QUART DIA CS                    */
/*5: INICI CLASSE                     */
/*6: FI CLASSE                          */
/* DE L'HORA PASSADA EN  */
/*EL PARAMETRE i (0 a 2)  */
/*************************/

function MarcHorariCS($i,$j){

	$marc_horari_CS = array(
		array("Mati:   Hora 1","6","7","8","9","09:00","10:00"),
		array("Mati:   Hora 2","6","7","8","9","10:00","11:00"),
		array("Mati:   Hora 3","6","7","8","9","11:30","13:00")
	);
	
	$resultat=$marc_horari_CS[$i][$j];
	return $resultat;
}

/**********************************/
/*FUNCIO QUE RETORNA EL PROFE*/
/*QUE HA RESERVAT*/
/*L'AULA $aula EL DIA $dia1*/
/*A L'HORA $hora*/
/*ON $hora VA DE 0 A 15*/
/**********************************/

function Professor_Reserva($dia1,$dia2,$aula,$hora){

	$sql555 = "SELECT * FROM mdl_block_mrbs_entry WHERE ((start_time>='$dia1') AND (end_time<='$dia2') AND (room_id='$aula')) ORDER BY start_time";
	$result555=mysql_query($sql555, $conexion);
	while($row555=mysql_fetch_row($result555)){
	
		$ID_sessio=$row555[0];
		$hora_sessio=$row555[1];
		$hora_sessio1=date("d/m/y h:i a", $hora_sessio);
		$hora_sessio2=$row555[2];
		$hora_sessio3=date("h:i a", $hora_sessio2);
		$profe=$row555[8];
		$descripcio=$row555[10];
		$tipus=$row555[9];
		$auleta=$row555[5];

		/*SEGONS EL TIPUS AJUSTO UN COLOR DE LA CEL:LA*/
		/*LILA*/			if ($tipus=='A'){$color_cursDl15="#D698E7";}
		/*BLAUET*/		if ($tipus=='B'){$color_cursDl15="#98A9E7";}
		/*BLAU CLAR*/	if ($tipus=='C'){$color_cursDl15="#98D9E7";}
		/*VERD CLAR*/	if ($tipus=='D'){$color_cursDl15="#49F28D";}
		/*GROGUET*/		if ($tipus=='E'){$color_cursDl15="#D9E798";}
		/*SEPIA*/			if ($tipus=='F'){$color_cursDl15="#E7C598";}
		/*ROGET*/		if ($tipus=='G'){$color_cursDl15="#EAAD34";}
		/*GROC*/			if ($tipus=='H'){$color_cursDl15="#EAE734";}
		/*VERD*/			if ($tipus=='I'){$color_cursDl15="#43EA34";}
		/*BLAU*/			if ($tipus=='J'){$color_cursDl15="#34B0EA";}

		$minutet=date("i", $hora_sessio);
		if ($minutet==$hora){return $profe;}
	}
}

?>
