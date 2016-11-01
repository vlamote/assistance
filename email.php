<html>	<title>ENVIDIA</title><body>
<?php include "connectaMAIL.php";
/*******************/
/*CONFIGURA DESTÍ*/
/*******************/
$mail->AddAddress("vlamote@xtec.cat");

/***************************/
/*CREA ASSUMPTE MISSATGE*/
/***************************/
$mail->Subject = "Resum Incidències Setmanals";
$mail->Body = "Aquesta setmana passada has tingut les següents incidències";
$mail->AltBody = "Aquesta setmana passada has tingut les següents incidències";

/***************************/
/*SI EL MISSATGE NO ES BUIT*/
/***************************/
if ($mail->Body<>""){

	/****************/
	/*ENVIA CORREU*/
	/****************/
	if($mail->Send())
	{
		/***********************/
		/*MOSTRA MISSATGE OK*/
		/***********************/
		echo "CORREU ENVIAT CORRECTAMENT";
	}
	/*******/
	/*SI NO*/
	/*******/
	else
	{
		/***********************/
		/*MOSTRA MISSATGE KO*/
		/***********************/
		echo "<br>ERROR EN ENVIAR CORREU";
		/*echo "<br><strong>Informacio:</strong></br>".$mail->ErrorInfo;*/
	}
}
?>
<hr><p align="center"><font face="Verdana" size="1">(c) V.L.G.A. & J.J.M.R. 2014</font></p></body></html>