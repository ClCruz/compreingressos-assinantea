<?php
require("PHPMailer/class.phpmailer.php");
include("functions.php");
if ($_POST){
  $data['success'] = true;
  $_POST  = multiDimensionalArrayMap('cleanEvilTags', $_POST);
  $_POST  = multiDimensionalArrayMap('cleanData', $_POST);

  //your email adress 
  $emailTo ="assinantea@compreingressos.com";

  //from email adress
  $emailFrom ="assinantea@compreingressos.com";

  //email subject
  $emailSubject = "Contato página Assinante A";

  $name = $_POST["name"];
  $email = $_POST["email"];
  $comment = $_POST["comment"];
  $charset = 'utf8';

  if($name == "")
   $data['success'] = false;
 
  if (!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email)) 
    $data['success'] = false;


  if($comment == "")
    $data['success'] = false;

  if($data['success'] == true){

  $message = "NAME: $name<br>
  EMAIL: $email<br>
  COMMENT: $comment";

  $mail = new PHPMailer();
  
  $mail->SetLanguage('br');
  
  $mail->IsSMTP();
  $mail->Host = 'mail.exchange.locaweb.com.br';

  // somente gmail
  $mail->SMTPSecure = "tls";
  
  $mail->Port = 587;
  $mail->SMTPAuth = true;
  $mail->Username = 'assinantea@compreingressos.com';
  $mail->Password = 'ciaa2016';
  $mail->AddAddress($emailTo, $emailTo);

  // somente gmail
  $mail->From = $emailFrom;
  $mail->FromName = $emailFrom;
  $mail->IsHTML(true);
  $mail->CharSet = $charset;
  
  $mail->Subject  = $emailSubject;
  $mail->Body = $message;
  
  $enviado = $mail->Send();
  if ($enviado) {
    $data['success'] = true;

  } else {
    $data['success'] = false;
    echo $mail->ErrorInfo;

  }
  
}
echo json_encode($data);
}
?>