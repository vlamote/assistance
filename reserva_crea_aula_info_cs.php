<html><head><title>R.O.C.S.</title></head>
<table border="0" width="100%" id="table2"><tr>
<td width="25%"><font face="Verdana" size="1"><p align="left"><a href="reserva_aula_info_cs_formulari.php" title="Reserva un PC per a dos alumnes una hora">Reserva</a> | <a href="reserva_aula_info_cs_alum.php" title="Llista de les reserves fetes fins ara">Llista</a> | <a href="reserva_aula_info_cs.php" title="Ocupació de les aules a vista d'ocell">Ocupació</a> | <a href="reserva_aula_info_cs_cerca_formulari.php" title="Consulta les reserves fetes d'un alumne">Consulta</a> | <a href="reserva_crea_aula_info_cs.php" title="Esborra TOTES les reserves">Esborra</a> | <a href="reserva_aula_info_cs_baixa_formulari.php" title="Dona de baixa un PC">Baixa</a></font></p></td>
<td width="50%"><font face="Verdana" size="1" color="red"><p align="center"><b>Cursor a sobre per a detalls. Clic per a més accions</b></p></td>
<td width="25%"><font face="Verdana" size="1"><p align="right"><b>Reserva d'Ordinadors per al Crèdit de Síntesi</b></p></font></td>
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

	header('Location: http://iessitges.xtec.cat/login/index.php?id=284'); }

//SI SI
else {

	//SI l'USUARI ES ADMIN
	if ($userid==7 OR $userid==2848){
	/***************************************************************************************************/

		//ESBORRO TOTA LA TAULA
		$sql111 = "DELETE FROM mdl_zzz_attendance_cs";		
		$result111=mysql_query($sql111,$conexion);
		while($row111=mysql_fetch_row($result111)){
		};

		//DADES CS
		$dies=4;
		$hores=3;
/*CANVIAT PER VICTOR EL 260516*/
/*		$aules=2;*/
		$aules=4;
		$pcs=18;
		$id=1;
		$dia=1;
		$hora=1;
		$aula=1;
		$pc=1;
		$quan=date("Y/m/d  h:i",time());

		//PER A CADA DIA
		do{
			//PER A CADA HORA
			do{
				//PER A CADA AULA
				do{	
					//PER A CADA PC
					do{
						/*INSERTA REGISTRE REPETICIO RESERVA AULA*/
						$sql11 = "INSERT INTO mdl_zzz_attendance_cs (dia, hora, aula, pc, alum1, alum2, reservat, confirmat, observacions, quireserva, quanreserva) VALUES ('$dia', '$hora', '$aula', '$pc', '', '', 0, 0, '', '', '$quan')";					
						$result11=mysql_query($sql11,$conexion);
						if($result11==TRUE){
							header('Location: http://iessitges.xtec.cat/assistencia/reserva_aula_info_cs.php');
						}
						else{
							echo "ERROR EN CREAR REGISTRES";
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