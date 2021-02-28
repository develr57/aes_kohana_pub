<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Workplace extends ORM {

    protected $_table_name  = 'workplaces';
    protected $_primary_key = 'wp_id';

    protected $_belongs_to  = array(

        'department'=> array(
            'model'         => 'Department',
            'foreign_key'   => 'dept_id',
        ),

        'location'  => array(
            'model'         => 'Location',
            'foreign_key'   => 'location_id',
        ),

        'status'    => array(
            'model'         => 'Status',
            'foreign_key'   => 'status_id',
        ),

        'employee'      => array(
            'model'         => 'Employee',
            'foreign_key'   => 'emp_id',
        ),

    );

    protected $_has_one     = array(

        // 'employee'      => array(
        //     'model'         => 'Employee',
        //     'foreign_key'   => 'emp_id',
        // ),

        'sysunit'       => array(
            'model'         => 'Sysunit',
            'foreign_key'   => 'wp_id',
        ),

    );

    public $table_name  = 'workplaces';
    public $id_column   = 'wp_id';

    public function getDefaultVars()
    {
        return array(
            'table_name'        => $this->table_name,
            'id_column'         => $this->id_column,
            'field_wp_name'     => 'Название',
            'field_employee'    => 'Сотрудник',
            'field_department'  => 'Отдел',
            'field_location'    => 'Локация',
            'field_status'      => 'Статус',
            'field_note'        => 'Заметка',
            'list_num'          => 1,
        );
    }



    private function IDCheck($check_IDs)
    {
        $flag = TRUE;
        foreach ($check_IDs as $model => $id) {
            $check = ORM::factory($model, $id);
            if (!$check->loaded()) {
                $flag = FALSE;
            }
        }

        return $flag;
    }



    public function addWorkplace($to_add)
    {
        extract($to_add);

        if ($emp_id != '')
        {
            $dept_id = ORM::factory('Employee', $emp_id)->dept_id;
        }

        $check_IDs = array();
        if ($emp_id         != '')  $check_IDs['Employee']      = $emp_id;
        if ($dept_id        != '')  $check_IDs['Department']    = $dept_id;
        if ($location_id    != '')  $check_IDs['Location']      = $location_id;
        if ($status_id      != '')  $check_IDs['Status']        = $status_id;

        if ($this->IDCheck($check_IDs))
        {
            if (isset($wp_name) && $wp_name != '')  $wp_name    = htmlentities($wp_name, ENT_QUOTES, "UTF-8");
            if (isset($note)    && $note != '')     $note       = htmlentities($note, ENT_QUOTES, "UTF-8");

            $result = array(
                'wp_name'       =>  $wp_name,
                'emp_id'        =>  $emp_id,
                'dept_id'       =>  $dept_id,
                'location_id'   =>  $location_id,
                'status_id'     =>  $status_id,
                'note'          =>  $note,
            );

            if ($emp_id != '' && ORM::factory('Workplace')
                                    ->where('emp_id', '=', $emp_id)
                                    ->find_all()
                                    ->count()
                )
            {
                $result['res_status']    =  'fail';
                $result['res_message']   =  "Этот сотрудник уже имеет рабочее место!";

            } else
            {
                $oper_add = ORM::factory('Workplace');
                $oper_add->wp_name      =   $wp_name;
                $oper_add->emp_id       =   $emp_id;
                $oper_add->dept_id      =   $dept_id;
                $oper_add->location_id  =   $location_id;
                $oper_add->status_id    =   $status_id;
                $oper_add->note         =   $note;
                $oper_add->create();

                $result = array(
                    'res_status'    => 'success',
                    'res_message'   => 'Успех! Запись добавлена!',
                );
            }
        
        } else
        {
            $result['res_status']    =  'fail';
            $result['res_message']   =  "Ошибка! Неверный ID одного из селекторов: " .
                "Сотрудник, Отдел, Локация или Статус!";
        }

        return $result;
    
    } //End addWorkplace()




    public function editWorkplace($to_edit)
    {
        extract($to_edit);

        if ($emp_id != '')
        {
            $dept_id = ORM::factory('Employee', $emp_id)->dept_id;
        }

        $check_IDs = array();
        if ($emp_id         != '')  $check_IDs['Employee']      = $emp_id;
        if ($dept_id        != '')  $check_IDs['Department']    = $dept_id;
        if ($location_id    != '')  $check_IDs['Location']      = $location_id;
        if ($status_id      != '')  $check_IDs['Status']        = $status_id;

        if ($this->IDCheck($check_IDs))
        {
            if (isset($wp_name) && $wp_name != '')  $wp_name = htmlentities($wp_name, ENT_QUOTES, "UTF-8");
            if (isset($note)    && $note    != '')  $note    = htmlentities($note, ENT_QUOTES, "UTF-8");

            $result = array(
                'id'            => $id,
                'wp_name'       => $wp_name,
                'emp_id'        => $emp_id,
                'dept_id'       => $dept_id,
                'location_id'   => $location_id,
                'status_id'     => $status_id,
                'note'          => $note,
            );
            
            if ($emp_id != '' && ORM::factory('Workplace')
                                    ->where('wp_id', '!=', $id)
                                    ->and_where('emp_id', '=', $emp_id)
                                    ->find_all()
                                    ->count()
                )
            {
                $result['res_status']    =  'fail';
                $result['res_message']   =  "Этот сотрудник уже имеет рабочее место";

            } else
            {
                $oper_edit = ORM::factory('Workplace', $id);
                $oper_edit->wp_name     =   $wp_name;
                $oper_edit->emp_id      =   $emp_id;
                $oper_edit->dept_id     =   $dept_id;
                $oper_edit->location_id =   $location_id;
                $oper_edit->status_id   =   $status_id;
                $oper_edit->note        =   $note;
                $oper_edit->update();

                $result = array(
                    'res_status'    => 'success',
                    'res_message'   => 'Успех! Запись добавлена!',
                );
            }

        } else
        {
            $result['res_status']    =  'fail';
            $result['res_message']   =  "Ошибка! Неверный ID одного из селекторов: ".
                                        "Сотрудник, Отдел, Локация или Статус!";
        }

        return $result;
    
    } //End editWorkplace()





    public function operations($oper_arr)
    {
        extract($oper_arr); //Массив из Workplace action_operation

        $status_use             = ORM::factory('Status')
            ->where('status_name', '=', 'используется')
            ->find()
            ->status_id;

        $status_keeping         = ORM::factory('Status')
            ->where('status_name', '=', 'хранение')
            ->find()
            ->status_id;

        function checkAndGetUnitsArray($val) //Сборка массива комплектующих находящихся в сист.блоке
        {
            $arr_verifiable = array('Motherboard', 'Cpu', 'Ram', 'Videocard', 'Storage', 'Pwrsupply');
            $arr_tested = array();
            foreach ($arr_verifiable as $model)
            {
                $any_model = ORM::factory($model)->where('su_id', '=', $val)->find_all();
                if ($any_model->count() > 0)
                {
                    $arr_tested[$model] = $any_model;
                }
            }
            return $arr_tested;
        }

        // Релокация и изменеие статуса комплектующих сист.блока
        function updateLocationAndStatusOfUnits($units_arr, $location_id, $status_id)
        {
            if (count($units_arr) > 0)
            {
                foreach ($units_arr as $any_units)
                {
                    foreach ($any_units as $any_unit)
                    {
                        $any_unit->location_id  = $location_id;
                        $any_unit->status_id    = $status_id;
                        $any_unit->update();
                    }
                }
            }
        }
        
        $workplace              = ORM::factory('Workplace', $wp_id);
        $wp_location_id         = $workplace->location_id;
        $office7_location_id    = 2;
        if (isset($old_id)) $current_unit = ORM::factory($model, $old_id);
        $new_unit               = ORM::factory($model, $new_id);

        // Если оперируемая единица является системным блоком
        if ($model == 'sysunit')
        {
            if ($operation == 'install')
            {
                $new_unit->location_id  = $wp_location_id;
                $new_unit->status_id    = $status_use;
                $new_unit->wp_id        = $wp_id;
                $new_unit->update();
                $units_arr = checkAndGetUnitsArray($new_id);
                updateLocationAndStatusOfUnits($units_arr, $wp_location_id, $status_use);

            } elseif ($operation == 'replace')
            {
                $current_unit->location_id  = $office7_location_id;
                $current_unit->status_id    = $status_keeping;
                $current_unit->wp_id        = NULL;
                $current_unit->update();
                $units_arr = checkAndGetUnitsArray($old_id);
                updateLocationAndStatusOfUnits($units_arr, $office7_location_id, $status_use);

                $new_unit->location_id  = $wp_location_id;
                $new_unit->status_id    = $status_use;
                $new_unit->wp_id        = $wp_id;
                $new_unit->update();
                $units_arr = checkAndGetUnitsArray($new_id);
                updateLocationAndStatusOfUnits($units_arr, $wp_location_id, $status_use);

            } elseif ($operation == 'deinstall')
            {
                $new_unit->location_id  = $office7_location_id;
                $new_unit->status_id    = $status_keeping;
                $new_unit->wp_id        = NULL;
                $new_unit->update();
                $units_arr = checkAndGetUnitsArray($new_id);
                updateLocationAndStatusOfUnits($units_arr, $wp_location_id, $status_use);
            }

        } else
        {
            if ($operation == 'install')
            {
                $new_unit->location_id  = $wp_location_id;
                $new_unit->status_id    = $status_use;
                $new_unit->wp_id        = $wp_id;
                $new_unit->update();

            } elseif ($operation == 'replace')
            {
                $current_unit->location_id  = $office7_location_id;
                $current_unit->status_id    = $status_keeping;
                $current_unit->wp_id        = NULL;
                $current_unit->update();

                $new_unit->location_id  = $wp_location_id;
                $new_unit->status_id    = $status_use;
                $new_unit->wp_id        = $wp_id;
                $new_unit->update();

            } elseif ($operation == 'deinstall')
            {
                $new_unit->location_id  = $office7_location_id;
                $new_unit->status_id    = $status_keeping;
                $new_unit->wp_id        = NULL;
                $new_unit->update();
            }
        }
    
    }//End operation function





    public function deleteWorkplace($id)
    {
        // функция checkAndDeinstallAndRelocationUnits() определяет оборудование прикреплённое к раб.месту
        // Заменяет оборудованию ID раб.места на NULL
        // И заменяет ID локации оборудования и комплектующих на ID локации 7 офиса
        // У оборудования изменяется статус на "хранение", у комплектующих статус остается прежним
        function checkAndDeinstallAndRelocationUnits($id)
        {
            $equipments_title = array('Sysunit', 'Monitor', 'Ups', 'Offequipment');
            $office7_location_id    = 2; // ID локации 7 офиса
            $status_keeping         = ORM::factory('Status')
                ->where('status_name', '=', 'хранение')
                ->find()->status_id;
            $units_title = array(
                'Motherboard', 'Cpu', 'Ram', 'Videocard', 'Storage', 'Pwrsupply',
            );
            foreach ($equipments_title as $equipment)
            {
                $equipments = ORM::factory($equipment)->where('wp_id', '=', $id)->find_all();
                if ($equipment = 'Sysunit')
                {
                    if ($equipments->count() > 0)
                    {
                        foreach ($equipments as $sysunit)
                        {
                            foreach ($units_title as $unit_title)
                            {
                                $units = ORM::factory($unit_title)->where('su_id', '=', $sysunit->su_id)->find_all();
                                if ($units->count() > 0)
                                {
                                    foreach ($units as $unit)
                                    {
                                        $unit->location_id  = $office7_location_id;
                                        $unit->update();
                                    }
                                }
                            }
                            $sysunit->location_id    = $office7_location_id;
                            $sysunit->status_id      = $status_keeping;
                            $sysunit->wp_id          = NULL;
                            $sysunit->update();
                        }
                    }
                } else
                {
                    if ($equipments->count() > 0)
                    {
                        foreach ($equipments as $equipment_unit)
                        {
                            $equipment_unit->location_id    = $office7_location_id;
                            $equipment_unit->status_id      = $status_keeping;
                            $equipment_unit->wp_id          = NULL;
                            $equipment_unit->update();
                        }
                    }
                }
            }
        } //End function checkAndDeinstallAndRelocationUnits()
        
        $delete_workplace = ORM::factory('Workplace', $id);

        if ($delete_workplace->loaded())
        {
            checkAndDeinstallAndRelocationUnits($id);
            $delete_workplace->delete();

            $result = array(
                'res_status' => 'success',
            );

        } else
        {
            $result = array(
                'res_status'  => 'fail',
                'res_message' => "Ошибка! Нет строки с таким ID!",
            );
        }

        return $result;

    } //End delete fuction


}