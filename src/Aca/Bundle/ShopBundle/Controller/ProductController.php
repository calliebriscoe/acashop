<?php

namespace Aca\Bundle\ShopBundle\Controller;

use Symfony\Component\HttpFoundation\Session\Session;
use Aca\Bundle\ShopBundle\Db\DBCommon;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
    public function showAction()
    {
                $db = $this->get('aca.db');

                $query = 'select * from aca_product';

                $db->setQuery($query);
                $products = $db->loadObjectList();


                return $this->render('AcaShopBundle:Product:list.html.twig',
                  array(
                    'products' => $products
                  )
                );


                // echo '<pre>';
                // print_r($product);
      }


}
