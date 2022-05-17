<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Product;
use App\Repository\UserRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(): Response
    {
        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
        ]);
    }

    #[Route('/profil/productUser', name: 'product_user')]
    public function productUser(ProductRepository $repo, ?UserInterface $user)
    {
        $productsUser = $repo->findAll();
        return $this->render('profil/productUser.html.twig', [
            'productsUser' => $productsUser, 
            'user' => $user
        ]);
    }

}