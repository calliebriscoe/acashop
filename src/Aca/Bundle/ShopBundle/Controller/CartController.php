<?php

namespace Aca\Bundle\ShopBundle\Controller;

use Symfony\Component\HttpFoundation\Session\Session;
use Aca\Bundle\ShopBundle\Db\DBCommon;
use Aca\Bundle\ShopBundle\Shop\Cart;
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


          $cart = $this->get('aca.cart');

          $userSelectedProducts = $cart->userSelectedProducts();

          $grandTotal = $cart->grandTotal();


          return $this->render('AcaShopBundle:Cart:list.html.twig',
            array(
              'products' => $userSelectedProducts,
              'grandTotal' => $grandTotal


            )
          );
        }

        public function removeAction(){

          $productId = $_POST['product_id'];


          $productRemove = $this->get('aca.cart');

          $productRemoved = $productRemove->removeItem($productId);

            return new RedirectResponse('/cart');


          }

          public function updateAction()
          {
            $productId = $_POST['product_id'];

            $updatedQuantity = $_POST['quantity'];
            // echo 'Quantity=' . $quantity . '<br/>';

            $productUpdate = $this->get('aca.cart');

            $productUpdated = $productUpdate->updateItem($productId, $updatedQuantity);

            return new RedirectResponse('/cart');
          }

          public function shippingaddressAction()
          {
            $session = $this->get('session');

            $userId = $session->get('user_id');

            if(empty($userId)){

              $session->set('error_message', 'Please login again.');

              return new RedirectResponse('/');

            }


            $all = $session->all();

            $db = $this ->get('aca.db');

            $query = 'select shipping_address_id,billing_address_id from aca_user where user_id = ' . $userId;

            $db->setQuery($query);
            $shippingIds = $db->loadObject();

            $billingAddressId = $shippingIds->billing_address_id;
            $shippingAddressId = $shippingIds->shipping_address_id;

            $shippingQuery = 'select * from aca_address where address_id =' . $shippingAddressId;

            $billingQuery = 'select * from aca_address where address_id =' . $billingAddressId;

            $db->setQuery($shippingQuery);
            $shippingAddress = $db->loadObject();

            $db->setQuery($billingQuery);
            $billingAddress = $db->loadObject();

            return $this->render('AcaShopBundle:Shipping:address.html.twig',
            array(
              'billing' => $billingAddress,
              'shipping' => $shippingAddress

            ));

            echo '<pre>';
            print_r($all);


          }

}
