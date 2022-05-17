<?php

namespace App\Service;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{
    private $repo;
    private $rs;

    //injection dependance hors controller : constructeur

    public function __construct(ProductRepository $repo, RequestStack $rs) 
    {

        $this->repo = $repo;
        $this->rs = $rs;
    }

    public function add($id)
    {
        //requestStack est une classe qui contient le session
        $session = $this -> rs->getSession();

         $cart = $session->get('cart',[]);
         //recupere l'attr de session 'cart' sil existe, ou un tableau vite

         // si produit deja add sa l'incremente 

        if(!empty($cart[$id]))
             $cart[$id]++;
            
         else {
             $cart[$id] = 1;
         }


        $session->set('cart', $cart);
        //je sauvgarde l'etat de mon panier en session a l'attr de session 'cart'

         // dd($session->get('cart'));
         //dd = dump & die : afficher des infos et tuer l'execution du code
         //  return $this->redirectToRoute('app_cart');
    }

    public function remove($id)
    {
        $session =$this->rs->getSession();
        $cart = $session->get('cart', []);

        // si id existe dans panier, je supp du tab via unset()

        if(!empty($cart[$id]))
            unset($cart[$id]);

        $session->set('cart', $cart);
        
    }

    public function getCartWithData()
    {
        $session =$this->rs->getSession();
        $cart = $session->get('cart', []);
        $cartWitchData=[];
        $qt = 0;

        // qt contiendra le nb total de produits
        // je vais crer un nouveau tableau qui contiendra des objects Product et les quantite

        

        // $cartWitchData = tab multidimentionnel : chaque case est un tab de 2 cases

        foreach ($cart as $id => $quantity) 
        {
            $cartWitchData[] = [
                'product' =>$this->repo->find($id),
                'quantity' => $quantity
            ];
            $qt += $quantity;
        }
        $session->set('qt', $qt);
        return $cartWitchData;
    }

    public function getTotal()
    {
        $total = 0;
        foreach ($this->getCartWithData() as $item) {
            $totalItem = $item['product']->getPrice() * $item['quantity'];
            $total += $totalItem;
        }
        return $total;    
    }
  
}
