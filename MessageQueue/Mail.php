<?php
include('Email.php');
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail
{
  private $mail;

  public function __construct()
  { 
    $this->mail = new PHPMailer;
    $this->mail->isSMTP();
    $this->mail->Username = SMTPUSER;
    $this->mail->Password = SMTPPASS;
    $this->mail->Host = SMTPHOST;
    $this->mail->SMTPAuth = true;
    $this->mail->SMTPSecure = 'tls';
    $this->mail->Port = 587;
    $this->mail->isHTML(false);
  }

  public function sendMail($senderAddress,
                          $senderName,
                          $recipientAddresses,
                          $subject,
                          $content)
  {
    $this->mail->setFrom($senderAddress, $senderName);
    $this->mail->Subject = $subject;
    $this->mail->Body = $content;
    $recipientCount = count($recipientAddresses);
    for($i = 0; $i < $recipientCount; $i++)
    {
      $this->mail->addAddress($recipientAddresses[$i]);
    }
    $this->mail->send();
    $sent = "Sent:";
    if(!$this->mail->send())
    {
      $sent = "Error:" . $this
    }
    return $sent;
  }
}



?>