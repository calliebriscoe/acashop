<?php

  namespace Aca\Bundle\ShopBundle\Shop;

    Class UserInfo extends AbstractOrder
    {

      public function getUserAndPass()
      {

        $username = $_POST['username'];
        // echo '$username=' . $username . '</br>';
        //
        $password = $_POST['password'];
        // echo '$password=' . $password . '</br>';
        //
        $query = 'SELECT * from aca_user where username= "'.$username.'" and password= "'.$password.'"';

        $this->db->setQuery($query);
        return $this->db->loadObject();

      }

      public function UserLogIn()
      {

        $user = $this->getUserAndPass();

          if(empty($user)){
              $this->session->set('logged_in', 0);
              $this->session->set('error_message', 'Login failed please try again');

          } else {
              $this->session->set('logged_in', 1);
              $this->session->set('name', $user->name);
              $this->session->set('user_id',$user->user_id);

          }

          return $user;

      }

      public function UserLogOut()
      {

        return $this->session->clear();

      }

    }

?>
