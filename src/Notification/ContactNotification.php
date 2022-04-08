<?php

    namespace App\Notification;

use ContainerLamYbvP\getSwiftmailer_Mailer_DefaultService;
use Twig\Environment;
use Symfony\Component\Mime\Email;

    class ContactNotification{

        private $mailer;
        private $rendered;


        public function __construct(\Swift_Mailer $mailer, Environment $rendered)
        {
            $this->mailer=$mailer;

            $this->rendered=$rendered;
        }
        
        public function notify($contact)
        {
            $message = (new \Swift_Message('Agence : ' . $contact->setProperty()->getTitle()))
            ->setFrom('noreply@agence.fr')
            ->setTo('contact@agence.fr')
            ->setReplyTo($contact->getEmail())
            ->setBody($this->rendered->render('emails/contact.html.twig', [
                'contact'=> $contact
            ]), 'text/html');

            $this->mailer->send($message);
        }
    }


?>