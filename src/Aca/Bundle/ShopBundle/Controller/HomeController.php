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
        


        $db = $this->get('aca.db');

        $session = $this->get('session');

        $name = $session->get('name');

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
                $session = $this->get('session');

                $username = $_POST['username'];
                // echo '$username=' . $username . '</br>';

                $password = $_POST['password'];
                // echo '$password=' . $password . '</br>';

                $query = 'SELECT * from aca_user where username= "'.$username.'" and password= "'.$password.'"';

                $db = $this->get('aca.db');

                $db->setQuery($query);
                $user = $db->loadObject();

                if(empty($user)){
                  $session->set('logged_in', 0);
                  $session->set('error_message', 'Login failed please try again');

                } else {
                  $session->set('logged_in', 1);
                  $session->set('name', $user->name);
                  $session->set('user_id',$user->user_id);
                }



                return new RedirectResponse('/');

            }

            public function logoutAction()
            {
              $session = $this->get('session');

              $session->clear();

              return new RedirectResponse('/');

            }
}
