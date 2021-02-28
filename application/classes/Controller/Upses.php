<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Upses extends Controller_Base {

    public function before()
    {
        parent::before();
    }

    public function after()
    {
        parent::after();
    }






    public function action_index()
    {
        View::set_global('title', 'Таблица ИБП');
        $this->template->content = View::factory('management/upses_management', array(
            'current_table' =>  ORM::factory('Ups')->find_all(),
            'def_vars'      =>  ORM::factory('Ups')->getDefaultVars(),
        ));

    }





    public function action_add()
    {
        if ($this->auth->logged_in('admin'))
        {
            if (isset($_POST['GO']))
            {    
                $to_add = array(
                    'devtype_id'    => (int) trim($_POST['devtype_id']),
                    'vendor_id'     => (int) trim($_POST['vendor_id']),
                    'model'         =>       trim($_POST['model']),
                    'bat_id'        => (int) trim($_POST['bat_id']),
                    'bat_count'     => (int) trim($_POST['bat_count']),
                    'location_id'   => (int) trim($_POST['location_id']),
                    'status_id'     => (int) trim($_POST['status_id']),
                    'fa'            =>       trim($_POST['fa']),
                    'inv_num'       =>       trim($_POST['inv_num']),
                    'inv_status'    =>       trim($_POST['inv_status']),
                    'com_date'      =>       trim($_POST['com_date']),
                    'note'          =>       trim($_POST['note']),
                );

                $result = ORM::factory('Ups')->addUps($to_add);
            }

            View::set_global('title', 'Добавление ИБП');
            View::set_global('oper_type', 'add');
            View::set_global('def_vars', ORM::factory('Ups')->getDefaultVars());
            View::bind_global('result', $result);
            $this->template->set_filename('templates/forms_common');

            $devgroup = ORM::factory('Devgroup')
                ->where('devgroup_name', '=', 'ИБП')
                ->find();
            
            $this->template->content = View::factory('management/forms/upses_form', array(
                
                'select_devtypes'   => ORM::factory('Devtype')
                    ->where('devgroup_id', '=', $devgroup->devgroup_id)
                    ->find_all(),

                'select_vendors'    => ORM::factory('Vendor')
                    ->order_by('vendor_name')
                    ->find_all(),

                'select_locations'  => ORM::factory('Location')
                    ->find_all(),

                'select_statuses'   => ORM::factory('Status')
                    ->find_all(),

                'select_battypes'   => ORM::factory('Battery')
                    ->find_all(),

            ));
        }
        else
        {
            $this->redirect('/main/norights');
        }

    } // End add_Action






    public function action_edit()
    {
        if ($this->auth->logged_in('admin'))
        {
            $id = (int) $this->request->param('id');
            if ($id)
            {
                $editable_line = ORM::factory('Ups', $id);
                if ($editable_line->loaded())
                {
                    $result = array(
                        'id'            => $id,
                        'devtype_id'    => $editable_line->devtype_id,
                        'vendor_id'     => $editable_line->vendor_id,
                        'model'         => $editable_line->model,
                        'bat_id'        => $editable_line->bat_id,
                        'bat_count'     => $editable_line->bat_count,
                        'location_id'   => $editable_line->location_id,
                        'status_id'     => $editable_line->status_id,
                        'wp_id'         => $editable_line->wp_id,
                        'fa'            => $editable_line->fa,
                        'inv_num'       => $editable_line->inv_num,
                        'inv_status'    => $editable_line->inv_status,
                        'com_date'      => $editable_line->com_date,
                        'note'          => $editable_line->note,
                        'editable_line' => $editable_line,
                        'res_status'    => 'fail',
                    );

                } else
                {
                    $result = array(
                        'res_status'  => 'fail',
                        'res_message' => "Ошибка! Нет записи с таким ID!",
                    );
                }
            }

            if (isset($_POST['GO']))
            {    
                $to_edit = array(
                    'id'            => (int) trim($_POST['id']),
                    'devtype_id'    => (int) trim($_POST['devtype_id']),
                    'vendor_id'     => (int) trim($_POST['vendor_id']),
                    'model'         =>       trim($_POST['model']),
                    'bat_id'        => (int) trim($_POST['bat_id']),
                    'bat_count'     => (int) trim($_POST['bat_count']),
                    'location_id'   => (int) trim($_POST['location_id']),
                    'status_id'     => (int) trim($_POST['status_id']),
                    'fa'            =>       trim($_POST['fa']),
                    'inv_num'       =>       trim($_POST['inv_num']),
                    'inv_status'    =>       trim($_POST['inv_status']),
                    'com_date'      =>       trim($_POST['com_date']),
                    'note'          =>       trim($_POST['note']),
                );

                $result = ORM::factory('Ups')->editUps($to_edit);

                if ($result['res_status'] == 'success')
                {
                    $this->redirect('/upses');
                }
            }

            View::set_global('title', 'Редактирование ИБП');
            View::set_global('oper_type', 'edit');
            View::set_global('def_vars', ORM::factory('Ups')->getDefaultVars());
            View::bind_global('result', $result);
            $this->template->set_filename('templates/forms_common');

            $devgroup = ORM::factory('Devgroup')
                ->where('devgroup_name', '=', 'ИБП')
                ->find();
            
            $this->template->content = View::factory('management/forms/upses_form', array(

                'select_devtypes'   => ORM::factory('Devtype')
                    ->where('devgroup_id', '=', $devgroup->devgroup_id)
                    ->find_all(),

                'select_vendors'    => ORM::factory('Vendor')
                    ->order_by('vendor_name')
                    ->find_all(),

                'select_locations'  => ORM::factory('Location')
                    ->find_all(),

                'select_statuses'   => ORM::factory('Status')
                    ->find_all(),

                'select_battypes'   => ORM::factory('Battery')
                    ->find_all(),

            ));
        }
        else
        {
            $this->redirect('/main/norights');
        }

    } //End edit_Action





    public function action_delete()
    {
        if ($this->auth->logged_in('admin'))
        {
            $id = (int) $this->request->param('id');

            if ($id)
            {
                $delete_line = ORM::factory('Ups', $id);

                if ($delete_line->loaded())
                {
                    $delete_line->delete();
                    $this->redirect('/upses');

                } else
                {
                    $result = array(
                        'res_status'  => 'fail',
                        'res_message' => "Ошибка! Нет строки с таким ID!",
                    );
                }
            }
        }
        else
        {
            $this->redirect('/main/norights');
        }
        
    }// End delete_Action






    public function action_choice()
    {
        if ($this->auth->logged_in('admin'))
        {
            $wp_id      = (int) $this->request->param('id');
            $operation  = trim($this->request->param('operation'));
            $old_id     = (int) $this->request->param('new_id');

            View::set_global('title', 'Выбор ИБП');
            View::set_global('def_vars', ORM::factory('Ups')->getDefaultVars());

            $status_keeping =   ORM::factory('Status')
                ->where('status_name', '=', 'хранение')
                ->find();
            
            $status_uknown  =   ORM::factory('Status')
                ->where('status_name', '=', 'неизвестно')
                ->find();

            $this->template->content = View::factory('main_logic/choice_ups', array(

                'upses'  =>  ORM::factory('Ups')
                    ->where('status_id', '=', $status_keeping)
                    ->or_where('status_id', '=', $status_uknown)
                    ->find_all(),
                
                'wp_id'         =>  $wp_id,
                'operation'     =>  $operation,
                'old_id'        =>  $old_id,
            ));
        }
        else
        {
            $this->redirect('/main/norights');
        }

    }// End choice Action



}// End Upses Controller