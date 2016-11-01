<html><head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<title>C.HO.P.</title> <script language="javascript" type="text/javascript" src="datetimepicker.js"></script></head>
<table border="0" width="100%" id="table2">
<tr>
<td width="28%"><font face="Verdana" size="1">
<a href="http://iessitges.xtec.cat/assistencia/crea_horari_propi_formulari.php" title="Crea les teves sessions d'horari">Crea</a> | 
<a href="http://iessitges.xtec.cat/assistencia/edita_horari_propi_formulari.php" title="Modifica dia, hora, aula o dates de les teves sessions d'horari">Edita</a> | 
<a href="http://iessitges.xtec.cat/assistencia/esborra_horari_propi_formulari.php" title="Esborra les teves sessions d'horari">Esborra</a> | 
<a href="http://iessitges.xtec.cat/assistencia/horari_profe_formulari.php" title="Comprova com queden les teves sessions d'horari" target="_blank">Revisa</a>
</font></td>
<td width="54%"><font face="Verdana" size="1" color="red"><p align="left"><b>1. Tria materia i grup 2. Tria dia 3. Tria hora 4. Tria durada 5. Tria aula 6. Prem el boto</b></p></td>
<td width="18%"><font face="Verdana" size="1"><p align="right"><b>Crea't l'HOrari Propi</b></p></font></td>
</tr>
</table>
<hr>

<?php include "connectaBD.php";
mysql_query("SET NAMES 'utf8'");
include "PassaVars.php";
include "Funcions_Temporals.php";

/*PER A NO TENIR PROBLEMES AMB CARACTERS ESTRANYS*/
header("Content-Type: text/html;charset=utf-8");

/*******************CONTROL DE ACCES INICI********************************************************/
require_once ('../config.php');
global $USER;
$userid=$USER->id;
if(!isloggedin()){
header('Location: http://iessitges.xtec.cat/login/index.php?id=284'); }
else {
	$idprofe=0;

	/*****************************************************/
	/*COHORTS DE TUTORS: 35 36 37 38 39 40 41 42  83 84 85*/
	/*COHORT DE COORDINADORS: 44*/
	/*COHORT DE PROFESSORS: 43*/
	/*COHORT DE DIRECCIO: 45*/
	/*****************************************************/

	$sql = "SELECT * FROM mdl_cohort_members WHERE ((userid='$userid') AND ((cohortid=43) OR (cohortid=44) OR (cohortid=45) OR (cohortid=59)))";
	$result=mysql_query($sql, $conexion);
	while($row=mysql_fetch_row($result)){
		$idprofe=$row[0];
            }

	if (($userid==7) OR (($userid <> 1) AND ($idprofe <> 0))){
/***************************************************************************************************/

$idalumne=$userid;
$id1=$_POST["id1"];
$ID_assistencia=$_POST["ID_assistencia"];
$ID_grup=$_POST["ID_grup"];
$dia=$_POST["dia"];
$hora=$_POST["hora"];

//SI VOLEM CREAR HORARI PERSONALITZAT
$data1=$_POST["data1"];
$data2=$_POST["data2"];
$data_entrada= strtotime($data1);
$data_sortida= strtotime($data2);

/*MARC HORARI*/

/*CREEM MATRIUS AMB EL MARC HORARI*/

/***************************/
/*MarcHorari($i,$j)                   */
/*FUNCIO QUE RETORNA      */
/*SEGONS EL PARAMETRE j:*/
/*0: DESCRIPCIO                         */
/*1: TIMBRE1                                */
/*2: INICI CLASSE                       */
/*3: FINAL CLASSE                    */
/* DE L'HORA PASSADA EN  */
/*EL PARAMETRE i (0 a 14)  */
/*************************/
$Marc_Horari_Hores=               array(MarcHorari(0,2),MarcHorari(1,2),MarcHorari(2,2),MarcHorari(3,2),MarcHorari(4,2),MarcHorari(5,2),MarcHorari(6,2),MarcHorari(7,2),MarcHorari(8,2),MarcHorari(9,2),MarcHorari(10,2),MarcHorari(11,2),MarcHorari(12,2),MarcHorari(13,2),MarcHorari(14,2));
$Marc_Horari_Durades=          array(60*(MarcHorari(0,3)-MarcHorari(0,2)),60*(MarcHorari(1,3)-MarcHorari(1,2)),60*(MarcHorari(2,3)-MarcHorari(2,2)),60*(MarcHorari(3,3)-MarcHorari(3,2)),60*(MarcHorari(4,3)-MarcHorari(4,2)),60*(MarcHorari(5,3)-MarcHorari(5,2)),60*(MarcHorari(6,3)-MarcHorari(6,2)),60*(MarcHorari(7,3)-MarcHorari(7,2)),60*(MarcHorari(8,3)-MarcHorari(8,2)),60*(MarcHorari(9,3)-MarcHorari(9,2)),60*(MarcHorari(10,3)-MarcHorari(10,2)),60*(MarcHorari(11,3)-MarcHorari(11,2)),60*(MarcHorari(12,3)-MarcHorari(12,2)),60*(MarcHorari(13,3)-MarcHorari(13,2)),60*(MarcHorari(14,3)-MarcHorari(14,2)));

if($hora=="HM1"){$durada=$Marc_Horari_Durades[0];}
if($hora=="HM2"){$durada=$Marc_Horari_Durades[1];}
if($hora=="PM1"){$durada=$Marc_Horari_Durades[2];}
if($hora=="HM3"){$durada=$Marc_Horari_Durades[3];}
if($hora=="HM4"){$durada=$Marc_Horari_Durades[4];}
if($hora=="PM2"){$durada=$Marc_Horari_Durades[5];}
if($hora=="HM5"){$durada=$Marc_Horari_Durades[6];}
if($hora=="HM6"){$durada=$Marc_Horari_Durades[7];}
if($hora=="HT1"){$durada=$Marc_Horari_Durades[8];}
if($hora=="HT2"){$durada=$Marc_Horari_Durades[9];}
if($hora=="HT3"){$durada=$Marc_Horari_Durades[10];}
if($hora=="PT1"){$durada=$Marc_Horari_Durades[11];}
if($hora=="HT4"){$durada=$Marc_Horari_Durades[12];}
if($hora=="HT5"){$durada=$Marc_Horari_Durades[13];}
if($hora=="HT6"){$durada=$Marc_Horari_Durades[14];}

/*SEGONS L'HORA DE LA SESSIO -08:25, 09:23, ... - POSO L'HORA DE RESERVA A 12:00, 12:01, 12:02... AIXI DE RARO FUNCIONA EL PROGRAMA BLOCK_MRBS DE DAVO SMITH*/

if($hora=="HM1"){$minut_reserva='00';}
if($hora=="HM2"){$minut_reserva='01';}
if($hora=="PM1"){$minut_reserva='02';}
if($hora=="HM3"){$minut_reserva='03';}
if($hora=="HM4"){$minut_reserva='04';}
if($hora=="PM2"){$minut_reserva='05';}
if($hora=="HM5"){$minut_reserva='06';}
if($hora=="HM6"){$minut_reserva='07';}
if($hora=="HT1"){$minut_reserva='08';}
if($hora=="HT2"){$minut_reserva='09';}
if($hora=="HT3"){$minut_reserva='10';}
if($hora=="PT1"){$minut_reserva='11';}
if($hora=="HT4"){$minut_reserva='12';}
if($hora=="HT5"){$minut_reserva='13';}
if($hora=="HT6"){$minut_reserva='14';}

if($hora=="HM1"){$hora=$Marc_Horari_Hores[0];}
if($hora=="HM2"){$hora=$Marc_Horari_Hores[1];}
if($hora=="PM1"){$hora=$Marc_Horari_Hores[2];}
if($hora=="HM3"){$hora=$Marc_Horari_Hores[3];}
if($hora=="HM4"){$hora=$Marc_Horari_Hores[4];}
if($hora=="PM2"){$hora=$Marc_Horari_Hores[5];}
if($hora=="HM5"){$hora=$Marc_Horari_Hores[6];}
if($hora=="HM6"){$hora=$Marc_Horari_Hores[7];}
if($hora=="HT1"){$hora=$Marc_Horari_Hores[8];}
if($hora=="HT2"){$hora=$Marc_Horari_Hores[9];}
if($hora=="HT3"){$hora=$Marc_Horari_Hores[10];}
if($hora=="PT1"){$hora=$Marc_Horari_Hores[11];}
if($hora=="HT4"){$hora=$Marc_Horari_Hores[12];}
if($hora=="HT5"){$hora=$Marc_Horari_Hores[13];}
if($hora=="HT6"){$hora=$Marc_Horari_Hores[14];}

$hora=$hora*3600;
$durada_sg=$durada*60;
$ID_aula=$_POST["ID_aula"];
$ara=time();
$N=1;

/*ESBRINO NOM PROFE*/
$sql2 = "SELECT * FROM mdl_user WHERE id=$idalumne";
$result2=mysql_query($sql2, $conexion);
while($row2=mysql_fetch_row($result2)){
	
	$nom_alumne=$row2[11].", ".$row2[10];
	$nick_name=$row2[7];
}

/*ESBRINO CURS A PARTIR DE LA INSTANCIA ASSISTENCIA*/
$sql31 = "SELECT * FROM mdl_attforblock WHERE (id='$ID_assistencia')";
$result31=mysql_query($sql31, $conexion);
while($row31=mysql_fetch_row($result31)){

	$ID_curs=$row31[1];
}

/*ESBRINO NOM DEL CURS*/
$sql3 = "SELECT * FROM mdl_course WHERE (id='$ID_curs' AND visible='1') ORDER BY shortname ASC";
$result3=mysql_query($sql3, $conexion);
while($row3=mysql_fetch_row($result3)){
		
	$nom_curs=$row3[4];
	$nom_llarg_curs=$row3[3];
}

/*ESBRINO NOM DEL GRUP*/
$sql32 = "SELECT * FROM mdl_groups WHERE id='$ID_grup'";
$result32=mysql_query($sql32, $conexion);
while($row32=mysql_fetch_row($result32)){
		
	$nom_grup="Grup: ".$row32[3];
}

$sql33="SELECT * FROM mdl_block_mrbs_room WHERE id='$ID_aula'";
$result33=mysql_query($sql33, $conexion);
while($row33=mysql_fetch_row($result33)){

	$ID_area="$row33[1]";
	$nom_sala="$row33[2]";
	$nom_sala2="$row33[3]";
}

//SI NO S'HA POSAT DATA
if($data_entrada<($ara-31104000)){

//CREA HORARI ANUAL
$any_ara=date("y",$ara);
$mes_ara=9;
$dia_ara=$Primer_Dia_Curs;
$data_inici=mktime(0,0,0,$mes_ara,$dia_ara,$any_ara)+$hora;
$any_fi=date("y",$ara)+1;
$mes_fi=6;
$dia_fi=$Darrer_Dia_Curs;
$data_fi=mktime(0,0,0,$mes_fi,$dia_fi,$any_fi)+$hora;
}

//SI HA POSAT DATA
else{

//CREA HORARI PERSONALITZAT
$data_inici=$data_entrada+$hora;
$data_fi=$data_sortida+$hora;
}

$format_descripcio=1;

/* QUIN ZZZ DIA DE LA SETMANA ES EL PRIMER DIA DE CLASSE D'AQUEST ANY 20XX*/
$dia_setmana=date("w",$data_inici);
$dies_repeticio="0000000";
/*SI EL 01/10/20XX ES DL I EL DIA TRIAT ES DL, EL NOSTRE DIA PER A CREAR LA SESSIO ES ZZZ*/
if (($dia_setmana=='1') AND ($dia=='1')) {$dia_inici=$data_inici+(0*24*3600);$dies_repeticio="0100000";}
/*SI EL 01/10/20XX ES DM I EL DIA TRIAT ES DL, EL NOSTRE DIA PER A CREAR LA SESSIO ES ZZZ+(6*24*3600)*/
if (($dia_setmana=='2') AND ($dia=='1')) {$dia_inici=$data_inici+(6*24*3600);$dies_repeticio="0100000";}
/*SI EL 01/10/20XX ES DX I EL DIA TRIAT ES DL, EL NOSTRE DIA PER A CREAR LA SESSIO ES ZZZ+(5*24*3600)*/
if (($dia_setmana=='3') AND ($dia=='1')) {$dia_inici=$data_inici+(5*24*3600);$dies_repeticio="0100000";}
/*SI EL 01/10/20XX ES DJ I EL DIA TRIAT ES DL, EL NOSTRE DIA PER A CREAR LA SESSIO ES ZZZ+(4*24*3600)*/
if (($dia_setmana=='4') AND ($dia=='1')) {$dia_inici=$data_inici+(4*24*3600);$dies_repeticio="0100000";}
/*SI EL 01/10/20XX ES DV I EL DIA TRIAT ES DL, EL NOSTRE DIA PER A CREAR LA SESSIO ES ZZZ+(3*24*3600)*/
if (($dia_setmana=='5') AND ($dia=='1')) {$dia_inici=$data_inici+(3*24*3600);$dies_repeticio="0100000";}
/*SI EL 01/10/20XX ES DS I EL DIA TRIAT ES DL, EL NOSTRE DIA PER A CREAR LA SESSIO ES ZZZ+(2*24*3600)*/
if (($dia_setmana=='6') AND ($dia=='1')) {$dia_inici=$data_inici+(2*24*3600);$dies_repeticio="0100000";}
/*SI EL 01/10/20XX ES DG I EL DIA TRIAT ES DL, EL NOSTRE DIA PER A CREAR LA SESSIO ES ZZZ+(1*24*3600)*/
if (($dia_setmana=='0') AND ($dia=='1')) {$dia_inici=$data_inici+(1*24*3600);$dies_repeticio="0100000";}

/*SI EL 01/10/20XX ES DL I EL DIA TRIAT ES DM, EL NOSTRE DIA PER A CREAR LA SESSIO ES ZZZ+(1*24*3600)*/
if (($dia_setmana=='1') AND ($dia=='2')) {$dia_inici=$data_inici+(1*24*3600);$dies_repeticio="0010000";}
/*SI EL 01/10/20XX ES DM I EL DIA TRIAT ES DM, EL NOSTRE DIA PER A CREAR LA SESSIO ES ZZZ+(0*24*3600)*/
if (($dia_setmana=='2') AND ($dia=='2')) {$dia_inici=$data_inici+(0*24*3600);$dies_repeticio="0010000";}
/*SI EL 01/10/20XX ES DX I EL DIA TRIAT ES DM, EL NOSTRE DIA PER A CREAR LA SESSIO ES ZZZ+(6*24*3600)*/
if (($dia_setmana=='3') AND ($dia=='2')) {$dia_inici=$data_inici+(6*24*3600);$dies_repeticio="0010000";}
/*SI EL 01/10/20XX ES DJ I EL DIA TRIAT ES DM, EL NOSTRE DIA PER A CREAR LA SESSIO ES ZZZ+(5*24*3600)*/
if (($dia_setmana=='4') AND ($dia=='2')) {$dia_inici=$data_inici+(5*24*3600);$dies_repeticio="0010000";}
/*SI EL 01/10/20XX ES DV I EL DIA TRIAT ES DM, EL NOSTRE DIA PER A CREAR LA SESSIO ES ZZZ+(4*24*3600)*/
if (($dia_setmana=='5') AND ($dia=='2')) {$dia_inici=$data_inici+(4*24*3600);$dies_repeticio="0010000";}
/*SI EL 01/10/20XX ES DS I EL DIA TRIAT ES DM, EL NOSTRE DIA PER A CREAR LA SESSIO ES ZZZ+(3*24*3600)*/
if (($dia_setmana=='6') AND ($dia=='2')) {$dia_inici=$data_inici+(3*24*3600);$dies_repeticio="0010000";}
/*SI EL 01/10/20XX ES DG I EL DIA TRIAT ES DM, EL NOSTRE DIA PER A CREAR LA SESSIO ES ZZZ+(2*24*3600)*/
if (($dia_setmana=='0') AND ($dia=='2')) {$dia_inici=$data_inici+(2*24*3600);$dies_repeticio="0010000";}

/*SI EL 01/10/20XX ES DL I EL DIA TRIAT ES DX, EL NOSTRE DIA PER A CREAR LA SESSIO ES ZZZ+(2*24*3600)*/
if (($dia_setmana=='1') AND ($dia=='3')) {$dia_inici=$data_inici+(2*24*3600);$dies_repeticio="0001000";}
/*SI EL 01/10/20XX ES DM I EL DIA TRIAT ES DX, EL NOSTRE DIA PER A CREAR LA SESSIO ES ZZZ+(1*24*3600)*/
if (($dia_setmana=='2') AND ($dia=='3')) {$dia_inici=$data_inici+(1*24*3600);$dies_repeticio="0001000";}
/*SI EL 01/10/20XX ES DX I EL DIA TRIAT ES DX, EL NOSTRE DIA PER A CREAR LA SESSIO ES ZZZ+(0*24*3600)*/
if (($dia_setmana=='3') AND ($dia=='3')) {$dia_inici=$data_inici+(0*24*3600);$dies_repeticio="0001000";}
/*SI EL 01/10/20XX ES DJ I EL DIA TRIAT ES DX, EL NOSTRE DIA PER A CREAR LA SESSIO ES ZZZ+(6*24*3600)*/
if (($dia_setmana=='4') AND ($dia=='3')) {$dia_inici=$data_inici+(6*24*3600);$dies_repeticio="0001000";}
/*SI EL 01/10/20XX ES DV I EL DIA TRIAT ES DX, EL NOSTRE DIA PER A CREAR LA SESSIO ES ZZZ+(5*24*3600)*/
if (($dia_setmana=='5') AND ($dia=='3')) {$dia_inici=$data_inici+(5*24*3600);$dies_repeticio="0001000";}
/*SI EL 01/10/20XX ES DS I EL DIA TRIAT ES DX, EL NOSTRE DIA PER A CREAR LA SESSIO ES ZZZ+(4*24*3600)*/
if (($dia_setmana=='6') AND ($dia=='3')) {$dia_inici=$data_inici+(4*24*3600);$dies_repeticio="0001000";}
/*SI EL 01/10/20XX ES DG I EL DIA TRIAT ES DX, EL NOSTRE DIA PER A CREAR LA SESSIO ES ZZZ+(3*24*3600)*/
if (($dia_setmana=='0') AND ($dia=='3')) {$dia_inici=$data_inici+(3*24*3600);$dies_repeticio="0001000";}

/*SI EL 01/10/20XX ES DL I EL DIA TRIAT ES DJ, EL NOSTRE DIA PER A CREAR LA SESSIO ES ZZZ+(3*24*3600)*/
if (($dia_setmana=='1') AND ($dia=='4')) {$dia_inici=$data_inici+(3*24*3600);$dies_repeticio="0000100";}
/*SI EL 01/10/20XX ES DM I EL DIA TRIAT ES DJ, EL NOSTRE DIA PER A CREAR LA SESSIO ES ZZZ+(2*24*3600)*/
if (($dia_setmana=='2') AND ($dia=='4')) {$dia_inici=$data_inici+(2*24*3600);$dies_repeticio="0000100";}
/*SI EL 01/10/20XX ES DX I EL DIA TRIAT ES DJ, EL NOSTRE DIA PER A CREAR LA SESSIO ES ZZZ+(1*24*3600)*/
if (($dia_setmana=='3') AND ($dia=='4')) {$dia_inici=$data_inici+(1*24*3600);$dies_repeticio="0000100";}
/*SI EL 01/10/20XX ES DJ I EL DIA TRIAT ES DJ, EL NOSTRE DIA PER A CREAR LA SESSIO ES ZZZ+(0*24*3600)*/
if (($dia_setmana=='4') AND ($dia=='4')) {$dia_inici=$data_inici+(0*24*3600);$dies_repeticio="0000100";}
/*SI EL 01/10/20XX ES DV I EL DIA TRIAT ES DJ, EL NOSTRE DIA PER A CREAR LA SESSIO ES ZZZ+(6*24*3600)*/
if (($dia_setmana=='5') AND ($dia=='4')) {$dia_inici=$data_inici+(6*24*3600);$dies_repeticio="0000100";}
/*SI EL 01/10/20XX ES DS I EL DIA TRIAT ES DJ, EL NOSTRE DIA PER A CREAR LA SESSIO ES ZZZ+(5*24*3600)*/
if (($dia_setmana=='6') AND ($dia=='4')) {$dia_inici=$data_inici+(5*24*3600);$dies_repeticio="0000100";}
/*SI EL 01/10/20XX ES DG I EL DIA TRIAT ES DJ, EL NOSTRE DIA PER A CREAR LA SESSIO ES ZZZ+(4*24*3600)*/
if (($dia_setmana=='0') AND ($dia=='4')) {$dia_inici=$data_inici+(4*24*3600);$dies_repeticio="0000100";}

/*SI EL 01/10/20XX ES DL I EL DIA TRIAT ES DV, EL NOSTRE DIA PER A CREAR LA SESSIO ES ZZZ+(4*24*3600)*/
if (($dia_setmana=='1') AND ($dia=='5')) {$dia_inici=$data_inici+(4*24*3600);$dies_repeticio="0000010";}
/*SI EL 01/10/20XX ES DM I EL DIA TRIAT ES DV, EL NOSTRE DIA PER A CREAR LA SESSIO ES ZZZ+(3*24*3600)*/
if (($dia_setmana=='2') AND ($dia=='5')) {$dia_inici=$data_inici+(3*24*3600);$dies_repeticio="0000010";}
/*SI EL 01/10/20XX ES DX I EL DIA TRIAT ES DV, EL NOSTRE DIA PER A CREAR LA SESSIO ES ZZZ+(2*24*3600)*/
if (($dia_setmana=='3') AND ($dia=='5')) {$dia_inici=$data_inici+(2*24*3600);$dies_repeticio="0000010";}
/*SI EL 01/10/20XX ES DJ I EL DIA TRIAT ES DV, EL NOSTRE DIA PER A CREAR LA SESSIO ES ZZZ+(1*24*3600)*/
if (($dia_setmana=='4') AND ($dia=='5')) {$dia_inici=$data_inici+(1*24*3600);$dies_repeticio="0000010";}
/*SI EL 01/10/20XX ES DV I EL DIA TRIAT ES DV, EL NOSTRE DIA PER A CREAR LA SESSIO ES ZZZ+(0*24*3600)*/
if (($dia_setmana=='5') AND ($dia=='5')) {$dia_inici=$data_inici+(0*24*3600);$dies_repeticio="0000010";}
/*SI EL 01/10/20XX ES DS I EL DIA TRIAT ES DV, EL NOSTRE DIA PER A CREAR LA SESSIO ES ZZZ+(6*24*3600)*/
if (($dia_setmana=='6') AND ($dia=='5')) {$dia_inici=$data_inici+(6*24*3600);$dies_repeticio="0000010";}
/*SI EL 01/10/20XX ES DG I EL DIA TRIAT ES DV, EL NOSTRE DIA PER A CREAR LA SESSIO ES ZZZ+(5*24*3600)*/
if (($dia_setmana=='0') AND ($dia=='5')) {$dia_inici=$data_inici+(5*24*3600);$dies_repeticio="0000010";}

/*PERIODICITAT EN SEGONS*/
$periodicitat=7*24*60*60;

/*DES DE LA DATA D'INICI $dia_sessio FINS A LA DATA DE FINAL CADA 7 DIES*/
$i=$dia_inici;

/*SI NO EXISTEIX LA PRIMERA SESSIO ES QUE NO EXISTEIX CAP I NO PODEM ESBORRAR LA SERIE*/
$existeix_sessio=0;
$sql00 = "SELECT * FROM mdl_attendance_sessions WHERE ((attendanceid='$ID_assistencia') AND (sessdate='$i') AND (description LIKE '%$nom_alumne%'))";
$result00=mysql_query($sql00, $conexion);
if($row00=mysql_fetch_row($result00)){

	$sessio_i=date("d-m-y",$i);
	$existeix_sessio=$row00[0];
	echo "<p align='center'><font face='Verdana' size='2' color='red'><b>Sessió $sessio_i existeix. S'esborrarà la sèrie.</b></font></p>";
}

if($existeix_sessio<>"" AND $ID_assistencia<>"" AND $ID_grup<>"" AND $dia<>"" AND $hora<>0 AND $durada<>""){

	$data_reserva_inici=$i;
	$data_reserva_fi=$i+$durada;
	$tipus_reserva="J";
	if(substr_count($nom_curs,"ESO")<>0){$tipus_reserva="A";}
	if(substr_count($nom_curs,"BAT")<>0){$tipus_reserva="B";}
	if(substr_count($nom_curs,"CFGM")<>0){$tipus_reserva="C";}
	if(substr_count($nom_curs,"CFGS")<>0){$tipus_reserva="D";}
	if(substr_count($nom_curs,"CAGS")<>0){$tipus_reserva="E";}
	if(substr_count($nom_curs,"PQPI")<>0){$tipus_reserva="F";}
	if(substr_count($nom_curs,"Coordinació")<>0){$tipus_reserva="G";}
	if(substr_count($nom_curs,"Departaments")<>0){$tipus_reserva="H";}
	if(substr_count($nom_curs,"Direcció")<>0){$tipus_reserva="I";}

	$any_i=date("y",$i);
	$mes_i=date("m",$i);
	$dia_i=date("d",$i);		
	$hora_i=date("h:i",$i);
	$data_reserva_aula=mktime(12,0,0,$mes_i,$dia_i,$any_i);

	$durada_reserva_aula=$data_reserva_aula+$durada;

	$j=$i;

	do
	{
		$j=$j+$periodicitat;
	}while (($j<$data_fi));

	/*ESBORRA REGISTRE REPETICIO RESERVA AULA*/
	$sql11 = "DELETE FROM mdl_block_mrbs_repeat WHERE start_time='$data_reserva_aula' AND end_time='$durada_reserva_aula' AND rep_type='2' AND end_date='$j' AND rep_opt='$dies_repeticio' AND room_id='ID_aula' AND create_by='$nick_name' AND name='$nom_alumne' AND type='$tipus_reserva' AND description='$nom_grup' AND rep_num_weeks=NULL";
	$result11=mysql_query($sql11,$conexion);

	/**********************************************************************/
	/*PER A NO TENIR PROBLEMES AMB EL CANVI D'HORARI D'HIVERN I ESTIU*/
	/*CODI PER SALVAR EL D.S.T. -DAYLIGHT SAVING TIME- */
	/**********************************************************************/
	$flag_mes=0;

	do
	{	
		$any_i=date("y",$i);
		$mes_i=date("m",$i);
		$dia_i=date("d",$i);

		$data_reserva_aula=mktime(12,$minut_reserva,0,$mes_i,$dia_i,$any_i);
		$durada_reserva_aula=$data_reserva_aula+$durada;

		/*****************************************************************************************************/
		/*MIRO SI ES ES DARRER DISSABTE DEL MES PER A FER EL CANVI HORARI HIVERN ESTIU A OCTUBRE I MARS*/
		/*****************************************************************************************************/

		$Darrer_Dissabte=DarrerDissabteMes($mes_i,$any_i);

		/*ES POSA AND (date("m",$ara)<>11) PERQUE DONAVA PROBLEMES QUAN ES CREAVEN SESSIONS AL NOVEMBRE*/
		if ((($mes_i==10) AND ($flag_mes==0) AND ($dia_i>=$Darrer_Dissabte)) OR (($mes_i==11) AND ($flag_mes==0))){

/* AND (date("m",$ara)<>11))){*/

			$i=$i+3600;
			$flag_mes=1;				
		}
		if ((($mes_i==3) AND ($flag_mes==1)  AND ($dia_i>=$Darrer_Dissabte)) OR (($mes_i==4) AND ($flag_mes==1))){
			$i=$i-3600;
			$flag_mes=0;
		}

		/* ATENCIÓ!! POT DONAR PROBLEMES SI A ALGUNA DE LES VARIABLES (PER EXEMPLE EL NOM DE LA SALA) HI HA APOSTROFS!!*/
		$descripcio="
		<p align=\'center\'><font face=\'Verdana\' size=\'1\'>
		<a href=\'http://iessitges.xtec.cat/group/members.php?group=$ID_grup\' title=\'Components del grup\' target=\'_blank\'>$nom_grup</a><br>
		<a href=\'http://iessitges.xtec.cat/blocks/mrbs/web/edit_entry.php?room=$ID_aula&area=$ID_area&year=$any_i&month=$mes_i&day=$dia_i&period=0\' title=\'Reserva $nom_sala2\' target=\'_blank\'>$nom_sala</a><br>
		<a href=\'http://iessitges.xtec.cat/user/profile.php?id=$idalumne\' title=\'Perfil professor\' target=\'_blank\'>$nom_alumne</a></font></p>";
		
		$sessions_esborrades=0;

		/*ESBORRA REGISTRE SESSIO*/
		$sql1 = "DELETE FROM mdl_attendance_sessions WHERE attendanceid='$ID_assistencia' AND groupid='$ID_grup' AND sessdate='$i' AND duration='$durada_sg' AND lasttakenby='$idalumne'";
		$result1=mysql_query($sql1,$conexion);
		$sessions_esborrades=$sessions_esborrades+mysql_affected_rows();

		$sessio_i=date("d-m-y h:i a",$i);	

		if($result1==FALSE){
			echo"<p align='center'><font face='Verdana' size='2' color='black'>Sessio $N NO esborrada ($sessio_i)</font></p>";
		}else{
			echo"<p align='center'><font face='Verdana' size='2' color='black'>Sessio $N $idalumne esborrada ($sessio_i)</font></p>";
		}
		$N = $N +1;		
		$i=$i+$periodicitat;				

		/*ESBORRA REGISTRES RESERVA AULA*/
		$sql21 = "DELETE FROM mdl_block_mrbs_entry WHERE start_time='$data_reserva_aula' AND end_time='$durada_reserva_aula' AND create_by='$nick_name'";
		$result21=mysql_query($sql21,$conexion);
		if($result21==FALSE){			
			echo"<p align='center'><font face='Verdana' size='2' color='black'>Reserva $nom_sala NO esborrada</font></p>";
		}else{
			echo"<p align='center'><font face='Verdana' size='2' color='black'>Reserva $nom_sala esborrada</font></p>";
		}
	} while (($i<=$data_fi));
}

$N=$N-1;

echo"<p align='center'><font face='Verdana' size='1' color='black'>$N sessions esborrades.</font></p>";
include "desconnectaBD.php";

/*******************CONTROL DE ACCES FINAL********************************************************/
}
else{

echo"<p align='center'><font face='Verdana' size='2' color='red'><b>ACCES DENEGAT!</b></font></p>";

}
}
/******************************************************************************************************/
?>
<hr><p align="center"><font face="Verdana" size="1" color="black">(c) V.L.G.A. 2014</font></p></font></body></html>