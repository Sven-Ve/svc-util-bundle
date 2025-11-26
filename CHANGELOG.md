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


## Version v1.4.0
*Sat, 26 Jun 2021 14:46:30 +0000*
- moved contactform in a new bundle
- added documentation


## Version v1.5.0
*Sat, 26 Jun 2021 14:56:58 +0000*
- open bundle to Opensource


## Version v1.5.1
*Sat, 26 Jun 2021 20:08:42 +0000*
- fixed licence


## Version v1.5.2
*Sat, 03 Jul 2021 17:41:36 +0000*
- added getSubDomain to EnvInfoHelper


## Version v1.5.3
*Tue, 03 Aug 2021 15:10:04 +0000*
- added static code analysis (phpstan)


## Version v1.5.4
*Wed, 04 Aug 2021 08:43:40 +0000*
- removed creation of config file beacause we have a recipe now


## Version v1.6.0
*Mon, 09 Aug 2021 20:36:17 +0000*
- added general stimulus javascript controllers


## Version v1.6.1
*Mon, 09 Aug 2021 20:45:48 +0000*
- define sweetalert2 version >= 10


## Version v1.6.2
*Mon, 09 Aug 2021 20:52:48 +0000*
- added alert controller


## Version v1.6.4
*Mon, 09 Aug 2021 21:00:45 +0000*
- added submit-confirm controller



## Version v1.6.5
*Tue, 10 Aug 2021 20:34:04 +0000*
- added show-password and wysiwyg stimulus controllers


## Version v1.6.6
*Tue, 10 Aug 2021 20:59:24 +0000*
- added reload-content stimulus controller


## Version v1.6.7
*Wed, 11 Aug 2021 21:01:06 +0000*
- added ckeditor5 to js dependencies


## Version v1.7.0
*Sat, 21 Aug 2021 22:01:33 +0000*
- added modal stimulus controller

## Version v2.0.0
*Fri, 28 Jan 2022 21:07:42 +0000*
- added initial compatibility to stimulus 3


## Version v2.0.1
*Fri, 28 Jan 2022 21:18:06 +0000*
- alert.js ready for stimulus 3, fixed unit test error


## Version v2.1.0
*Wed, 27 Apr 2022 16:05:19 +0000*
- ready for symfony 6.0


## Version v2.2.0
*Thu, 28 Apr 2022 19:45:49 +0000*
- @ckeditor/ckeditor5-build-classic to version >=30


## Version v3.0.0
*Sat, 30 Apr 2022 19:47:24 +0000*
- runs only with symfony 5.4 and >6 und php8


## Version v3.0.1
*Sun, 15 May 2022 08:06:23 +0000*
- format code


## Version v3.0.2
*Mon, 30 May 2022 08:56:19 +0000*
- exception handling if http://www.geoplugin.net not available


## Version v3.0.3
*Mon, 30 May 2022 19:27:18 +0000*
- fix test scripts


## Version v3.1.0
*Sat, 25 Jun 2022 08:20:30 +0000*
- added UIHelper


## Version 4.0.0
*Tue, 19 Jul 2022 15:39:39 +0000*
- build with Symfony 6.1 bundle features, runs only with symfony 6.1


## Version 4.0.1
*Thu, 21 Jul 2022 18:40:03 +0000*
- licence year update


## Version 4.0.2
*Sat, 20 Aug 2022 20:15:44 +0000*
- fix javascript for wysiwig controller


## Version 4.1.0
*Thu, 01 Dec 2022 21:10:38 +0000*
- tested for symfony 6.2


## Version 5
*Sat, 16 Dec 2023 16:01:51 +0000*
- ready for symfony 6.4 and 7


## Version 5.0.1
*Sat, 16 Dec 2023 16:04:53 +0000*
- ready for symfony 6.4 and 7


## Version 5.0.2
*Sun, 17 Dec 2023 18:51:00 +0000*
- ready for symfony 6.4 and 7 - fixed test errors


## Version 5.1.0
*Mon, 01 Jan 2024 13:58:01 +0000*
- ready for assetmapper


## Version 5.2.0
*Sun, 07 Jan 2024 14:38:06 +0000*
- twig template (and JS controller) added for flash messages


## Version 5.3.0
*Sun, 21 Jan 2024 15:50:25 +0000*
- added stimulus controller autosubmit


## Version 5.4.0
*Sun, 16 Jun 2024 16:01:06 +0000*
- added twig component for bootstrap modal dialog, needs symfony/ux-twig-component


## Version 5.5.0
*Sat, 22 Jun 2024 14:09:51 +0000*
- added twig component for tables, needs symfony/ux-twig-component; better test kernel, more tests


## Version 5.6.0
*Sat, 16 Nov 2024 18:57:34 +0000*
- Added Class BotChecker to get information if UserAgent a bot


## Version 5.7.0
*Mon, 18 Nov 2024 20:43:22 +0000*
- Removed Class BotChecker, please use matomo/device-detector bundle


## Version 5.8.0
*Mon, 18 Nov 2024 21:08:32 +0000*
- update to phpstan 2 and phpunit 11


## Version 5.9.0
*Mon, 23 Dec 2024 20:42:00 +0000*
- add GPL licence key for CKEditor


## Version 5.9.1
*Sun, 08 Jun 2025 07:39:02 +0000*
- add getLastSendError method to MailerHelper


## Version 5.9.2
*Sat, 21 Jun 2025 21:00:39 +0000*
- new mail test added


## Version 5.10.0
*Sat, 02 Aug 2025 20:25:47 +0000*
- improve EnvInfoController and security, add copyright year


## Version 5.10.1
*Sun, 03 Aug 2025 19:32:26 +0000*
- improve EnvInfoController layout and documentation


## Version 6.0.0
*Mon, 08 Sep 2025 19:44:48 +0000*
- breaking change, now it use php as route configuration. You have to import the routes in your project manually. See docs for more information.


## Version 6.0.1
*Sun, 14 Sep 2025 08:49:02 +0000*
- breaking change, now it use php as route configuration. You have to import the routes in your project manually. See docs for more information.


## Version 6.1.0
*Wed, 29 Oct 2025 14:29:18 +0000*
- Add Toggle Password functionality with Stimulus integration.


## Version 6.1.1
*Wed, 05 Nov 2025 09:00:08 +0000*
- fix(Table): remove 'table-light' class from thead for improved styling consistency.


## Version 7.0.0
*Wed, 19 Nov 2025 15:23:59 +0000*
- BREAKING: Replace SweetAlert2 with native Popover API (~42KB bundle size reduction). All alert/confirm dialogs now use browser-native popovers with emoji icons. See MIGRATION_SWEETALERT_TO_POPOVER.md for details.


## Version 7.1.0
*Wed, 19 Nov 2025 15:56:04 +0000*
- feat(Popover): Add Bootstrap 5.3+ dark mode support. Popovers now automatically adapt to data-bs-theme="dark" with system preference fallback for non-Bootstrap apps.


## Version 8.0.0
*Sat, 22 Nov 2025 21:48:04 +0000*
- BREAKING: Replace Bootstrap Modal with native <dialog> element (~45KB bundle size reduction). 
- Dynamic modals (modal.js) remain 100% API compatible. 
- Static modals (SvcUtil-ModalDialog component) now require id attribute and onclick triggers. 
- See MIGRATION_MODAL_TO_DIALOG.md for details.


## Version 8.0.1
*Sat, 22 Nov 2025 22:22:51 +0000*
- fix(Modal): Prevent background scrolling when dialog is open. Dialog body auto-focuses for keyboard scrolling with long content.


## Version 8.0.2
*Sun, 23 Nov 2025 19:17:10 +0000*
- fix(Modal): Fix Turbo back/forward navigation bug. Dialogs now close automatically before page caching to prevent broken event listeners.


## Version 8.1.0
*Wed, 26 Nov 2025 14:23:51 +0000*
- feat(Toast): Replace Bootstrap Toast with native Popover API. Flash messages now use browser-native popovers with close button, auto-hide after 6s, positioned top-right. See MIGRATION_TOAST_TO_POPOVER.md.
