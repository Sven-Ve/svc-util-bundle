# <small>Svc\UtilBundle\Service\MailerHelper::</small>sendWithTemplate

#### send a mail with a twig template

## Signature

<div class="styled synopsis">`public function sendWithTemplate(string $to, string $subject, string $htmlTemplate, [array $context = , [array $options = ]] )`</div>

## Parameters

<dl class="styled">

<dt>`$to` — string</dt>
<dd>the mail adress I want to send</dd>

<dt>`$subject` — string</dt>
<dd>the subject of this mail</dd>

<dt>`$htmlTemplate` — string</dt>
<dd>the name of the html twig template</dd>

<dt>`$context` — array</dt>
<dd>the context for the template</dd>

<dt>`$options` — array</dt>

<dd>array of options ('priority', 'toName' , 'cc', 'ccName', 'bcc', 'replyTo', 'debug', 'attachFromPath')</dd>

</dl>

## Returns

<dl class="styled">

<dt>boolean</dt>

<dd>if mail sent</dd>

</dl>

</section>

</div>
