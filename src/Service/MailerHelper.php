<?php

namespace Svc\UtilBundle\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Helper class to send mails
 */
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

  /**
   * send a mail
   */
  public function send($to, $subject, $html, $text=null, $options = []) {

    $resolver = new OptionsResolver();
    $this->configureOptions($resolver);
    $options = $resolver->resolve($options);

    if ($options['toName']) {
      $to=new Address($to, $options['toName']);
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

    if ($options['priority'] != Email::PRIORITY_NORMAL) {
      $email->priority($options['priority']);
    }
    
    if ($options['cc']) {
      if ($options['ccName']) {
        $email->cc(new Address($options['cc'],$options['ccName']));
      } else {
        $email->cc($options['cc']);
      }
    }

    if ($options['bcc']) {
      $email->bcc($options['bcc']);
    }
    if ($options['replyTo']) {
      $email->replyTo($options['replyTo']);
    }

    try {
      $this->mailer->send($email);
    } catch (\Exception $e) {
      return false;
    }

    return true;
  }

  /**
   * define the default values for the options array
   */
  private function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults([
      'priority' => Email::PRIORITY_NORMAL,
      'toName'   => null,
      'cc'       => null,
      'ccName'   => null,
      'bcc'      => null,
      'replyTo'  => null,
    ]);

    $resolver->setAllowedTypes('priority', 'int');
    $resolver->setAllowedTypes('toName', ['string', 'null']);
    $resolver->setAllowedTypes('toName', ['string', 'null']);
    $resolver->setAllowedTypes('cc', ['string', 'null']);
    $resolver->setAllowedTypes('bcc', ['string', 'null']);
    $resolver->setAllowedTypes('replyTo', ['string', 'null']);
  }

}