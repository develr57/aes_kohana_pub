<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sysunits extends Controller_Base {

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
        View::set_global('title', 'Таблица системных блоков');
        $this->template->content = View::factory('management/sysunits_management', array(
            'current_table' =>  ORM::factory('Sysunit')->find_all(),
            'def_vars'      =>  ORM::factory('Sysunit')->getDefaultVars(),
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
                    'location_id'   => (int) trim($_POST['location_id']),
                    'status_id'     => (int) trim($_POST['status_id']),
                    'fa'            =>       trim($_POST['fa']),
                    'inv_num'       =>       trim($_POST['inv_num']),
                    'inv_status'    =>       trim($_POST['inv_status']),
                    'com_date'      =>       trim($_POST['com_date']),
                    'note'          =>       trim($_POST['note']),
                );

                $result = ORM::factory('Sysunit')->addSysunit($to_add);
            }

            View::set_global('title', 'Добавление системного блока');
            View::set_global('oper_type', 'add');
            View::set_global('def_vars', ORM::factory('Sysunit')->getDefaultVars());
            View::bind_global('result', $result);
            $this->template->set_filename('templates/forms_common');

            $devgroup = ORM::factory('Devgroup')
                ->where('devgroup_name', '=', 'Сист.блок')
                ->find();
            
            $this->template->content = View::factory('management/forms/sysunits_form', array(
                
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
                $editable_line = ORM::factory('Sysunit', $id);
                if ($editable_line->loaded())
                {
                    $result = array(
                        'id'            => $id,
                        'devtype_id'    => $editable_line->devtype_id,
                        'vendor_id'     => $editable_line->vendor_id,
                        'model'         => $editable_line->model,
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
                    'location_id'   => (int) trim($_POST['location_id']),
                    'status_id'     => (int) trim($_POST['status_id']),
                    'fa'            =>       trim($_POST['fa']),
                    'inv_num'       =>       trim($_POST['inv_num']),
                    'inv_status'    =>       trim($_POST['inv_status']),
                    'com_date'      =>       trim($_POST['com_date']),
                    'note'          =>       trim($_POST['note']),
                );

                $result = ORM::factory('Sysunit')->editSysunit($to_edit);

                if ($result['res_status'] == 'success')
                {
                    $this->redirect('/sysunits');
                }
            }

            View::set_global('title', 'Редактирование системного блока');
            View::set_global('oper_type', 'edit');
            View::set_global('def_vars', ORM::factory('Sysunit')->getDefaultVars());
            View::bind_global('result', $result);
            $this->template->set_filename('templates/forms_common');

            $devgroup = ORM::factory('Devgroup')
                ->where('devgroup_name', '=', 'Сист.блок')
                ->find();
            
            $this->template->content = View::factory('management/forms/sysunits_form', array(
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
            $result = ORM::factory('Sysunit')->deleteSysunit($id);

            if ($result['res_status'] == 'success')
            {
                $this->redirect('/sysunits');
            
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





    public function action_delete_with_all_units()
    {
        if ($this->auth->logged_in('admin'))
        {
            $id = (int) $this->request->param('id');
            $result = ORM::factory('Sysunit')->delete_with_all_units($id);

            if ($result['res_status'] == 'success')
            {
                $this->redirect('/sysunits');
            
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





    public function action_configuration()
    {
        $id = (int) $this->request->param('id');
        if ($id)
        {
            $current_sysunit = ORM::factory('Sysunit', $id);
            if ($current_sysunit->loaded())
            {
                $result = array(
                    'id'                => $id,
                    'current_sysunit'   => $current_sysunit,
                );

            } else
            {
                $result = array(
                    'res_status'  => 'fail',
                    'res_message' => "Ошибка! Нет записи с таким ID!",
                );
            }
        }

        View::set_global('title', 'Конфигурация системного блока');
        View::set_global('def_vars', ORM::factory('Sysunit')->getDefaultVars());
        View::bind_global('result', $result);
        
        $this->template->content = View::factory('main_logic/sysunit_configuration', array(
            
            'motherboards'  => ORM::factory('Motherboard')
                ->where('su_id', '=', $id)
                ->find_all(),

            'cpus'          => ORM::factory('Cpu')
                ->where('su_id', '=', $id)
                ->find_all(),

            'rams'          => ORM::factory('Ram')
                ->where('su_id', '=', $id)
                ->find_all(),
            
            'videocards'    => ORM::factory('Videocard')
                ->where('su_id', '=', $id)
                ->find_all(),
            
            'storages'      => ORM::factory('Storage')
                ->where('su_id', '=', $id)
                ->find_all(),
            
            'pwrsupplies'     => ORM::factory('Pwrsupply')
                ->where('su_id', '=', $id)
                ->find_all(),
        ));

    } //End Configuration action



    public function action_operations()
    {
        if ($this->auth->logged_in('admin'))
        {
            $su_id          = (int) $this->request->param('id');
            $operation      = trim($this->request->param('operation'));
            $new_id         = (int) $this->request->param('new_id');
            $model          = trim($this->request->param('model'));
            $old_id         = (int) $this->request->param('old_id');

            isset($su_id)       ? $oper_arr['su_id']        = $su_id        : '';
            isset($operation)   ? $oper_arr['operation']    = $operation    : '';
            isset($new_id)      ? $oper_arr['new_id']       = $new_id       : '';
            isset($model)       ? $oper_arr['model']        = $model        : '';
            isset($old_id)      ? $oper_arr['old_id']       = $old_id       : '';


            if (isset($operation))
            {
                ORM::factory('Sysunit')->operations($oper_arr);
                $this->redirect('/sysunits/configuration/'.$su_id);

            } else
            {
                echo '<p class="fail">Ошибка в Sysunits_action_operations!</p>';
            }
        }
        else
        {
            $this->redirect('/main/norights');
        }

    }//End operation Action





    public function action_choice()
    {
        if ($this->auth->logged_in('admin'))
        {
            $wp_id      = (int) $this->request->param('id');
            $operation  = trim($this->request->param('operation'));
            $old_id     = (int) $this->request->param('new_id');

            View::set_global('title', 'Выбор Системного блока');
            View::set_global('def_vars', ORM::factory('Sysunit')->getDefaultVars());

            $status_keeping =   ORM::factory('Status')
                ->where('status_name', '=', 'хранение')
                ->find();
            
            $status_uknown  =   ORM::factory('Status')
                ->where('status_name', '=', 'неизвестно')
                ->find();

            $this->template->content = View::factory('main_logic/choice_sysunit', array(

                'sysunits'  =>  ORM::factory('Sysunit')
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


}