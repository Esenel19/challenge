<?php

namespace App\Controller;


use App\Entity\Product;
use App\Entity\Commentaire;
use App\Form\CommentaireFormType;
use App\Controller\ProductController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentaireController extends AbstractController
{
    #[Route('/commentaire', name: 'app_commentaire')]
    public function index(): Response
    {
        return $this->render('commentaire/index.html.twig', [
            'controller_name' => 'CommentaireController',
        ]);
    }

    #[Route('/newCommentaire/{id}', name: 'new_commentaire')]
    public function comment(Request $request,EntityManagerInterface $entityManager,?UserInterface $user, Product $product)
    {
        $commentaire = new Commentaire;
        $form = $this->createForm(CommentaireFormType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $commentaire->setUserId($user);
            $commentaire->setProduitId($product);   
            $commentaire->setCreatedAt(new \DateTimeImmutable);
            $entityManager->persist($commentaire);
            $entityManager->flush();
            return $this->redirectToRoute('app_product');
            
        }

        return $this->render('commentaire/new.html.twig', [
            "commentaireForm" => $form->createView(),
        ]);

    }
}