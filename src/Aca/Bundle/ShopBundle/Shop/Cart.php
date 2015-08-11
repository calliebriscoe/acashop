<?php

namespace Aca\Bundle\ShopBundle\Shop;

  class Cart extends AbstractOrder {

        protected $product;

        protected $grandTotal;

        protected $userSelectedProducts;


      public function __construct($db, $session, $product)
      {

        parent::__construct($db, $session);

        $this->product = $product;

      }

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

        if(empty($cartItems)){
          throw new \Exception("Your cart is Empty!");
        }

        foreach($cartItems as $cartItem) {
          $cartProductIds[] = $cartItem['product_id'];

        }

        return $cartProductIds;

      }

    public function userSelectedProducts()
    {

      if(isset($this->userSelectedProducts)){

            return $this->userSelectedProducts;

      }

      $grandTotal = 0.00;

      $cartItems = $this->session->get('cart');

      $cartProductIds = $this->getProductIds();

      $dbProducts = $this->product->getProductsByProductIds($cartProductIds);


      $userSelectedProducts = [];

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

    $this->grandTotal = $grandTotal;

    $this->userSelectedProducts = $userSelectedProducts;

    if(empty($userSelectedProducts)){
      throw new \Exception("Your cart is Empty!");
    }

    return $this->userSelectedProducts;

  }


    public function grandTotal()
    {

      if(!isset($this->userSelectedProducts)){

          $this->userSelectedProducts = $this->userSelectedProducts();

      }

          return $this->grandTotal;

    }


  }


?>
