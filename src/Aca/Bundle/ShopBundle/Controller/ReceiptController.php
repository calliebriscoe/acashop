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

    $db = $this->get('aca.db');

    $session = $this->get('session');

    $OrderComplete = $session->get('OrderComplete');

    $userId = $session->get('user_id');

    $orderId = $session->get('completed_order_id');


  //   $query = 'select o.price, o.quantity, p.name, p.description, p.image from aca_order_product o join aca_product p on (p.product_id = o.product_id)
  //   where order_id = "' . $orderId . '"';
  //
  $order = $this->get('aca.order');
  $products = $order->getProducts();


    $billingAddress = $order->getBillingAddress();
    $shippingAddress = $order->getShippingAddress();

    $session->remove('cart');

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
