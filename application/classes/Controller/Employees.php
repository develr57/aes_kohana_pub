<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Employees extends Controller_Base {

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
        View::set_global('title', 'Таблица сотрудников');
        $this->template->content = View::factory('management/employees_management', array(
            'current_table' =>  ORM::factory('Employee')->find_all(),
            'def_vars'      =>  ORM::factory('Employee')->getDefaultVars(),
        ));

    }





    public function action_add()
    {
        if ($this->auth->logged_in('admin'))
        {
            if (isset($_POST['surname'])  &&
                isset($_POST['name'])  &&
                isset($_POST['patronymic'])  &&
                isset($_POST['position'])  &&
                isset($_POST['dept_id']))
            {
                $to_add = array(
                    'surname'     =>       trim($_POST['surname']),
                    'name'        =>       trim($_POST['name']),
                    'patronymic'  =>       trim($_POST['patronymic']),
                    'position'    =>       trim($_POST['position']),
                    'dept_id' => (int) trim($_POST['dept_id']),
                );

                $result = ORM::factory('Employee')->addEmployee($to_add);
            }

            View::set_global('title', 'Добавление сотрудника');
            View::set_global('oper_type', 'add');
            View::set_global('def_vars', ORM::factory('Employee')->getDefaultVars());
            View::bind_global('result', $result);
            $this->template->set_filename('templates/forms_common');
            $this->template->content = View::factory('management/forms/employees_form', array(
                'select_department'  =>  ORM::factory('Department')->find_all(),
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
            extract(ORM::factory('Employee')->getDefaultVars());

            $id = (int) $this->request->param('id');
            if ($id)
            {
                $editable_line = ORM::factory('Employee', $id);
                if ($editable_line->loaded())
                {
                    $result = array(
                        'id'            => $id,
                        'surname'       => $editable_line->surname,
                        'name'          => $editable_line->name,
                        'patronymic'    => $editable_line->patronymic,
                        'position'      => $editable_line->position,
                        'dept_id'       => $editable_line->dept_id,
                        'editable_line' => $editable_line,
                        'res_status'    => 'fail',
                    );

                } else
                {
                    $result['res_status']  = 'fail';
                    $result['res_message'] = "Ошибка! Нет записи с таким ID!";
                }
            }

            if (isset($_POST['surname'])  &&
                isset($_POST['name'])  &&
                isset($_POST['patronymic'])  &&
                isset($_POST['position'])  &&
                isset($_POST['dept_id']))
            {
                $to_edit = array(
                    'id'          => (int) trim($_POST['id']),
                    'surname'     =>       trim($_POST['surname']),
                    'name'        =>       trim($_POST['name']),
                    'patronymic'  =>       trim($_POST['patronymic']),
                    'position'    =>       trim($_POST['position']),
                    'dept_id'     => (int) trim($_POST['dept_id']),
                );

                $result = ORM::factory('Employee')->editEmployee($to_edit);

                if ($result['res_status'] == 'success')
                {
                    $this->redirect('/employees');
                }
            }

            View::set_global('title', 'Редактирование сотрудника');
            View::set_global('oper_type', 'edit');
            View::set_global('def_vars', ORM::factory('Employee')->getDefaultVars());
            View::bind_global('result', $result);
            $this->template->set_filename('templates/forms_common');
            $this->template->content = View::factory('management/forms/employees_form', array(
                'select_department'  =>  ORM::factory('Department')->find_all(),
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
                $delete_line = ORM::factory('Employee', $id);

                if ($delete_line->loaded())
                {
                    $delete_line->delete();
                    $this->redirect('/employees');

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