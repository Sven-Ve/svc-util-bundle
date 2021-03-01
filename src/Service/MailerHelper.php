<?php

namespace Svc\UtilBundle\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class MailerHelper
{

  private $mailer;
  private $fromAdr;
  private $fromName;

  public function __construct($fromAdr, $fromName, MailerInterface $mailer)
  {
    $this->fromAdr = $fromAdr;
    $this->fromName = $fromName;
    $this->mailer = $mailer;
  }

  public function send($to, $subject, $html, $text=null, $toName=null) {

    if ($toName) {
        $to=new Address($to, $toName);
    }
    
    if ($this->fromAdr) {
      if ($this->fromName) {
        $from=new Address($this->fromAdr, $this->fromName);
      } else {
        $from=$this->fromAdr;
      }
    } else {
      $from=new Address('dev@sv-systems.com', "Test User");
    }

    $email = (new Email())
      ->from($from)
      ->to($to)
      ->subject($subject)
      ->html($html)
      ->text($text)
    ;

    try {
      $this->mailer->send($email);
    } catch (\Exception $e) {
      return false;
    }

    return true;
  }

}