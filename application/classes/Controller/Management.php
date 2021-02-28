<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Management extends Controller_Base {

    public function action_base()
    {   
        View::set_global('title', 'Управление базой');
        $this->template->content = View::factory('management/base_management');
    }


} // End Management