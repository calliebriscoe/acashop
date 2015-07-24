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
                // echo 'Product-Id=' . $productId . '<br/>';

                $quantity = $_POST['quantity'];
                // echo 'Quantity=' . $quantity . '<br/>';

                if(empty($cart)){

                  $cart[] = array(
                    'product_id' => $productId,
                    'quantity' => $quantity
                  );
                }else{

                  $existingItem = false;

                  foreach($cart as &$cartItem){
                     if($cartItem['product_id'] == $productId) {
                       $existingItem = true;
                       $cartItem['quantity'] += $quantity;

                     }
                  }
                  //brand new item
                  if($existingItem == false){
                    $cart[] = array(
                      'product_id' => $productId,
                      'quantity' => $quantity
                    );
                  }


                }
                $session->set('cart',$cart);
                return new RedirectResponse('/cart');
      }
        public function showAction()
        {

          $db = $this ->get('aca.db');
          $session = $this->get('session');

          $cartItems = $session->get('cart');


          $cartProductIds = [];

          foreach($cartItems as $cartItem) {
            $cartProductIds[] = $cartItem['product_id'];

          }
          $query = 'select * from aca_product where product_id in(' . implode(',', $cartProductIds) . ')';


          $db->setQuery($query);
          $dbProducts = $db->loadObjectList();

          $userSelectedProducts = [];

          $grandTotal = 0.00;

          foreach($dbProducts as $dbProduct) {

              foreach($cartItems as $cartItem) {

                if($dbProduct->product_id == $cartItem['product_id']){
                  $dbProduct->quantity = $cartItem['quantity'];

                  $dbProduct->total_price = $dbProduct->price * $cartItem['quantity'];
                  $grandTotal += $dbProduct->total_price;

                  $userSelectedProducts[] = $dbProduct;
                }

              }
          }

                      // foreach($cartItems as $cartitem) {
                      //
                      // }

          return $this->render('AcaShopBundle:Cart:list.html.twig',
            array(
              'products' => $userSelectedProducts,
              'grandTotal' => $grandTotal


            )
          );
        }

        public function removeAction(){

          $productId = $_POST['product_id'];

          $session = $this->get('session');

          $cartItems = $session->get('cart');


            foreach($cartItems as $index => $cartItem){
               if($cartItem['product_id'] == $productId) {
                    unset($cartItems[$index]);
               }
            }
            $session->set('cart',$cartItems);
            return new RedirectResponse('/cart');

          }

          public function updateAction()
          {

            $session = $this->get('session');

            $cartItems = $session->get('cart');

            $productId = $_POST['product_id'];
                        // echo 'Product-Id=' . $productId . '<br/>';

            $updatedQuantity = $_POST['quantity'];
                        // echo 'Quantity=' . $quantity . '<br/>';

            foreach($cartItems as $index => $cartItem){

              if($cartItem['product_id'] == $productId) {
                   $cartItems[$index]['quantity'] = $updatedQuantity;
              }

            }
            $session->set('cart',$cartItems);
            return new RedirectResponse('/cart');
          }




}
