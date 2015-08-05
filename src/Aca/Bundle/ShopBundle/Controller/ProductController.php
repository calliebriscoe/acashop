<?php

namespace Aca\Bundle\ShopBundle\Controller;

use Symfony\Component\HttpFoundation\Session\Session;
use Aca\Bundle\ShopBundle\Db\DBCommon;
use Aca\Bundle\ShopBundle\Shop\Product;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
    public function showAction()
    {

                $product = $this->get('aca.product');

                $products = $product->getAllProduct();

                return $this->render('AcaShopBundle:Product:list.html.twig',
                  array(
                    'products' => $products
                  )
                );


                // echo '<pre>';
                // print_r($product);
      }


}
