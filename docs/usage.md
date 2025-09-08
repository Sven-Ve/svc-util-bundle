Usage
=====

* adapt the default url prefix in config/routes/svc_util.yaml and enable translation (if you like it)

```yaml
# /config/routes/svc_util.yaml
_svc_util:
    resource: '@SvcUtilBundle/config/routes.php'
    prefix: /svc-profile/{_locale}
```

* Configure in /config/packages/svc_util.yaml
  * set your sender mail address
  * set your sender mail name

```yaml
# /config/packages/svc_util.yaml
svc_util:
    mailer:
        # Default sender mail address
        mail_address:       test@test.com
        # Default sender name
        mail_name:          TestBundle Sender
```
