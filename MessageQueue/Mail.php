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
    try
    {
      $this->mail->setFrom($senderAddress, $senderName);
      $recipientCount = count($recipientAddresses);
      for($i = 0; $i < $recipientCount; $i++)
      {
        $this->mail->addAddress($recipientAddresses[$i]);
      }
      $this->mail->Subject = $subject;
      $this->mail->Body = $content;
      $this->mail->send();
      $sent = true;
    }
    catch (Exception $e)
    {
      $sent = false;
      echo $e->errorMessage();
    } 
    catch (\Exception $e)
    {
      $sent = false;
      echo $e->getMessage();
    }
    return $sent;
  }
}



?>