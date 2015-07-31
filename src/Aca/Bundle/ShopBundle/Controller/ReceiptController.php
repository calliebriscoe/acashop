<?php
namespace Aca\Bundle\ShopBundle\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Aca\Bundle\ShopBundle\Db\DBCommon;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ReceiptController extends Controller
{

  public function receiptAction()
  {
    $session = $this->get('session');
    $userId = $session->get('user_id');
    $all = $session->all();
    $orderId = $session->get('completed_order_id');
    $db = $this ->get('aca.db');

    $orderQuery = 'select * from aca_order_address where order_id = "' . $orderId . '"';

    $db->setQuery($orderQuery);
    $orderAddresses = $db->loadObjectList();

    $billingAddress = null;
    $shippingAddress = null;

    foreach ($orderAddresses as $orderAddress) {
      if ($orderAddress->type == 'BILLING') {

      $billingAddress = $orderAddress;

    }else{

      $shippingAddress = $orderAddress;

    }
  }


    $query = 'select o.price, o.quantity, p.name, p.description, p.image from aca_order_product o join aca_product p on (p.product_id = o.product_id)
    where order_id = "' . $orderId . '"';

    $db->setQuery($query);
    $products = $db->loadObjectList();


    return $this->render('AcaShopBundle:Receipt:receipt.html.twig',
    array(
      'orderId' => $orderId,
      'billing' => $billingAddress,
      'shipping' => $shippingAddress,
      'products' => $products


    ));

    // die();
    //
    // $cartItems = $session->get('cart');
    // $cartProductIds = [];
    //
    // foreach($cartItems as $cartItem) {
    //   $cartProductIds[] = $cartItem['product_id'];
    //
    // }
    // $cartQuery = 'select * from aca_product where product_id in(' . implode(',', $cartProductIds) . ')';
    //
    // $db->setQuery($cartQuery);
    // $dbProducts = $db->loadObjectList();



  }
}
