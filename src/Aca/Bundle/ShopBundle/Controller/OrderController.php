<?php
namespace Aca\Bundle\ShopBundle\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Aca\Bundle\ShopBundle\Db\DBCommon;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
class OrderController extends Controller
{

  public function placeorderAction()
  {
    $session = $this->get('session');
    $userId = $session->get('user_id');
    $all = $session->all();

    $db = $this ->get('aca.db');
    $orderQuery = 'insert into aca_order(user_id) values(' . $userId . ')';

    $db->setQuery($orderQuery);
    $db->query();

    $orderId = $db->getLastInsertId();

    $session->set('completed_order_id', $orderId);


    $billingStreet = $_POST['billing_street'];
    $billingCity = $_POST['billing_city'];
    $billingState = $_POST['billing_state'];
    $billingZip = $_POST['billing_zip'];

    $shippingStreet = $_POST['shipping_street'];
    $shippingCity = $_POST['shipping_city'];
    $shippingState = $_POST['shipping_state'];
    $shippingZip = $_POST['shipping_zip'];


    $billingQuery = 'insert into aca_order_address(order_id, type, street, city, state, zip)
    values("'. $orderId .'","billing","'. $billingStreet .'","'. $billingCity .'","'. $billingState .'","'. $billingZip .'")';

    $db->setQuery($billingQuery);
    $db->query();

    $shippingQuery = 'insert into aca_order_address(order_id, type, street, city, state, zip)
    values("'. $orderId .'","shipping","'. $shippingStreet .'","'. $shippingCity .'","'. $shippingState .'","'. $shippingZip .'")';
    $db->setQuery($shippingQuery);
    $db->query();


    $cartItems = $session->get('cart');
    $cartProductIds = [];

    foreach($cartItems as $cartItem) {

      $cartProductIds[] = $cartItem['product_id'];
    }

    $query = 'select * from aca_product where product_id in(' . implode(',', $cartProductIds) . ')';

    $db->setQuery($query);
    $dbProducts = $db->loadObjectList();


    foreach($dbProducts as $dbProduct) {

        foreach($cartItems as $cartItem) {

          if($dbProduct->product_id == $cartItem['product_id']){

            $productId = $dbProduct->product_id;
            $quantity = $cartItem['quantity'];
            $productPrice = $dbProduct->price * $cartItem['quantity'];

            $query = 'insert into aca_order_product(order_id, product_id, quantity, price)
            values("'. $orderId .'","'. $productId .'","'. $quantity .'","'. $productPrice .'")';

            $db->setQuery($query);
            $dbProducts = $db->query();
          }
        }
      }

          return new RedirectResponse('/receipt');
  
  }
}
