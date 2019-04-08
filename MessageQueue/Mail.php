<?php
include('Email.php');
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;

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
    $this->mail->SMTPKeepAlive = true;
    $this->mail->SMTPSecure = 'tls';
    $this->mail->Port = 587;
    $this->mail->isHTML(false);
  }

  public function sendMail($senderAddress,
                          $senderName,
                          $group,
                          $subject,
                          $content)
  {
    $sent = true;

    $this->mail->setFrom($senderAddress, $senderName);
    $this->mail->Subject = $subject;
    $this->mail->Body = $content;
    $members = $group->getMembers();
    $memberCount = count($members);
    for($i = 0; $i < $memberCount; $i++)
    {
      $contactName = $members[$i]->getFirstName();
      $contactName .= " "
      $contactName .= $members[$i]->getLastName();
      $this->mail->ClearAllRecipients();
      $this->mail->addAddress($group[$i]->getAddress(), $contactName);
      if(!$this->mail->send())
      {
        $sent = false;
      }
    }
    return $sent;
  }
}
?>