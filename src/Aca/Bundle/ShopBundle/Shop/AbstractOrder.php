<?php

namespace Aca\Bundle\ShopBundle\Shop;

  abstract class AbstractOrder {

    // @var DBCommon
    protected $db;

    // @var Session
    protected $session;

    public function __construct($db, $session)
    {
      $this->db = $db;
      $this->session = $session;

    }

  }


?>
