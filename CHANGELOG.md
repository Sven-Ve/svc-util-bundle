# Changelog

## Version v0.4.0
- added EnvInfoController
- Exception handling and return value in SendMail
- request php >7.4.0 or >8.0.0
- Show real cache dir in EnvInfo

## Version v0.5.0
- integrating a contact form
- changed routing to /svc-util as default

## Version v0.5.0
- translation to german
- added 'copy to me' in ContactForm, added a lot of options in MailHelper
- document the helper classes

## Version v0.8.0
- integrate unit and functional tests
- integrate test for EnvInfoHelper too
- fixed error in array access, format code

## Version v0.9.0
- added tests for controllers
- default values for not defined env variables

## Version v1.0.0
- switched from Email class to TemplatedEmail
- dont add text parameter to mail send, if parameter is empty

## Version v1.1.0
- Added function sendWithTemplate to send mails direct with a twig template
- Added option debug for sending mail (direct error page, if error occur)

## Version v1.2.0
- Added attachFromPath for sending mails with attachements

## Version v1.3.0
*Thu, 10 Jun 2021 17:15:29 +0000*
- Moved to my own recipes server


## Version v1.3.1
*Fri, 11 Jun 2021 16:21:43 +0000*
- fixed getRootURL
