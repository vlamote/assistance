<?php

include "connectaBD.php";
include "PassaVars.php";
include "sessionlib.php";
include "Funcions_Usuaris.php";

/***********************/                          
/*ESBRINO NOM AULA */
/**********************/  
function NomAula($idaula){
	include "connectaBD.php";
	$sql4 = "SELECT * FROM mdl_block_mrbs_room WHERE id=$idaula";
	$result4=mysql_query($sql4, $conexion);
	while($row4=mysql_fetch_row($result4)){
		$nomaula=$row4[2];
	}
	return $nomaula;
}

/********************/                          
/*ESBRINO ID AULA */
/*******************/  
function IdAula($nom_aula){
	include "connectaBD.php";
	$sql4 = "SELECT * FROM mdl_block_mrbs_room WHERE room_name=$nom_aula";
	$result4=mysql_query($sql4, $conexion);
	while($row4=mysql_fetch_row($result4)){
		$idaula=$row4[0];
	}
	return $idaula;
}

function CreaColocacioAlumnes($id_profe,$id_aula,$id_grup){
	include "connectaBD.php";
	$alumnes=array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
	$nom_alumnes=array("","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","");
	$alumnescolocats=array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);

	$nom_profe=NomUsuari($id_profe);
	$nom_aula=NomAula($id_aula);
	$nom_grup=NomGrup($id_grup);

	/*********************************************************/
	/*MIRO SI JA EXISTEIX ALGUN REGISTRE A MDL_ZZZ_AULES*/
	/*PER A AQUELL PROFESSOR, GRUP I AULA                                 */
	/*******************************************************/
	$existeix_sessio=0;
	$sql00 = "SELECT * FROM mdl_zzz_aules WHERE  (id_profe= '$id_profe' AND id_aula= '$id_aula' AND id_grup= '$id_grup')";
	$result00=mysql_query($sql00, $conexion);
	if($row00=mysql_fetch_row($result00)){
		echo "<p align='center'><font face='Verdana' size='2' color='red'>Ja hi ha una distribucio creada amb el professor <b>".$nom_profe."</b> i el grup <b>".$nom_grup."</b> a l'aula <b>".$nom_aula."</b> Pica <a href='colocacio_alumnes.php?id_profe=$id_profe&id_grup=$id_grup&id_aula=$id_aula'>aqui</a> per veure-la i modificar-la, si s'escau</b></font></p>";
	}
	else{
		/*****************************/
		/*COMPTA MEMBRES GRUP     */
		/*I OMPLE MATRIU ALUMNES*/
		/***************************/
		$alumnes_grup=0;
		$sql00 = "SELECT * FROM mdl_groups_members WHERE  (groupid='$id_grup')";
		$result00=mysql_query($sql00, $conexion);
		while($row00=mysql_fetch_row($result00)){
			$alumnes[$alumnes_grup]=$row00[2];
			$nom_alumnes[$alumnes_grup]=NomUsuari($row00[2]);
			$alumnes_grup=$alumnes_grup+1;
		}

		/************************************************************/
		/*ORDENA LA LLISTA DE NOMS D'ALUMNES ALFABETICAMENT*/
		/************************************************************/
		natcasesort($nom_alumnes);

		/******************************************************/
		/*SI EL NUMERO DE ALUMNES ES MAJOR QUE 30               */
		/*POSA ELS ALUMNES SEGUITS, SI NO, DEIXA UN ESPAI*/
		/***************************************************/
		if($alumnes_grup>30){
			$sql11 = "INSERT INTO mdl_zzz_aules (id_aula,id_profe,id_grup,
id_alumne_11,id_alumne_12,id_alumne_13,id_alumne_14,id_alumne_15,id_alumne_16,id_alumne_17,id_alumne_18,id_alumne_19,
id_alumne_21,id_alumne_22,id_alumne_23,id_alumne_24,id_alumne_25,id_alumne_26,id_alumne_27,id_alumne_28,id_alumne_29,
id_alumne_31,id_alumne_32,id_alumne_33,id_alumne_34,id_alumne_35,id_alumne_36,id_alumne_37,id_alumne_38,id_alumne_39,
id_alumne_41,id_alumne_42,id_alumne_43,id_alumne_44,id_alumne_45,id_alumne_46,id_alumne_47,id_alumne_48,id_alumne_49,
id_alumne_51,id_alumne_52,id_alumne_53,id_alumne_54,id_alumne_55,id_alumne_56,id_alumne_57,id_alumne_58,id_alumne_59,
id_alumne_61,id_alumne_62,id_alumne_63,id_alumne_64,id_alumne_65,id_alumne_66,id_alumne_67,id_alumne_68,id_alumne_69) VALUES ('$id_aula', '$id_profe', '$id_grup',
'$alumnes[0]','$alumnes[1]','$alumnes[2]','$alumnes[3]','$alumnes[4]','$alumnes[5]','$alumnes[6]','$alumnes[7]','$alumnes[8]',
'$alumnes[9]','$alumnes[10]','$alumnes[11]','$alumnes[12]','$alumnes[13]','$alumnes[14]','$alumnes[15]','$alumnes[16]','$alumnes[17]',
'$alumnes[18]','$alumnes[19]','$alumnes[20]','$alumnes[21]','$alumnes[22]','$alumnes[23]','$alumnes[24]','$alumnes[25]','$alumnes[26]',
'$alumnes[27]','$alumnes[28]','$alumnes[29]','$alumnes[30]','$alumnes[31]','$alumnes[32]','$alumnes[33]','$alumnes[34]','$alumnes[35]',
'$alumnes[36]','$alumnes[37]','$alumnes[38]','$alumnes[39]','$alumnes[40]','$alumnes[41]','$alumnes[42]','$alumnes[43]','$alumnes[44]',
'$alumnes[45]','$alumnes[46]','$alumnes[47]','$alumnes[48]','$alumnes[49]','$alumnes[50]','$alumnes[51]','$alumnes[52]','$alumnes[53]')";
			$result11=mysql_query($sql11,$conexion);
		}
		else{
			$sql11 = "INSERT INTO mdl_zzz_aules (id_aula,id_profe,id_grup,
id_alumne_11,id_alumne_12,id_alumne_13,id_alumne_14,id_alumne_15,id_alumne_16,id_alumne_17,id_alumne_18,id_alumne_19,
id_alumne_21,id_alumne_22,id_alumne_23,id_alumne_24,id_alumne_25,id_alumne_26,id_alumne_27,id_alumne_28,id_alumne_29,
id_alumne_31,id_alumne_32,id_alumne_33,id_alumne_34,id_alumne_35,id_alumne_36,id_alumne_37,id_alumne_38,id_alumne_39,
id_alumne_41,id_alumne_42,id_alumne_43,id_alumne_44,id_alumne_45,id_alumne_46,id_alumne_47,id_alumne_48,id_alumne_49,
id_alumne_51,id_alumne_52,id_alumne_53,id_alumne_54,id_alumne_55,id_alumne_56,id_alumne_57,id_alumne_58,id_alumne_59,
id_alumne_61,id_alumne_62,id_alumne_63,id_alumne_64,id_alumne_65,id_alumne_66,id_alumne_67,id_alumne_68,id_alumne_69) VALUES ('$id_aula', '$id_profe', '$id_grup',
'$alumnes[0]','-1','$alumnes[1]','-1','$alumnes[2]','-1','$alumnes[3]','-1','$alumnes[4]',
'$alumnes[5]','-1','$alumnes[6]','-1','$alumnes[7]','-1','$alumnes[8]','-1','$alumnes[9]',
'$alumnes[10]','-1','$alumnes[11]','-1','$alumnes[12]','-1','$alumnes[13]','-1','$alumnes[14]',
'$alumnes[15]','-1','$alumnes[16]','-1]','$alumnes[17]','-1','$alumnes[18]','-1','$alumnes[19]',
'$alumnes[20]','-1','$alumnes[21]','-1','$alumnes[22]','-1','$alumnes[23]','-1','$alumnes[24]',
'$alumnes[25]','-1','$alumnes[26]','-1','$alumnes[27]','-1','$alumnes[28]','-1','$alumnes[29]')";
			$result11=mysql_query($sql11,$conexion);
		}
	}
return;
}
?>