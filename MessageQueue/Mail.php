<?php
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
    $recipientCount = count($contactAddresses);
    for($i = 0; $i < $recipientCount; $i++)
    {
      $this->mail->addAddress($recipientAddresses[$i]);
    }
    $this->mail->Subject = $subject;
    $this->mail->Body = $content;

    $sent = true;
    if(!$this->mail->send())
    {
      $sent = false;
    }
    return $sent;
  }
}



?>