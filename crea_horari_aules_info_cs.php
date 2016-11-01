<html><head><meta http-equiv="Content-type" content="text/html; charset=utf-8">
<title>R.A.I.C.S.</title> <script language="javascript" type="text/javascript" src="datetimepicker.js"></script></head>
<table border="0" width="100%" id="table2"><tr>
<td width="28%"><font face="Verdana" size="1" color="black">Fijaté<p align="left">
<td width="54%"><font face="Verdana" size="1" color="red"><p align="left"><b>Creant registres de reserva</b></p></td>
<td width="18%"><font face="Verdana" size="1" color="black"><p align="right"><b>Reserva Aules d'Informàtica al Crèdit de Síntesi</b></p></font></td>
</tr></table><hr>

<?php

include "connectaBD.php";mysql_query("SET NAMES 'utf8'");include "PassaVars.php";include "Funcions_Temporals.php";

/*PER A NO TENIR PROBLEMES AMB CARACTERS ESTRANYS*/
header("Content-Type: text/html;charset=utf-8");

/*******************CONTROL DE ACCES INICI********************************************************/
require_once ('../config.php');
global $USER;
$userid=$USER->id;

//SI NO ESTA LOGEJAT
if(!isloggedin()){

	header('Location: http://proves.iessitges.cat/login/index.php?id=284'); }

//SI SI
else {

	//SI l'USUARI ES ADMIN
	if ($userid==7 OR $userid==2848){
	/***************************************************************************************************/

		//DADES CS
		$dies=4;
		$hores=3;
		$aules=2;
		$pcs=18;
		$id=1;
		$dia=1;
		$hora=1;
		$aula=1;
		$pc=1;

		//PER A CADA DIA
		do{

			//PER A CADA HORA
			do{
	
				//PER A CADA AULA
				do{	

					//PER A CADA PC
					do{

						/*INSERTA REGISTRE REPETICIO RESERVA AULA*/
						$sql11 = "INSERT INTO mdl_zzz_attendance_cs (dia, hora, aula, pc, alum1, alum2, reservat, confirmat, observacions) VALUES ('$dia', '$hora', '$aula', '$pc', '', '', 0, 0, '')";
					
						$result11=mysql_query($sql11,$conexion);

						if($result11==TRUE){

							echo "Id: ".$id." | Dia: ".$dia." | Hora: ".$hora." | Aula: ".$aula." | PC: ".$pc."<hr>";

						}

						$pc=$pc+1;

						$id=$id+1;

					}while($pc<=$pcs);

					$pc=1;

					$aula=$aula+1;

				}while($aula<=$aules);

				$hora=$hora+1;

				$aula=1;

			}while($hora<=$hores);

			$dia=$dia+1;

			$hora=1;

		}while($dia<=$dies);
	
		include "desconnectaBD.php";

	/*******************CONTROL DE ACCES FINAL********************************************************/
	}
	else{
	
		echo"<p align='center'><font face='Verdana' size='2' color='red'><b>ACCES DENEGAT!</b></font></p>";
	}
}
/******************************************************************************************************/
?>
<hr><p align="center"><font face="Verdana" size="1" color="black">(c) V.L.G.A. 2015</font></p></font></body></html>