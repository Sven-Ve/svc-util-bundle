<?php

namespace Svc\UtilBundle\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Helper class to send mails very easy.
 *
 * @author Sven Vetter <dev@sv-systems.com>
 */
class MailerHelper
{
  private bool $enableSendWithTemplate = false;

  private $htmlTemplate;

  private $htmlContext;

  public function __construct(private MailerInterface $mailer, private string $fromAdr, private ?string $fromName = null)
  {
  }

  /**
   * send a mail with a twig template.
   *
   * @param string     $to           the mail adress I want to send
   * @param string     $subject      the subject of this mail
   * @param string     $htmlTemplate the name of the html twig template
   * @param array|null $context      the context for the template
   * @param array      $options      array of options ('priority', 'toName' , 'cc', 'ccName', 'bcc', 'replyTo', 'debug', 'attachFromPath')
   *
   * @return bool if mail sent
   */
  public function sendWithTemplate(string $to, string $subject, string $htmlTemplate, ?array $context = [], ?array $options = []): bool
  {
    $this->enableSendWithTemplate = true;
    $this->htmlTemplate = $htmlTemplate;
    $this->htmlContext = $context;

    return $this->send($to, $subject, '', null, $options);
  }

  /**
   * send a mail.
   *
   * @param string $to      the mail adress I want to send
   * @param string $subject the subject of this mail
   * @param string $html    the html content of the mail
   * @param string $text    the text version of the mail, recommended for older mail clients
   * @param array  $options array of options ('priority', 'toName' , 'cc', 'ccName', 'bcc', 'replyTo', 'debug', 'attachFromPath')
   *
   * @return bool if mail sent
   */
  public function send(string $to, string $subject, string $html, string $text = null, ?array $options = []): bool
  {
    $resolver = new OptionsResolver();
    $this->configureOptions($resolver);
    $options = $resolver->resolve($options);

    if ($options['toName']) {
      $to = new Address($to, $options['toName']);
    }

    if ($this->fromAdr) {
      if ($this->fromName) {
        $from = new Address($this->fromAdr, $this->fromName);
      } else {
        $from = $this->fromAdr;
      }
    } else {
      $from = new Address('dev@sv-systems.com', 'Test User');
    }

    $email = (new TemplatedEmail())
      ->from($from)
      ->to($to)
      ->subject($subject);

    if ($this->enableSendWithTemplate) {
      $email
        ->htmlTemplate($this->htmlTemplate)
        ->context($this->htmlContext);
      $this->enableSendWithTemplate = false;
    } else {
      $email->html($html);
      if ($text) {
        $email->text($text);
      }
    }

    if ($options['priority'] != Email::PRIORITY_NORMAL) {
      $email->priority($options['priority']);
    }

    if ($options['cc']) {
      if ($options['ccName']) {
        $email->cc(new Address($options['cc'], $options['ccName']));
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

    if ($options['dryRun']) {
      return true;
    }

    if ($options['attachFromPath']) {
      $email->attachFromPath($options['attachFromPath']);
    }

    if ($options['debug']) { // no catch block for error messages
      $this->mailer->send($email);

      return true;
    }

    try {
      $this->mailer->send($email);
    } catch (\Exception) {
      return false;
    }

    return true;
  }

  /**
   * define the default values for the options array.
   */
  private function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'priority' => Email::PRIORITY_NORMAL,
      'toName' => null,
      'cc' => null,
      'ccName' => null,
      'bcc' => null,
      'replyTo' => null,
      'dryRun' => false,
      'debug' => false,
      'attachFromPath' => null,
    ]);

    $resolver->setAllowedTypes('priority', 'int');
    $resolver->setAllowedTypes('toName', ['string', 'null']);
    $resolver->setAllowedTypes('toName', ['string', 'null']);
    $resolver->setAllowedTypes('cc', ['string', 'null']);
    $resolver->setAllowedTypes('bcc', ['string', 'null']);
    $resolver->setAllowedTypes('replyTo', ['string', 'null']);
    $resolver->setAllowedTypes('dryRun', 'bool');
    $resolver->setAllowedTypes('debug', 'bool');
    $resolver->setAllowedTypes('attachFromPath', ['string', 'null']);
  }
}
