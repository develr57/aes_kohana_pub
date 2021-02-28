<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Devtypes extends Controller_Base {


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
        View::set_global('title', 'Таблица типов устройств');
        $this->template->content = View::factory('management/devtypes_management', array(
            'current_table' =>  ORM::factory('Devtype')->find_all(),
            'def_vars'      =>  ORM::factory('Devtype')->getDefaultVars(),
        ));

    }





    public function action_add()
    {
        if ($this->auth->logged_in('admin'))
        {
            if (isset($_POST['devtype_name']) && isset($_POST['devgroup_id']))
            {
                $to_add = array(
                    'devtype_name'  =>       trim($_POST['devtype_name']),
                    'devgroup_id'   => (int) trim($_POST['devgroup_id']),
                );

                $result = ORM::factory('Devtype')->addDevtype($to_add);
            }

            View::set_global('title', 'Добавление типа устройств');
            View::set_global('oper_type', 'add');
            View::set_global('def_vars', ORM::factory('Devtype')->getDefaultVars());
            View::bind_global('result', $result);
            $this->template->set_filename('templates/forms_common');
            $this->template->content = View::factory('management/forms/devtypes_form', array(
                'select_devgroups'  =>  ORM::factory('Devgroup')->find_all(),
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
                $editable_line = ORM::factory('Devtype', $id);
                if ($editable_line->loaded())
                {
                    $result = array(
                        'id'            => $id,
                        'devgroup_id'   => $editable_line->devgroup_id,
                        'devtype_name'  => $editable_line->devtype_name,
                        'editable_line' => $editable_line,
                        'res_status'    => 'fail',
                    );

                } else
                {
                    $result = array(
                        'res_status'  => 'fail',
                        'res_message' => "Ошибка! Нет строки с таким ID!",
                    );
                }
            }

            if (isset($_POST['devtype_name']) && isset($_POST['devgroup_id']))
            {
                $to_edit = array(
                    'id'             => (int) trim($_POST['id']),
                    'devgroup_id'    => (int) trim($_POST['devgroup_id']),
                    'devtype_name'   =>       trim($_POST['devtype_name']),
                );

                $result = ORM::factory('Devtype')->editDevtype($to_edit);

                if ($result['res_status'] == 'success')
                {
                    $this->redirect('/devtypes');
                }
            }

            View::set_global('title', 'Редактирование типа устройств');
            View::set_global('oper_type', 'edit');
            View::set_global('def_vars', ORM::factory('Devtype')->getDefaultVars());
            View::bind_global('result', $result);
            $this->template->set_filename('templates/forms_common');
            $this->template->content = View::factory('management/forms/devtypes_form', array(
                'select_devgroups'  =>  ORM::factory('Devgroup')->find_all(),
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
                $delete_row = ORM::factory('Devtype', $id);

                if ($delete_row->loaded())
                {
                    $delete_row->delete();
                    $this->redirect('/devtypes');

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

}