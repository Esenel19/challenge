<?php

namespace App\Controller;


use App\Repository\CategorieRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="app_categorie")
     */
    public function index()
    {
        return $this->render('categorie/index.html.twig', [
            'title' => 'Categorie'
        ]);
    }
}
