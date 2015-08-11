<?php

namespace Aca\Bundle\ShopBundle\Controller;

use Symfony\Component\HttpFoundation\Session\Session;
use Aca\Bundle\ShopBundle\Db\DBCommon;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {



        // $db = $this->get('aca.db');
        //
        $session = $this->get('session');
        //
        $name = $session->get('name');
        //
        $logged_in = $session->get('logged_in');

        $errrorMessage = $session->get('error_message');

        // $logged_in = isset($_SESSION['logged_in']) ? $_SESSION['logged_in'] : 0;

        // $name = isset($_SESSION['name']) ? $_SESSION['name'] : null;

        return $this->render('AcaShopBundle:Home:index.html.twig',
          array(
            'logged_in' => $logged_in,
            'name' => $name,
            'errrorMessage' => $errrorMessage
          )

        );
    }

            // This logs the user in
            public function loginAction()
            {
                $userInfo = $this->get('aca.userinfo');

                $userInfo->UserLogIn();

                return new RedirectResponse('/product');

            }

            public function logoutAction()
            {

              $userInfo = $this->get('aca.userinfo');

              $userInfo->UserLogOut();

              return new RedirectResponse('/');

            }
}
