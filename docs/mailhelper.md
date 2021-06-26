# Mailhelper
sending easy mails with some important parameters

<br />

## Installation
symfony/mailer has to be installed and configured.

<br />

## Sender
the sender mail address is set in the config file.

<br />

## <small>Svc\UtilBundle\Service\MailerHelper::</small>sendWithTemplate
send a mail with a twig template

### Signature

```php
use Svc\UtilBundle\Service\MailerHelper;

...

/**
   * send a mail with a twig template
   *
   * @param string $to the mail adress I want to send
   * @param string $subject the subject of this mail
   * @param string $htmlTemplate the name of the html twig template
   * @param array|null $context the context for the template
   * @param array $options array of options ('priority', 'toName' , 'cc', 'ccName', 'bcc', 'replyTo', 'debug', 'attachFromPath')
   * 
   * @return boolean if mail sent
   */
  public function sendWithTemplate(string $to, string $subject, string $htmlTemplate, ?array $context = [], ?array $options = []): bool
```

<br />

## <small>Svc\UtilBundle\Service\MailerHelper::</small>send
send a mail

### Signature

```php
use Svc\UtilBundle\Service\MailerHelper;

...

  /**
   * send a mail
   * 
   * @param string $to the mail adress I want to send
   * @param string $subject the subject of this mail
   * @param string $html the html content of the mail
   * @param string $text the text version of the mail, recommended for older mail clients
   * @param array $options array of options ('priority', 'toName' , 'cc', 'ccName', 'bcc', 'replyTo', 'debug', 'attachFromPath')
   * 
   * @return bool if mail sent
   */
  public function send(string $to, string $subject, string $html, ?string $text = null, ?array $options = []): bool
```