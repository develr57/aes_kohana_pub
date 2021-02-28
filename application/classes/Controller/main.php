<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Main extends Controller_Base {

    public function action_index()
    {
        View::set_global('title', 'Список рабочих мест');
        $this->template->content = View::factory('index', array(
            'current_table' =>  ORM::factory('Workplace')->find_all(),
            'def_vars'      =>  ORM::factory('Workplace')->getDefaultVars(),
        ));
    }



    public function action_norights()
    {
        View::set_global('title', 'Нет прав!');
        $this->template->content = View::factory('norights', array(
        ));
    }

} // End Main