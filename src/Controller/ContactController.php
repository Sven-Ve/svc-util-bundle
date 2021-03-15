<?php

namespace Svc\UtilBundle\Controller;

use Svc\UtilBundle\Form\ContactType;
use Svc\UtilBundle\Service\MailerHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller to create a contact form and send the mail
 *
 * @author Sven Vetter <dev@sv-systems.com>
 */
class ContactController extends AbstractController
{

  private $enableCaptcha;
  private $contactMail;
  private $routeAfterSend;

  public function __construct($enableCaptcha, $contactMail, $routeAfterSend)
  {
    $this->enableCaptcha = $enableCaptcha;
    $this->routeAfterSend = $routeAfterSend;
    $this->contactMail = $contactMail;
  }


  public function contactForm(Request $request, MailerHelper $mailHelper): Response
  { 

    $form = $this->createForm(ContactType::class, null, ['enableCaptcha' => $this->enableCaptcha]);
    $form->handleRequest($request);


    if ($form->isSubmitted() && $form->isValid()) {
      $email = trim($form->get('email')->getData());
      $name = trim($form->get('name')->getData());
      $content = trim($form->get('text')->getData());
      $subject = trim($form->get('subject')->getData());

      $html=$this->renderView("@SvcUtil/contact/MT_contact.html.twig", ["content" => $content, "name" => $name, "email" => $email]);
      $text=$this->renderView("@SvcUtil/contact/MT_contact.text.twig", ["content" => $content, "name" => $name, "email" => $email]);

      if ($mailHelper->send($this->contactMail, "Contact form request: " . $subject, $html, $text)) {
        $this->addFlash("success", "Contact request sent.");
        return $this->redirectToRoute($this->routeAfterSend);
      } else {
        $this->addFlash("error", "Cannot send contact request, please try it again.");
      }
    }

    return $this->render('@SvcUtil/contact/contact.html.twig', [
        'form' => $form->createView()
    ]);
  }

  public function mail1Sent(Request $request): Response {
    $newMail=$_GET['newmail'] ?? '?';
    return $this->render('@SvcProfile/profile/changeMail/mail1_sent.html.twig', [
      'newMail' => $newMail
    ]);
  }

}
