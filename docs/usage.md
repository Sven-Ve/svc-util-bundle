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
* enable captcha (if installed and configured), default = false

```yaml
# /config/packages/svc_util.yaml
svc_util:
    # Enable captcha for contact form?
    enableCaptcha: true
```
