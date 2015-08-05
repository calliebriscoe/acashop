<?php

use Symfony\Component\HttpFoundation\Session\Session;
use Aca\Bundle\ShopBundle\Db\DBCommon;
use Aca\Bundle\ShopBundle\Shop\Product;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

namespace Aca\Bundle\ShopBundle\Shop;

  class Product {

    // DBCommon
    protected $db;

    public function __construct($db)
    {
      $this->db = $db;

    }

    public function getAllProduct()
    {
      $query = 'select * from aca_product';

      $this->db->setQuery($query);
      $product = $this->db->loadObjectList();

      return $product;
    }

    public function getProductsByProductIds($productIds)
    {

      $query = 'select * from aca_product where product_id in(' . implode(',', $productIds) . ')';

      $this->db->setQuery($query);
      $dbProducts = $this->db->loadObjectList();

      return $dbProducts;

    }

  }


?>
