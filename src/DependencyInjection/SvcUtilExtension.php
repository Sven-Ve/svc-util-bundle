<?php

namespace Svc\UtilBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class SvcUtilExtension extends Extension
{
  public function load(array $configs, ContainerBuilder $container)
  {
    $rootPath = $container->getParameter("kernel.project_dir");
    $this->createConfigIfNotExists($rootPath);

    $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
    $loader->load('services.xml');

    $configuration = $this->getConfiguration($configs, $container);
    $config = $this->processConfiguration($configuration, $configs);

    // set arguments for __construct in services (mailhelper)
    $definition = $container->getDefinition('svc_util.service.mailhelper');
    $definition->setArgument(0, $config["mailer"]['mail_address']);
    $definition->setArgument(1, $config["mailer"]['mail_name'] ?? null);

    // set arguments for __construct in services (contact form)
    $definition = $container->getDefinition('svc_util.controller.contact');
    $definition->setArgument(0, $config["contact_form"]['enable_captcha']);
    $definition->setArgument(1, $config["contact_form"]['contact_mail']);
    $definition->setArgument(2, $config["contact_form"]['route_after_send']);
    $definition->setArgument(3, $config["contact_form"]['enable_copy_to_me']);
  }

  private function createConfigIfNotExists($rootPath) {
    $fileName= $rootPath . "/config/packages/svc_util.yaml";
    if (!file_exists($fileName)) {
      $text="svc_util:\n";
      $text.="    mailer:\n";
      $text.="        # Default sender mail address\n";
      $text.="        mail_address:         dev@sv-systems.com\n";
      $text.="        # Default sender name\n";
      $text.="        mail_name:\n";
      $text.="    contact_form:\n";
      $text.="        # Enable captcha for contact form?\n";
      $text.="        enable_captcha:       false\n";
      $text.="        # Enable sending a copy of the contact request to me too?\n";
      $text.="        enable_copy_to_me:     true\n";
      $text.="        # Email adress for contact mails\n";
      $text.="        contact_mail:         dev@sv-systems.com\n";
      $text.="        # Which route should by called after mail sent\n";
      $text.="        route_after_send:     index\n";
      file_put_contents($fileName, $text);
      dump ("Please adapt config file $fileName");
    }

    $fileName= $rootPath . "/config/routes/svc_util.yaml";
    if (!file_exists($fileName)) {
      $text="_svc_util:\n";
      $text.="    resource: '@SvcUtilBundle/src/Resources/config/routes.xml'\n";
      $text.="    prefix: /svc-util/{_locale}\n";
      $text.='    requirements: {"_locale": "%app.supported_locales%"}\n';
      file_put_contents($fileName, $text);
    }
  }
}