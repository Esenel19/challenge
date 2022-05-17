<?php

namespace App\Controller;

use DateTimeInterface;
use App\Entity\Contact;
use App\Form\ContactFromType;
use Doctrine\ORM\EntityManagerInterface;
use App\Notification\ContactNotification;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{

    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request, EntityManagerInterface $manager, ContactNotification $notification)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactFromType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contact->setCreatedAt(new \DateTimeImmutable);
            $notification->notify($contact);
            $this->addFlash('success', 'Votre Email a bien été envoyé');
            $manager->persist($contact);
            $manager->flush();
        }

        return $this->render("contact/index.html.twig", [
            'formContact' => $form->createView()
        ]);
        
    }
}
