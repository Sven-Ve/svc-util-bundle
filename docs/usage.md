Usage
=====

* adapt the default url prefix in config/routes/svc_util.yaml and enable translation (if you like it)

```yaml
# /config/routes/svc_util.yaml
_svc_util:
    resource: '@SvcUtilBundle/src/Resources/config/routes.xml'
    prefix: /svc-profile/{_locale}
    requirements: {"_locale": "%app.supported_locales%"}
```

* integrate the contact controller via path "svc_util.controller.contact"
* Configure in /config/packages/svc_util.yaml
  * enable captcha (if installed and configured), default = false
  * ...

```yaml
# /config/packages/svc_util.yaml
svc_util:
    mailer:
        # Default sender mail address
        mail_address:       dev@sv-systems.com
        # Default sender name
        mail_name:          TestBundle Sender
    contact_form:
        # Enable captcha for contact form?
        enable_captcha:      true
        # Enable sending a copy of the contact request to me too?
        enable_copy_to_me:  true
        # Email adress for contact mails
        contact_mail:       dev@sv-systems.com
        # Which route should by called after mail sent
        route_after_send:   index
```
