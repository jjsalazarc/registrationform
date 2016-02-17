<?php

function sendEmail($email, $nombre, $unique) {
    error_reporting(E_ALL);
    require_once ("PHPMailer_5.2.4/class.phpmailer.php");
    $mail = new PHPMailer();
//$mail->IsSendmail();
    $mail->IsSMTP(); // set mailer to use SMTP
    $mail->SMTPDebug = 0;
    $mail->From = "jjsalazar.cambronero@gmail.com";
    $mail->FromName = "Juan Jose";
    $mail->Host = "smtp.emailsrvr.com"; // specif smtp server
//$mail->SMTPSecure= "ssl"; // Used instead of TLS when only POP mail is selected
    $mail->Port = 587; // Used instead of 587 when only POP mail is selected
    $mail->SMTPAuth = true;
    $mail->Username = "juan.salazar@grupopol.com"; // SMTP username
    $mail->Password = "juan1salazar"; // SMTP password
    $mail->AddAddress($email, $nombre); //replace myname and mypassword to yours
    $mail->AddEmbeddedImage('images/' . $unique . 'image.png', 'logoimg', $unique . 'image.png');
//$path = $_SERVER['DOCUMENT_ROOT'] . 'Prueba/MailerTest/filename.png';
//$mail->AddAttachment($path);
    $mail->AddReplyTo("jjsalazar.cambronero@gmail.com", "Juan Salazar");
//$mail->WordWrap = 50; // set word wrap
//$mail->AddAttachment("c:\\temp\\js-bak.sql"); // add attachments
//$mail->AddAttachment("c:/temp/11-10-00.zip");

    $mail->IsHTML(true); // set email format to HTML
    $mail->Subject = 'test';
    $mail->Body = 'test';

    if ($mail->Send()) {
        return true;
        //echo "Send mail successfully";
    } else {
        return false;
        //echo "Send mail fail" . $mail->ErrorInfo;
    }
}

?>