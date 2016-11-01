<?php include "connectaBD.php";

include "PassaVars.php";

mysql_query("SET NAMES 'utf8'");

/*PER A NO TENIR PROBLEMES AMB CARACTERS ESTRANYS*/
header("Content-Type: text/html;charset=utf-8");

/****************************************/
/*FUNCIO QUE CREA UN FITXER DE TEXT*/
/**************************************/

function CreaFitxer($nom_fitxer){

}

/****************************************/
/*FUNCIO QUE ESBORRA UN FITXER DE TEXT*/
/**************************************/

function EsborraFitxer($nom_fitxer){

}

/******************************************************/
/*FUNCIO QUE AFEGEIX UNA LINIA A UN FITXER DE TEXT*/
/*****************************************************/

// $nom_fitxer,$linia_text

function EditaFitxer(){

	$file = fopen("horari.ics", "w");
	fwrite($file, "Esto es una nueva linea de texto" . PHP_EOL);
	fwrite($file, "Otra mas" . PHP_EOL);
	fclose($file);

}

/*****************************************/
/*FUNCIO QUE LLEGEIX UN FITXER DE TEXT*/
/*****************************************/

function LlegeixFitxer(){

	$file = fopen("horari.ics", "r");
	while(!feof($file)) {
		echo fgets($file). "<br />";
	}
	fclose($file);
}
?>
