<?php

namespace App\Controller;


use App\Entity\Product;
use App\Entity\Commentaire;
use App\Form\RechercheType;
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
    public function index(ProductRepository $repo, Request $request): Response
    {
        $form = $this->createForm(RechercheType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $data = $form->get('recherche')->getData();
            $products = $repo->getActiviteByName($data);
            
        }else {
            
            $products = $repo -> findAll();
            
        }

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'formRecherche' => $form->createView(),
        ]);
        
    }

    #[Route('/newProduct', name: 'new_product')]
    public function new(Request $request, EntityManagerInterface $entityManager, ?UserInterface $user) 
    {
        $product = new Product;
        $form = $this->createForm(ProductFormType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $brochureFile = $form->get('image')->getData();
            $product->setUser($user);
            $product->setCreatedAt(new \DateTimeImmutable);
            $entityManager->persist($product);
            $entityManager->flush();
            

            $this->addFlash("success", "Article bien créé, en attente de validation par un modérateur");
            return $this->redirectToRoute("app_product");
                if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $product->setImage($newFilename);
            }

            // ... persist the $product variable or any other work

            return $this->redirectToRoute('app_product_list');
        }

        return $this->renderForm('product/new.html.twig', [
            'productForm' => $form,
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