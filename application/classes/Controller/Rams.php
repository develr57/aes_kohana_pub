<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Rams extends Controller_Base {

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
        View::set_global('title', 'Таблица оперативной памяти');
        $this->template->content = View::factory('management/rams_management', array(
            'current_table' =>  ORM::factory('Ram')->find_all(),
            'def_vars'      =>  ORM::factory('Ram')->getDefaultVars(),
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
                    'size'          => (int) trim($_POST['size']),
                    'ramtype_id'    => (int) trim($_POST['ramtype_id']),
                    'speed'         => (int) trim($_POST['speed']),
                    'formfactor'    =>       trim($_POST['formfactor']),
                    'location_id'   => (int) trim($_POST['location_id']),
                    'status_id'     => (int) trim($_POST['status_id']),
                    'note'          =>       trim($_POST['note']),
                );

                $result = ORM::factory('Ram')->addRam($to_add);
            }

            View::set_global('title', 'Добавление оперативной памяти');
            View::set_global('oper_type', 'add');
            View::set_global('def_vars', ORM::factory('Ram')->getDefaultVars());
            View::bind_global('result', $result);
            $this->template->set_filename('templates/forms_common');
            $this->template->content = View::factory('management/forms/rams_form', array(

                'select_vendors'    => ORM::factory('Vendor')
                    ->order_by('vendor_name')
                    ->find_all(),

                'select_locations'  => ORM::factory('Location')
                    ->find_all(),

                'select_statuses'   => ORM::factory('Status')
                    ->find_all(),

                'select_ramtypes'   => ORM::factory('Ramtype')
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
                $editable_line = ORM::factory('Ram', $id);
                if ($editable_line->loaded())
                {
                    $result = array(
                        'id'            => $id,
                        'devtype_id'    => $editable_line->devtype_id,
                        'vendor_id'     => $editable_line->vendor_id,
                        'model'         => $editable_line->model,
                        'size'          => $editable_line->size,
                        'ramtype_id'    => $editable_line->ramtype_id,
                        'speed'         => $editable_line->speed,
                        'formfactor'    => $editable_line->formfactor,
                        'location_id'   => $editable_line->location_id,
                        'status_id'     => $editable_line->status_id,
                        'su_id'         => $editable_line->su_id,
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
                    'size'          => (int) trim($_POST['size']),
                    'ramtype_id'    => (int) trim($_POST['ramtype_id']),
                    'speed'         => (int) trim($_POST['speed']),
                    'formfactor'    =>       trim($_POST['formfactor']),
                    'location_id'   => (int) trim($_POST['location_id']),
                    'status_id'     => (int) trim($_POST['status_id']),
                    'note'          =>       trim($_POST['note']),
                );

                $result = ORM::factory('Ram')->editRam($to_edit);

                if ($result['res_status'] == 'success')
                {
                    $this->redirect('/rams');
                }
            }

            View::set_global('title', 'Редактирование оперативной памяти');
            View::set_global('oper_type', 'edit');
            View::set_global('def_vars', ORM::factory('Ram')->getDefaultVars());
            View::bind_global('result', $result);
            $this->template->set_filename('templates/forms_common');
            
            $this->template->content = View::factory('management/forms/rams_form', array(

                'select_vendors'    => ORM::factory('Vendor')
                    ->order_by('vendor_name')
                    ->find_all(),

                'select_locations'  => ORM::factory('Location')
                    ->find_all(),

                'select_statuses'   => ORM::factory('Status')
                    ->find_all(),

                'select_ramtypes'    => ORM::factory('Ramtype')
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
                $delete_line = ORM::factory('Ram', $id);

                if ($delete_line->loaded())
                {
                    $delete_line->delete();
                    $this->redirect('/rams');

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
            $su_id      = (int) $this->request->param('id');
            $operation  = trim($this->request->param('operation'));
            $old_id     = (int) $this->request->param('new_id');

            View::set_global('title', 'Выбор модуля ОЗУ');
            View::set_global('def_vars', ORM::factory('Ram')->getDefaultVars());

            $status_keeping =   ORM::factory('Status')
                ->where('status_name', '=', 'хранение')
                ->find();
            
            $status_uknown  =   ORM::factory('Status')
                ->where('status_name', '=', 'неизвестно')
                ->find();

            $this->template->content = View::factory('main_logic/choice_ram', array(

                'rams'  =>  ORM::factory('Ram')
                    ->where('status_id', '=', $status_keeping)
                    ->or_where('status_id', '=', $status_uknown)
                    ->find_all(),
                
                'su_id'         =>  $su_id,
                'operation'     =>  $operation,
                'old_id'        =>  $old_id,
            ));
        }
        else
        {
            $this->redirect('/main/norights');
        }

    }// End action_choice



}