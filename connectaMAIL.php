<html><title>Connexi� a PhpMailer</title><body>
<?php
/******************************/
/*CREA CLASSE I CONFIGURA*/
/******************************/
require ("_lib/class.phpmailer.php");
$mail = new PHPMailer(true);
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = "ssl";
/*****************************/
/*CONFIGURA SERVIDOR SMTP*/
/*****************************/
$mail->Host = "correu.iessitges.cat";
$mail->Port = 465;
$mail->SMTPDebug = 5;
$mail->Username = "info@iessitges.cat";
$mail->Password = "Servid@r_C@rreu#2014";
/**********************************/
/*CONFIGURA CAP�ALERA MISSATGE*/
/**********************************/
$mail->From = "info@iessitges.cat";
$mail->FromName = "Suro Virtual";
?>
</body>
</html>