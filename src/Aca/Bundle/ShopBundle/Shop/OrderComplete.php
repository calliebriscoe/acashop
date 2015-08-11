<?php

namespace Aca\Bundle\ShopBundle\Shop;

  class OrderComplete extends AbstractOrder {


    public function getProducts()
    {

      $orderId = $this->session->get('completed_order_id');

      $orderQuery = 'select o.price, o.quantity, p.name, p.description, p.image from aca_order_product o join aca_product p on (p.product_id = o.product_id)
      where order_id = "' . $orderId . '"';

      $this->db->setQuery($orderQuery);

      return $this->db->loadObjectList();

    }

    protected function getAddress($type)
    {
      $orderId = $this->session->get('completed_order_id');

      $orderQuery = 'select * from aca_order_address where order_id = "' . $orderId . '" and type = "'. $type .'"';

      $this->db->setQuery($orderQuery);

      return $this->db->loadObject();


    }

    public function getBillingAddress()
    {
      return $this->getAddress('billing');

      // $orderId = $this->session->get('completed_order_id');
      //
      // $orderQuery = 'select * from aca_order_address where order_id = "' . $orderId . '"';
      //
      // $db->setQuery($orderQuery);
      // $orderAddresses = $db->loadObjectList();
      //
      // $billingAddress = null;
      // $shippingAddress = null;
      //
      // foreach ($orderAddresses as $orderAddress) {
      //   if ($orderAddress->type == 'billing') {
      //
      //   $billingAddress = $orderAddress;
      //
      // }else{
      //
      //   $shippingAddress = $orderAddress;
      // }
      // }
      }

      public function getShippingAddress()
      {

        return $this->getAddress('shipping');

        // $orderId = $this->session->get('completed_order_id');
        //
        // $orderQuery = 'select * from aca_order_address where order_id = "' . $orderId . '"';
        //
        // $db->setQuery($orderQuery);
        // $orderAddresses = $db->loadObjectList();
        //
        // $billingAddress = null;
        // $shippingAddress = null;
        //
        // foreach ($orderAddresses as $orderAddress) {
        //   if ($orderAddress->type == 'billing') {
        //
        //   $billingAddress = $orderAddress;
        //
        // }else{
        //
        //   $shippingAddress = $orderAddress;
        //
        // }
        // }
        }




  }


?>
