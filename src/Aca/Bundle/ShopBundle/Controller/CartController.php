<?php

namespace Aca\Bundle\ShopBundle\Controller;

use Symfony\Component\HttpFoundation\Session\Session;
use Aca\Bundle\ShopBundle\Db\DBCommon;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CartController extends Controller
{
    public function addAction()
    {
                $session = $this->get('session');

                $cart = $session->get('cart');

                $productId = $_POST['product_id'];
                echo 'Product-Id=' . $productId . '<br/>';

                $quantity = $_POST['quantity'];
                echo 'Quantity=' . $quantity . '<br/>';

                if(!empty($cart)){

                  $cart[] = array(
                    'product_id' => $productId,
                    'quantity' => $quantity
                  );
                }else{

                  $existingItem = false;
                  
                  foreach($cart as $cartItem){
                     if(cartItem['product_id'] == $productId) {
                       $existingItem = true;
                       $cartItem['quantity'] += $quantity;

                     }
                  }
                  //brand new item
                  if($existingItem = false){
                    $cart[] = array(
                      'product_id' => $productId,
                      'quantity' => $quantity
                    );
                  }


                }
                $session->set('cart',$cart);
      }


}
