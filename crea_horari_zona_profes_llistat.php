<html><head><meta http-equiv="Content-type" content="text/html; charset=utf-8"><title>C.HO.P.</title><script language="javascript" type="text/javascript" src="datetimepicker.js"></script></head><hr>

<?php

include "connectaBD.php";
include "PassaVars.php";
include "Funcions_Temporals.php";
include "Funcions_Fitxers.php";

/*PER A NO TENIR PROBLEMES AMB CARACTERS ESTRANYS*/
mysql_query("SET NAMES 'utf8'");
header("Content-Type: text/html;charset=utf-8");

/*******************CONTROL DE ACCES INICI********************************************************/
require_once ('../config.php');
global $USER;
$userid=$USER->id;
if(!isloggedin()){

	header('Location: http://iessitges.xtec.cat/login/index.php?id=284'); }

else {

	if ($userid==7 OR $userid==2848){

/***************************************************************************************************/

		/*VARIABLES INICIALS*/
		$idalumne=$userid;
		$ID_grup=0;
		$ID_aula=5;
		$ara=time();
		$N=1;
		$nom_alumne="Profe Generic";
		$nick_name="profe";
		$ID_curs=24;

		/*******************************************/
		/*AL TANTO AL ID ASSISTENCIA QUE POT SER*/
		/*UN ALTRE SI SE HA ESBORRAT, MODIFICAT*/
		/*O ACTUALITZAT LA BBDD!!*/
		/*******************************************/
		$ID_assistencia=3;
		$nom_curs="ZonaProfes";
		$nom_llarg_curs="Zona de Professors";
		$nom_grup="cap grup";

		/*PERIODICITAT EN SEGONS*/
		$periodicitat=1*24*60*60;

		echo "<p align='center'><font face='Verdana' size='2' color='red'>Creació de les vora <b>3.000</b> sessions a la Zona de Professors</p>";

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
		$Marc_Horari_Descripcions=array(MarcHorari(0,0),MarcHorari(1,0),MarcHorari(2,0),MarcHorari(3,0),MarcHorari(4,0),MarcHorari(5,0),MarcHorari(6,0),MarcHorari(7,0),MarcHorari(8,0),MarcHorari(9,0),MarcHorari(10,0),MarcHorari(11,0),MarcHorari(12,0),MarcHorari(13,0),MarcHorari(14,0));
		$Marc_Horari_Hores=               array(MarcHorari(0,2),MarcHorari(1,2),MarcHorari(2,2),MarcHorari(3,2),MarcHorari(4,2),MarcHorari(5,2),MarcHorari(6,2),MarcHorari(7,2),MarcHorari(8,2),MarcHorari(9,2),MarcHorari(10,2),MarcHorari(11,2),MarcHorari(12,2),MarcHorari(13,2),MarcHorari(14,2));
		$Marc_Horari_Durades=          array(60*(MarcHorari(0,3)-MarcHorari(0,2)),60*(MarcHorari(1,3)-MarcHorari(1,2)),60*(MarcHorari(2,3)-MarcHorari(2,2)),60*(MarcHorari(3,3)-MarcHorari(3,2)),60*(MarcHorari(4,3)-MarcHorari(4,2)),60*(MarcHorari(5,3)-MarcHorari(5,2)),60*(MarcHorari(6,3)-MarcHorari(6,2)),60*(MarcHorari(7,3)-MarcHorari(7,2)),60*(MarcHorari(8,3)-MarcHorari(8,2)),60*(MarcHorari(9,3)-MarcHorari(9,2)),60*(MarcHorari(10,3)-MarcHorari(10,2)),60*(MarcHorari(11,3)-MarcHorari(11,2)),60*(MarcHorari(12,3)-MarcHorari(12,2)),60*(MarcHorari(13,3)-MarcHorari(13,2)),60*(MarcHorari(14,3)-MarcHorari(14,2)));

		/*PER A CADA HORA DE LES 15 DEL MARC HORARI*/

		$k=0;

		/*DES DE $k=0 A 14*/		
		do
		{		
			$hora=$Marc_Horari_Hores[$k]*60*60;
			$durada=$Marc_Horari_Durades[$k];
			$durada_sg=$Marc_Horari_Durades[$k]*60;
			$descripcio=$Marc_Horari_Descripcions[$k];

			/*****************************************************************/
			/*ENTENC QUE L'HORARI ES CREA AL MES 09 O 10 DE L'ANY ACTUAL*/
			/*****************************************************************/
			$any_ara=date("y",$ara);
			$mes_ara='9';
			$dia_ara=$Primer_Dia_Curs;
			$data_inici=mktime(0,0,0,$mes_ara,$dia_ara,$any_ara)+$hora;

			$any_fi=date("y",$ara)+1;
			$mes_fi=6;
			$dia_fi=$Darrer_Dia_Curs;
			$data_fi=mktime(0,0,0,$mes_fi,$dia_fi,$any_fi)+$hora;
			$format_descripcio=1;

			/*DES DE LA DATA D'INICI $dia_sessio FINS A LA DATA DE FINAL CADA DIA*/
			$dia_inici=$data_inici;
			$i=$dia_inici;

			if($existeix_sessio==0 ){

				$any_i=date("y",$i);
				$mes_i=date("m",$i);
				$dia_i=date("d",$i);		
				$hora_i=date("h:i",$i);
				$j=$i;

				do
				{
					$j=$j+$periodicitat;
				}while (($j<$data_fi));

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

					/*****************************************************************************************************/
					/*MIRO SI ES ES DARRER DISSABTE DEL MES PER A FER EL CANVI HORARI HIVERN ESTIU A OCTUBRE I MARS*/
					/*****************************************************************************************************/
					$Darrer_Dissabte=DarrerDissabteMes($mes_i,$any_i);
					//echo "Flag: ".$flag_mes."Dia: ".$dia_i." El darrer dissabte del mes ".$mes_i." de l'any ".$any_i." es el ".$Darrer_Dissabte."<br>";

					if ((($mes_i==10) AND ($flag_mes==0) AND ($dia_i>=$Darrer_Dissabte)) OR (($mes_i==11) AND ($flag_mes==0))){
						$i=$i+3600;
						$flag_mes=1;
					}
					if ((($mes_i==3) AND ($flag_mes==1)  AND ($dia_i>=$Darrer_Dissabte)) OR (($mes_i==4) AND ($flag_mes==1))){
						$i=$i-3600;
						$flag_mes=0;
					}

					/***********************/
					/*SI NO EXISTEIX SESSIO*/
					/***********************/
					$existeix_sessio=FALSE;
					$sql000= "SELECT * FROM mdl_attendance_sessions WHERE ((attendanceid='$ID_assistencia') AND (sessdate='$i') AND (groupid='$ID_grup'))";
					$result000=mysql_query($sql000, $conexion);
					while($row000=mysql_fetch_row($result000)){
						$sessio_i=date("d-m-y h:i",$data_sessio);
						$existeix_sessio=TRUE;
					}
					/***********************/

					/********************************************/
					/*MIRO QUE NO SIGUI DISSABTE NI DIUMENGE*/
					/******************************************/
					if($existeix_sessio==FALSE AND EsFestiu($dia_i,$mes_i,$any_i)==FALSE AND date("w",$i)<>0 AND date("w",$i)<>6){

						/*INSERTA REGISTRE SESSIO*/
						$sql1 = "INSERT INTO mdl_attendance_sessions (attendanceid, groupid, sessdate, duration, lasttaken, lasttakenby, timemodified, description, descriptionformat) VALUES ('$ID_assistencia', '$ID_grup', '$i', '$durada_sg', '0', '$userid', '$dia_inici', '$descripcio', '$format_descripcio')";
						$result1=mysql_query($sql1,$conexion);
				
						/*******^*****/
					}
					else{
						$result1=FALSE;
					};
					/*****FI SI NO ES FESTIU**********/

					$sessio_i=date("d-m-y h:i:s a",$i);	

					if($result1==FALSE){			
						echo"<p align='center'><font face='Verdana' size='2' color='red'>$nom_sala NO reservada perquè ja existia o perquè és un festiu</font></p>";
					}else{
						echo"<p align='center'><font face='Verdana' size='2' color='black'>Sessio $N creada ($sessio_i)</font></p>";
						$N = $N +1;
					}
					$i=$i+$periodicitat;									
				} while (($i<=$data_fi));
			}
		
			$k=$k+1;

		}while ($k<15);
		$N=$N-1;
		echo"<p align='center'><font face='Verdana' size='1' color='black'>$N sessions creades.</font></p>";

		include "desconnectaBD.php";

/*******************CONTROL DE ACCES FINAL********************************************************/
	}
	else{
		echo"<p align='center'><font face='Verdana' size='2' color='red'><b>ACCES DENEGAT!</b></font></p>";
	}
}
/******************************************************************************************************/
?>
<hr><p align="center"><font face="Verdana" size="1" color="black">(c) V.L.G.A. 2016</font></p></font></body></html>