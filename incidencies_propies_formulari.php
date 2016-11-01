<html><head>
<script language="javascript" type="text/javascript" src="datetimepicker.js"></script></head><body>
<title>G.R.I.P.</title></head><body bgcolor="#FFFFFF">
<table border="0" width="100%" id="table2"><tr>
<td width="22%"><font face="Verdana" size="1" color="black"><p align="left"><b>G.R.I.P.</b></p></td>
<td width="56%"><font face="Verdana" size="1" color="black"><p align="center"><a href="horari_propi_llistat.php" target="blank" title="Mira el teu horari">Consulta de l'horari</a> | <a href="notes_propies.php" target="blank" title="Mira les teves notes">Consulta de les notes</a></p></td>
<td width="22%"><font face="Verdana" size="1" color="black"><p align="right"><b>Gestio Remota d'Incidencies Propies</b></font></p></td>
</tr></table><hr>

<!-- Codi afegit 21112013 control usuaris -->

<?php include "connectaBD.php";include "PassaVars.php";

require_once ('../config.php');
global $USER;
$userid=$USER->id;

if(!isloggedin()){  		//USUARI NO LOGUEJAT REDIRECCIO A PAGINA LOGIN

header('Location: http://iessitges.xtec.cat/login/index.php'); }

else { 		//USUARI LOGUEJAT, COMPROBEM QUE NO SIGUI CONVIDAT

		if ($userid <> 1) {   //USUARI AUTORITZAT

//EL PAS DE VARIABLES NO FUNCIONAVA A INTERNET (SI EN INTRANET) DEU ESTAR "REGISTERGLOBALS" A "OFF" AL SERVIDOR, PER QUESTIONS DE SEGURETAT

$tipus = $_POST["tipus"];
$vista = $_POST["vista"];
$data1 = $_POST["data1"];
$data2 = $_POST["data2"];

//TAULA AMB FORMULARI

echo "<table  style='text-align: center margin-left: auto; margin-right: auto; width:100%; height: 44px;' border='0'>
  <tbody>
    <tr align='center'>
      <td width='100%'>
	
      <form method='get' action='incidencies_propies_llistat.php?data1=$data1&data2=$data2&tipus=$tipus&vista=$vista&triacurs=$triacurs&triagrup=$triagrup'>

        <font face='Arial' size='2'>

        <select name='tipus'>
        <option value='T'>Totes les incidencies</option>
        <option value='P'>Observacions</option>
        <option value='J'>Faltes justificades</option>
        <option value='R'>Retards</option>
        <option value='F'>Faltes no justificades</option>
        <option value='E'>Expulsions</option>
        <option value='S'>Sancions</option>
        </select>


<br><br>Des de: ";

//PER A SALVAR LA COMETA SIMPLE DE LA FUNCIO NEWCAL DE TRIA DE DATES

echo <<< HTML
<input name="data1" id="data1" type="text" size="7"><a href="javascript:NewCal('data1','ddmmmyyyy')"><img src="imatges/cal.gif" width="16" height="16" border="0" title="Tria una data"></a>
   Fins a:
<input name="data2" id="data2" type="text" size="7"><a href="javascript:NewCal('data2','ddmmmyyyy')"><img src="imatges/cal.gif" width="16" height="16" border="0" title="Tria una data"></a>
HTML;
echo "<br><br>
        </font>
		<input value='Mostra incidencies' type='submit'>
      </form>
      </td>
    </tr>
  </tbody>
</table>
<font face='Verdana' size='1' color='red'>
<p align='center'><b>Si no es posa data mira un mes en darrera.</b></font><p>";

include "desconnectaBD.php";

} //Fi del if usuari autoritzat

else{ //Usuari no autoritzat, mostrem error
/*header ('Location: http://iessitges.xtec.cat/enrol/index.php?id=284'); }*/
echo"<p align='center'><font face='Verdana' size='2' color='red'><b>ACCÉS DENEGAT!</b></font></p>";
}
}
?>
<hr><p align="center"><font face="Verdana" size="1">(c) V.L.G.A. 2014</font></p></body></html>