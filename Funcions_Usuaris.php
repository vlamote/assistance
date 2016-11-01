<?php

include "connectaBD.php";
include "PassaVars.php";

/*********************************************************/
/*PER A NO TENIR PROBLEMES AMB CARACTERS ESTRANYS*/
/*********************************************************/
mysql_query("SET NAMES 'utf8'");
header("Content-Type: text/html;charset=utf-8");

/*************************/                          
/*ESBRINO NOM USUARI */
/************************/
function NomUsuari($idusuari){
	include "connectaBD.php";
	$sql2 = "SELECT * FROM mdl_user WHERE id=$idusuari";
	$result2=mysql_query($sql2, $conexion);
	while($row2=mysql_fetch_row($result2)){
		$nomusuari=$row2[11].", ".$row2[10];
	}
	return $nomusuari;
}

/**********************/                          
/*ESBRINO ID USUARI */
/*********************/
function IdUsuari($nom_usuari){

	/*TROBA LA POSICIO DE LA COMA*/
	$lacoma=strpos ($nom_usuari,",");

	/*ELS COGNOMS ESTAN DAVANT DE LA COMA*/
	$cognoms=left($nom_usuari,$lacoma);

	/*EL NOM ESTA DARRERA DE LA COMA*/
	$nom=right($nom_usuari,$lacoma);

	include "connectaBD.php";
	$sql2 = "SELECT * FROM mdl_user WHERE lastname LIKE '$nom_usuari' AND firstname LIKE '$nom_usuari' AND deleted='0'";
	$result2=mysql_query($sql2, $conexion);
	while($row2=mysql_fetch_row($result2)){
		$idusuari=$row2[0];
	}
	return $idusuari;
}

/**************************/                          
/*ESBRINO FOTO USUARI */
/*************************/
function FotoUsuari($id_usuari){
	if($id_usuari<>0 AND $id_usuari<>-1){
		$fotousuari="http://iessitges.xtec.cat/user/pix.php/".$id_usuari."/f1.jpg";
	}
	return $fotousuari;
}

/**********************/   
/*ESBRINO NOM GRUP*/           
/**********************/
function NomGrup($idgrup){
	include "connectaBD.php";
	$sql8 = "SELECT * FROM mdl_groups WHERE (id=$idgrup)";
	$result8=mysql_query($sql8, $conexion);
	while($row8=mysql_fetch_row($result8)){
		$nomgrup=$row8[3];
	}
	return $nomgrup;
}
?>
