<?php

namespace App\Controller;


use App\Entity\Product;
use App\Entity\Commentaire;
use App\Form\ProductFormType;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CommentaireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{


    #[Route('/product', name: 'app_product')]
    public function index(ProductRepository $repo): Response
    {
        $products = $repo -> findAll();
        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
        
    }

    #[Route('/newProduct', name: 'new_product')]
    public function new(Request $request, EntityManagerInterface $entityManager, ?UserInterface $user) 
    {
        $product = new Product;
        $form = $this->createForm(ProductFormType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $product->setUser($user);
            $product->setCreatedAt(new \DateTimeImmutable);
            $entityManager->persist($product);
            $entityManager->flush();
            

            $this->addFlash("success", "Article bien créé, en attente de validation par un modérateur");
            return $this->redirectToRoute("app_product");
        }

        return $this->render('product/new.html.twig', [
            "productForm" => $form->createView(),
        ]);

    }

    #[Route('/detail/{id}', name: 'product_show')]
    public function show(Product $product, CommentaireRepository $repo)
    {

        $commentaires = $repo->findBy(["produit_id"=> $product->getId()]);
        return $this->render('product/show.html.twig', [
            'product' => $product,
            'commentaires' => $commentaires
        ]);
    }
    

}