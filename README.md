Overview
========

* [installation](docs/installation.md)
* [Usage](docs/usage.md)

**Services:**
* EnvInfoHelper
  * getRootURL()
  * getURLtoIndexPhp()
  * getRootURLandPrefix()
* NetworkHelper
* MailHelper
* ContactForm


**Versioning:**
* Version v0.3.0: added new service MailHelper
* Version v0.4.0: added EnvInfoController
* Version v0.4.1: fixed typos, change route to /admin/...
* Version v0.4.2: Exception handling and return value in SendMail
* Version v0.4.2: request php >7.4.0 or >8.0.0
* Version v0.4.3: request php >7.4.0 or >8.0.0
* Version v0.4.4: Show real cache dir in EnvInfo
* Version v0.5.0: integrating a contact form
* Version v0.5.1: changed routing to /svc-util as default
* Version v0.6.0: translation to german
* Version v0.7.0: added 'copy to me' in ContactForm, added a lot of options in MailHelper
* Version v0.7.1: document the helper classes
* Version v0.8.0: integrate unit and functional tests
* Version v0.8.1: integrate test for EnvInfoHelper too
* Version v0.8.2: fixed error in array access, format code
* Version v0.9.0: added tests for controllers
* Version v0.9.1: default values for not defined env variables
* Version v1.0.0: switched from Email class to TemplatedEmail, dont add text parameter to mail send, if parameter is empty
* Version v1.1.0: Added function sendWithTemplate to send mails direct with a twig template