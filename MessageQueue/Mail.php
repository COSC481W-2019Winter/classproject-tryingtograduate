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

  private function reportSuccess($contactName, $address)
  {
    $result = 'Message sent to ';
    $result .= $contactName;
    $result .= ' at ';
    $result .= $address;
    $result .= '\n';
    return $result;
  }

  private function reportFail($contactName, $address)
  {
    $result = 'Message not sent to ';
    $result .= $contactName;
    $result .= ' at ';
    $result .= $address;
    $result .= '\n';
    return $result;
  }

  public function sendMail($senderAddress,
                          $senderName,
                          $groupMembers,
                          $subject,
                          $content)
  {
    $results = array();

    $this->mail->setFrom($senderAddress, $senderName);
    $this->mail->Subject = $subject;
    $this->mail->Body = $content;
    $memberCount = count($groupMembers);
    for($i = 0; $i < $memberCount; $i++)
    {
      $contactName = $groupMembers[$i]->getFirstName();
      $contactName .= " ";
      $contactName .= $groupMembers[$i]->getLastName();
      $emailAddress = $groupMembers[$i]->getEmail();

      $phoneNumber = $groupMembers[$i]->getPhone();
      $carrierSuffix = $groupMembers[$i]->getCarrier()->getEmail();

      if($emailAddress != null)
      {
        $this->mail->ClearAllRecipients();
        $this->mail->addAddress($emailAddress, $contactName);
        if(!$this->mail->send())
        {
          array_push($results, $this->reportFail($contactName, $emailaddress));
        }
        else
        {
          array_push($results, $this->reportsuccess($contactName, $emailaddress));
        }
      }
      if($phoneNumber != null && $carrierSuffix != null)
      {
        $sms = $phoneNumber . $carrierSuffix;
        $this->mail->ClearAllRecipients();
        $this->mail->addAddress($sms, $contactName);
        if(!$this->mail->send())
        {
          array_push($results, $this->reportFail($contactName, $sms));
        }
        else
        {
          array_push($results, $this->reportsuccess($contactName, $sms));
        }
      }
    }
    return results;
  }
}
?>