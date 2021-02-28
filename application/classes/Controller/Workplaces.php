<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Workplaces extends Controller_Base {

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
        View::set_global('title', 'Список рабочих мест');
        $this->template->content = View::factory('management/workplaces_management', array(
            'current_table' =>  ORM::factory('Workplace')->find_all(),
            'def_vars'      =>  ORM::factory('Workplace')->getDefaultVars(),
        ));

    }



    public function action_add()
    {
        if ($this->auth->logged_in('admin'))
        {
            if (isset($_POST['GO']))
            {
                $to_add = array(
                    'wp_name'       =>       trim($_POST['wp_name']),
                    'emp_id'        => (int) trim($_POST['emp_id']),
                    'dept_id'       => (int) trim($_POST['dept_id']),
                    'location_id'   => (int) trim($_POST['location_id']),
                    'status_id'     => (int) trim($_POST['status_id']),
                    'note'          =>       trim($_POST['note']),
                );
                
                
                $result = ORM::factory('Workplace')->addWorkplace($to_add);
            }
            // getMy($this->auth);
            View::set_global('title', 'Добавление рабочего места');
            View::set_global('oper_type', 'add');
            View::set_global('def_vars', ORM::factory('Workplace')->getDefaultVars());
            View::bind_global('result', $result);
            $this->template->set_filename('templates/forms_common');

            $this->template->content = View::factory('management/forms/workplaces_form', array(

                'select_employees'  => ORM::factory('Employee')
                    ->find_all(),

                'select_departments'=> ORM::factory('Department')
                    ->find_all(),

                'select_locations'  => ORM::factory('Location')
                    ->find_all(),

                'select_statuses'   => ORM::factory('Status')
                    ->where('status_id', '<', '3')
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
                $editable_line = ORM::factory('Workplace', $id);
                if ($editable_line->loaded())
                {
                    $result = array(
                        'id'            => $id,
                        'wp_name'       => $editable_line->wp_name,
                        'emp_id'        => $editable_line->emp_id,
                        'dept_id'       => $editable_line->dept_id,
                        'location_id'   => $editable_line->location_id,
                        'status_id'     => $editable_line->status_id,
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
                    'wp_name'       =>       trim($_POST['wp_name']),
                    'emp_id'        => (int) trim($_POST['emp_id']),
                    'dept_id'       => (int) trim($_POST['dept_id']),
                    'location_id'   => (int) trim($_POST['location_id']),
                    'status_id'     => (int) trim($_POST['status_id']),
                    'note'          =>       trim($_POST['note']),
                );

                $result = ORM::factory('Workplace')->editWorkplace($to_edit);

                if ($result['res_status'] == 'success')
                {
                    $this->redirect('/workplaces');
                }
            }

            View::set_global('title', 'Редактирование рабочего места');
            View::set_global('oper_type', 'edit');
            View::set_global('def_vars', ORM::factory('Workplace')->getDefaultVars());
            View::bind_global('result', $result);
            $this->template->set_filename('templates/forms_common');
            
            $this->template->content = View::factory('management/forms/workplaces_form', array(
                'select_employees'  => ORM::factory('Employee')
                    ->find_all(),

                'select_departments'=> ORM::factory('Department')
                    ->find_all(),

                'select_locations'  => ORM::factory('Location')
                    ->find_all(),

                'select_statuses'   => ORM::factory('Status')
                    ->where('status_id', '<', '3')
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
            $result = ORM::factory('Workplace')->deleteWorkplace($id);

            if ($result['res_status'] == 'success')
            {
                $this->redirect('/workplaces');
            
            } else
            {
                echo $result['res_message'];
            }
        }
        else
        {
            $this->redirect('/main/norights');
        }
        
    }// End delete_Action





    public function action_wp_of_any_dept()
    {
        $id = (int) $this->request->param('id');

        View::set_global('title', 'Список рабочих мест отдела');
        $this->template->content = View::factory('index', array(

            'current_table' =>  ORM::factory('Workplace')
                ->where('dept_id', '=', $id)
                ->find_all(),
            
            'dept_name'     =>  ORM::factory('Department', $id)->dept_name,

            'def_vars'      =>  ORM::factory('Workplace')->getDefaultVars(),

        ));
    }//End wp_of_any_dept Action






    public function action_full_map()
    {
        $wp_id         = (int) $this->request->param('id');

        View::set_global('title', 'Полная карта рабочего места');
        View::set_global('def_vars', ORM::factory('Workplace')->getDefaultVars());
        
        $this->template->content = View::factory('main_logic/workplace_full_map', array(

            'wp_id'         => $wp_id,

            'workplace'     => ORM::factory('Workplace', $wp_id),

            'sysunits'      => ORM::factory('Sysunit')
                ->where('wp_id', '=', $wp_id)
                ->find_all(),
            
            'monitors'      => ORM::factory('Monitor')
                ->where('wp_id', '=', $wp_id)
                ->find_all(),
            
            'upses'         => ORM::factory('Ups')
                ->where('wp_id', '=', $wp_id)
                ->find_all(),
            
            'offequipments' => ORM::factory('Offequipment')
                ->where('wp_id', '=', $wp_id)
                ->find_all(),
        ));

    }//End full_map Action





    public function action_operations()
    {
        if ($this->auth->logged_in('admin'))
        {
            $wp_id          = (int) $this->request->param('id');
            $operation      = trim($this->request->param('operation'));
            $new_id         = (int) $this->request->param('new_id');
            $model          = trim($this->request->param('model'));
            $old_id         = (int) $this->request->param('old_id');

            isset($wp_id)       ? $oper_arr['wp_id']        = $wp_id        : '';
            isset($operation)   ? $oper_arr['operation']    = $operation    : '';
            isset($new_id)      ? $oper_arr['new_id']       = $new_id       : '';
            isset($model)       ? $oper_arr['model']        = $model        : '';
            isset($old_id)      ? $oper_arr['old_id']       = $old_id       : '';


            if (isset($operation))
            {
                ORM::factory('Workplace')->operations($oper_arr);
                $this->redirect('/workplaces/full_map/'.$wp_id);

            } else
            {
                echo '<p class="fail">Ошибка в Workplaces_action_operations!</p>';
            }
        }
        else
        {
            $this->redirect('/main/norights');
        }

    }//End operation Action




    
}//End Workplaces Controller