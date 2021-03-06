<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Devgroups extends Controller_Base {


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
        View::set_global('title', 'Таблица групп устройств');
        View::bind_global('result', $result);
        $this->template->content = View::factory('management/system_content', array(
            'current_table' =>  ORM::factory('Devgroup')->find_all(),
            'def_vars'      =>  ORM::factory('Devgroup')->getDefaultVars(),
        ));

    }





    public function action_add()
    {
        if ($this->auth->logged_in('admin'))
        {
            if (isset($_POST['text_value']))
            {
                $text_value = trim($_POST['text_value']);
                $result = ORM::factory('Devgroup')->addDevgroup($text_value);
            }
            View::set_global('title', 'Добавление группы устройств');
            View::set_global('oper_type', 'add');
            View::set_global('def_vars', ORM::factory('Devgroup')->getDefaultVars());
            View::bind_global('result', $result);
            $this->template->set_filename('templates/forms_common');
            $this->template->content = View::factory('management/forms/system_form', array(
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
                $edition_row = ORM::factory('Devgroup', $id);
                if ($edition_row->loaded())
                {
                    $result = array(
                        'id'            => $id,
                        'text_value'    => $edition_row->devgroup_name,
                        'res_status'    => 'fail',
                    );

                } else
                {
                    $result['res_status'] = 'fail';
                    $result['res_message'] = "Ошибка! Нет строки с таким ID!";
                }
            }

            if (isset($_POST['text_value']))
            {
                $id = (int) trim($_POST['id']);
                $text_value = trim($_POST['text_value']);

                $to_edit = array(
                    'id'            =>  $id,
                    'text_value'    =>  $text_value,
                );

                $result = ORM::factory('Devgroup')->editDevgroup($to_edit);
                if ($result['res_status'] == 'success')
                {
                    $this->redirect('/devgroups');

                }

            }

            View::set_global('title', 'Редактирование группы устройств');
            View::set_global('oper_type', 'edit');
            View::set_global('def_vars', ORM::factory('Devgroup')->getDefaultVars());
            View::bind_global('result', $result);
            $this->template->set_filename('templates/forms_common');
            $this->template->content = View::factory('management/forms/system_form', array(
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
                $delete_row = ORM::factory('Devgroup', $id);
                if ($delete_row->loaded())
                {
                    $delete_row->delete();

                    $this->redirect('/devgroups');

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