<?php

namespace Aca\Bundle\ShopBundle\Shop;

  class Cart extends AbstractOrder {



      public function removeItem($productId)
      {
        $cartItems = $this->session->get('cart');


          foreach($cartItems as $index => $cartItem){
             if($cartItem['product_id'] == $productId) {
                  unset($cartItems[$index]);
             }
          }

          $this->session->set('cart',$cartItems);

          $didRemove = true;

          foreach($cartItems as $index => $cartItem){
             if($cartItem['product_id'] == $productId) {
                  $didRemove = false;
             }
          }

          if(!$didRemove){
          throw new \Exception('Cannot delete from Cart!');
        }


            return $didRemove;


      }

      public function updateItem($productId, $updatedQuantity)
      {

        $cartItems = $this->session->get('cart');

        foreach($cartItems as $index => $cartItem){

          if($cartItem['product_id'] == $productId) {
               $cartItems[$index]['quantity'] = $updatedQuantity;
          }

        }
        $this->session->set('cart',$cartItems);

      }

      public function getProductIds()
      {

        $cartItems = $this->session->get('cart');

        $cartProductIds = [];

        foreach($cartItems as $cartItem) {
          $cartProductIds[] = $cartItem['product_id'];

        }

        return $cartProductIds;

      }

      public function grandTotal($cartItems, $dbProducts, $cartProductIds)
      {


        $grandTotal = 0.00;

            foreach($dbProducts as $dbProduct) {

              foreach($cartItems as $cartItem) {

                if($dbProduct->product_id == $cartItem['product_id']){
                  $dbProduct->quantity = $cartItem['quantity'];

                  $dbProduct->total_price = $dbProduct->price * $cartItem['quantity'];
                  $grandTotal += $dbProduct->total_price;

                  }

        }

      }
      return $grandTotal;

    }

    public function userSelectedProducts($cartItems, $dbProducts, $cartProductIds)
    {


      $userSelectedProducts = [];

          foreach($dbProducts as $dbProduct) {

            foreach($cartItems as $cartItem) {

              if($dbProduct->product_id == $cartItem['product_id']){
                $dbProduct->quantity = $cartItem['quantity'];

                $dbProduct->total_price = $dbProduct->price * $cartItem['quantity'];

                $userSelectedProducts[] = $dbProduct;
                }

      }

    }
    return $userSelectedProducts;

  }


  }


?>
