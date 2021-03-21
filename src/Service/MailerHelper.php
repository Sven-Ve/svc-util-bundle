<?php

namespace Svc\UtilBundle\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Helper class to send mails very easy
 * 
 * @author Sven Vetter <dev@sv-systems.com>
 */
class MailerHelper
{

  private $mailer;
  private $fromAdr;
  private $fromName;

  public function __construct(string $fromAdr, string $fromName, MailerInterface $mailer)
  {
    $this->fromAdr = $fromAdr;
    $this->fromName = $fromName;
    $this->mailer = $mailer;
  }

  /**
   * send a mail
   * 
   * @param string $to the mail adress I want to send
   * @param string $subject the subject of this mail
   * @param string $html the html content of the mail
   * @param string $text the text version of the mail, recommended for older mail clients
   * @param array $options array of options ('priority', 'toName' , 'cc', 'ccName', 'bcc', 'replyTo')
   * 
   * @return bool if mail sent
   */
  public function send
    (string $to, string $subject, string $html, ?string $text=null, ?array $options = []): bool {

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

    if ($options['replyTo']) {
      dump($email);
      return true;
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
      'dryRun'   => false,
    ]);

    $resolver->setAllowedTypes('priority', 'int');
    $resolver->setAllowedTypes('toName', ['string', 'null']);
    $resolver->setAllowedTypes('toName', ['string', 'null']);
    $resolver->setAllowedTypes('cc', ['string', 'null']);
    $resolver->setAllowedTypes('bcc', ['string', 'null']);
    $resolver->setAllowedTypes('replyTo', ['string', 'null']);
    $resolver->setAllowedTypes('dryRun', 'bool');
  }

}