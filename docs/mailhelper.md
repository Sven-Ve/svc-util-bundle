# Mailhelper
sending easy mails with some important parameters

<br />

## Installation
symfony/mailer has to be installed and configured.

<br />

## Sender
The sender mail address **must** be configured in the config file. If not configured, the service will throw an `InvalidArgumentException`.

```yaml
# config/packages/svc_util.yaml
svc_util:
    mailer:
        mail_address: 'noreply@example.com'  # Required!
        mail_name: 'System Mailer'           # Optional
```

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
   * @param array $options array of options ('priority', 'toName' , 'cc', 'ccName', 'bcc', 'replyTo', 'debug', 'dryRun', 'attachFromPath')
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
   * @param array $options array of options ('priority', 'toName' , 'cc', 'ccName', 'bcc', 'replyTo', 'debug', 'dryRun', 'attachFromPath')
   * 
   * @return bool if mail sent
   */
  public function send(string $to, string $subject, string $html, ?string $text = null, ?array $options = []): bool
```

## Available Options

The `$options` array supports the following parameters:

- `priority` (int): Email priority (use `Email::PRIORITY_HIGH`, `Email::PRIORITY_NORMAL`, `Email::PRIORITY_LOW`)
- `toName` (string|null): Display name for the recipient
- `cc` (string|null): CC email address
- `ccName` (string|null): Display name for CC recipient  
- `bcc` (string|null): BCC email address
- `replyTo` (string|null): Reply-to email address
- `debug` (bool): If true, exceptions are not caught (default: false)
- `dryRun` (bool): If true, email is not actually sent (for testing) (default: false)
- `attachFromPath` (string|null): Path to file attachment

### Example with Options

```php
$mailerHelper->send(
    'user@example.com',
    'Important Message',
    '<h1>Hello!</h1>',
    'Hello!',
    [
        'priority' => Email::PRIORITY_HIGH,
        'toName' => 'John Doe',
        'cc' => 'manager@example.com',
        'ccName' => 'Manager',
        'replyTo' => 'support@example.com',
        'dryRun' => false
    ]
);
```