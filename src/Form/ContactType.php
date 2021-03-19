<?php

namespace Svc\UtilBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaV3Type;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\IsTrueV3;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ContactType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
      $builder
        ->add('subject', TextType::class, ['label' => 'Subject', "attr" => ["autofocus"=>true]])
        ->add('text', TextareaType::class, ['label' => 'Your message', "attr" => ["rows"=>6]])
        ->add('name', TextType::class, [
          'label' => 'Your name', 
          'attr' => ['placeholder' => 'Firstname Lastname']
        ])
        ->add('email', EmailType::class, ['label' => 'Your mail'])
      ;

      if ($options['enableCaptcha']) {
        $builder->add('recaptcha', EWZRecaptchaV3Type::class, [ 
          "action_name" => "form",
          'constraints' => array(new IsTrueV3())
        ]);
      }
        
      $builder
        ->add('Send',SubmitType::class, ['attr' => ['class' => 'btn btn-lg btn-primary btn-block']])
      ;
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'enableCaptcha' => null,
      'translation_domain' => 'UtilBundle'
    ]);
  }
}
