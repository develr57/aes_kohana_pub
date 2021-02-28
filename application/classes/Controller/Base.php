<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Base extends Controller_Template {

    public $template  = 'templates/main';
    protected $session;
    protected $auth;

    public function before()
    {
        $this->session = Session::instance();
        $this->session->set('auth_redirect', $_SERVER['REQUEST_URI']);
        $this->auth = Auth::instance();
        if ($this->auth->logged_in() == 0)  $this->redirect('/auth');
        View::set_global('auth', $this->auth);
        View::set_global('user', $this->auth->get_user());
        //return parent::before();
        parent::before();

        function getAuth()
        {
            global $auth;
            return $auth;
        }
    }

    public function after()
    {
        // echo 'after';
        parent::after();
    }
    
} // End Base