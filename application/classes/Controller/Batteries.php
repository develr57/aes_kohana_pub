<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Batteries extends Controller_Base {


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
        View::set_global('title', 'Таблица типов АКБ');
        View::bind_global('result', $result);
        $this->template->content = View::factory('management/batteries_management', array(
            'current_table' =>  ORM::factory('Battery')->find_all(),
            'def_vars'      =>  ORM::factory('Battery')->getDefaultVars(),
        ));

    }





    public function action_add()
    {
        if ($this->auth->logged_in('admin'))
        {
            if (isset($_POST['bat_voltage']) && isset($_POST['bat_capacity']))
            {
                $to_add = array(
                    'bat_voltage'   => (int) trim($_POST['bat_voltage']),
                    'bat_capacity'  => (float) trim($_POST['bat_capacity']),
                );

                $result = ORM::factory('Battery')->addBattery($to_add);
            }
            View::set_global('title', 'Добавление типа АКБ');
            View::set_global('oper_type', 'add');
            View::set_global('def_vars', ORM::factory('Battery')->getDefaultVars());
            View::bind_global('result', $result);
            $this->template->set_filename('templates/forms_common');
            $this->template->content = View::factory('management/forms/battery_form', array(
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
                $editable_line = ORM::factory('Battery', $id);
                if ($editable_line->loaded())
                {
                    $result = array(
                        'id'            => $id,
                        'editable_line' => $editable_line,
                    );

                } else
                {
                    $result = array(
                        'res_status' => 'fail',
                        'res_message' => "Ошибка! Нет строки с таким ID!",
                    );
                }
            }

            if (isset($_POST['bat_voltage']) && isset($_POST['bat_capacity']))
            {
                $id = (int) trim($_POST['id']);

                $to_edit = array(
                    'id'            => $id,
                    'bat_voltage'   => (int)   trim($_POST['bat_voltage']),
                    'bat_capacity'  => (float) trim($_POST['bat_capacity']),
                );

                $result = ORM::factory('Battery')->editBattery($to_edit);
                if ($result['res_status'] == 'success')
                {
                    $this->redirect('/batteries');
                }
            }

            View::set_global('title', 'Редактирование типа АКБ');
            View::set_global('oper_type', 'edit');
            View::set_global('def_vars', ORM::factory('Battery')->getDefaultVars());
            View::bind_global('result', $result);
            $this->template->set_filename('templates/forms_common');
            $this->template->content = View::factory('management/forms/battery_form', array(
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
                $delete_row = ORM::factory('Battery', $id);
                if ($delete_row->loaded())
                {
                    $delete_row->delete();

                    $this->redirect('/batteries');

                } else
                {
                    $result['res_status'] = 'fail';
                    $result['res_message'] = "Ошибка! Нет строки с таким ID!";
                }
            }
        }
        else
        {
            $this->redirect('/main/norights');
        }
        
    }// End delete_Action

}