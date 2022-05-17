<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\CartService;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{

    #[Route('/cart', name: 'app_cart')]
    public function index(RequestStack $rs, ProductRepository $repo): Response
    {
        $session = $rs->getSession();
        $panier = $session->get('panier', []);
        $qt = 0;

        $panierWithData = [];

        foreach ($panier as $id => $quantite) {
            $panierWithData[] = [
                'product' => $repo->find($id),
                'quantity' => $quantite
            ];
            $qt += $quantite;
        }

        $session->set('qt', $qt);
        $total = 0;

        foreach ($panierWithData as $item) {
            $totalItem = $item['product']->getPrice() * $item['quantity'];
            $total += $totalItem;
        }

        return $this->render('cart/index.html.twig', [
            'items' => $panierWithData,
            'total' => $total
        ]);
    }

    /**
     * @Route("/cart/add/{id}", name="cart_add")
     */
    public function add($id,Product $product,RequestStack $rs)
    {
        // On récupère le panier actuel
        $session = $rs->getSession();
        $panier = $session->get('panier', []);
        $id = $product->getId();

        if(!empty($panier[$id])){
            $panier[$id]++;
        }else{
            $panier[$id] = 1;
        }

        // On sauvegarde dans la session
        $session->set("panier", $panier);

        return $this->redirectToRoute(('app_cart'));
    }

    /**
     * @Route("/cart/substract/{id}", name="cart_substract")
     */

    public function substract($id,Product $product,RequestStack $rs)
    {
        // On récupère le panier actuel
        $session = $rs->getSession();
        $panier = $session->get('panier', []);
        $id = $product->getId();

        if(!empty($panier[$id])){
            if($panier[$id] > 1){
                $panier[$id]--;
            }else{
                unset($panier[$id]);
            }
        }

        // On sauvegarde dans la session
        $session->set("panier", $panier);

        return $this->redirectToRoute(('app_cart'));
    }

    /**
     * @Route("/cart/remove/{id}", name="cart_remove")
     */
    public function remove($id, RequestStack $rs)
    {
        $session = $rs->getSession();
        $panier = $session->get('panier', []);

        if (!empty($panier[$id]))
            unset($panier[$id]);
        $session->set('panier', $panier);
        return $this->redirectToRoute('app_cart');
    }

    /**
     * @Route("/cart/removeAll/", name="cart_remove_all")
     */
    public function removeAll(RequestStack $rs)
    {
        $session = $rs->getSession();
        $panier = $session->get('panier', []);

        if (!empty($panier))
            unset($panier);
        $session->remove('panier');
        return $this->redirectToRoute('app_cart');
    }

        /**
     * @Route("/cart/acheter/", name="cart_achat")
     */
    public function acheter(RequestStack $rs)
    {
        $session = $rs->getSession();
        $panier = $session->get('panier', []);

        if (!empty($panier))
            unset($panier);
        $session->remove('panier');
        return $this->redirectToRoute('app_cart_achat');
    }

    /**
     * @Route("/cart/achat/", name="app_cart_achat")
     */
    public function achat()
    {
        return $this->render('cart/achat.html.twig');
    }
}
