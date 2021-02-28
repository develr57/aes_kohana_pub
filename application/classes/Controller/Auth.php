<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Auth extends Controller_Template
{
    public $template  = 'templates/main';

    public function before()
    {
        $auth = Auth::instance();
        View::set_global('auth', $auth);
        View::set_global('user', $auth->get_user());
        parent::before();
    }

    public function after()
    {
        parent::after();
    }


    
    public function action_index()
    {
        if (isset($_POST['GO']))
        {
            $login      = trim(Arr::get($_POST, 'login', ''));
            $password   = trim(Arr::get($_POST, 'password', ''));

            $auth = Auth::instance();
            if ($auth->login($login, $password))
            {
                $this->redirect('/');
            }
            else
            {
                $result = array(
                    'res_status'    => 'fail',
                    'res_message'   => 'Неверный логин или пароль...',
                );
            }
        }

        View::bind_global('result', $result);
        View::set_global('title', 'Авторизация');
        $this->template->content = View::factory('auth', array(
            'field_login'       => 'Логин',
            'field_password'    => 'Пароль',
        ));
    }



    public function action_hpass()
    {
        View::set_global('title', 'Хэширование');
        $auth = Auth::instance();
        $this->template->content = $auth->hash_password('samat123');
    }



    public function action_logout()
    {
        $auth = Auth::instance()->logout();
        $this->redirect('/');
    }

}