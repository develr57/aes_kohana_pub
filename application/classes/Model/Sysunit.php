<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Sysunit extends ORM {

    protected $_table_name = 'sysunits';
    protected $_primary_key = 'su_id';

    protected $_has_one     = array(

        // 'workplace'     => array(
        //     'model'         => 'Workplace',
        //     'foreign_key'   => 'wp_id',
        // ),

        'motherboard'   => array(
            'model'         => 'Motherboard',
            'foreign_key'   => 'su_id',
        ),

        'pwrsupply'     => array(
            'model'         => 'Pwrsupply',
            'foreign_key'   => 'su_id',
        ),

    );

    protected $_has_many    = array(

        'cpus'          => array(
            'model'         => 'Cpu',
            'foreign_key'   => 'su_id',
        ),

        'rams'          => array(
            'model'         => 'Ram',
            'foreign_key'   => 'su_id',
        ),

        'videocards'    => array(
            'model'         => 'Videocard',
            'foreign_key'   => 'su_id',
        ),

        'storages'      => array(
            'model'         => 'Storage',
            'foreign_key'   => 'su_id',
        ),

    );

    protected $_belongs_to  = array(

        'devtype'    => array(
            'model'         => 'Devtype',
            'foreign_key'   => 'devtype_id',
        ),

        'vendor'     => array(
            'model'         => 'Vendor',
            'foreign_key'   => 'vendor_id',
        ),

        'location'   => array(
            'model'         => 'Location',
            'foreign_key'   => 'location_id',
        ),

        'status'     => array(
            'model'         => 'Status',
            'foreign_key'   => 'status_id',
        ),

        'workplace'     => array(
            'model'         => 'Workplace',
            'foreign_key'   => 'wp_id',
        ),

    );


    public $table_name   = 'sysunits';
    public $id_column    = 'su_id';
    public $date_pattern = '(((0[1-9]|[12]\d|3[01])\.(0[13578]|1[02])\.((19|[2-9]\d)\d{2}))|'.
                           '((0[1-9]|[12]\d|30)\.(0[13456789]|1[012])\.((19|[2-9]\d)\d{2}))|'.
                           '((0[1-9]|1\d|2[0-8])\.02\.((19|[2-9]\d)\d{2}))|(29\.02\.'.
                           '((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|'.
                           '((16|[2468][048]|[3579][26])00))))';


    public function getDefaultVars()
    {
        return array(
            'table_name'        => $this->table_name,
            'id_column'         => $this->id_column,
            'field_devtype'     => 'Тип устройства',
            'field_vendor'      => 'Вендор',
            'field_model'       => 'Модель',
            'field_location'    => 'Локация',
            'field_status'      => 'Статус',
            'field_workplace'   => 'Рабочее место',
            'field_fa'          => 'Основное средство',
            'field_inv_num'     => 'Инв. номер',
            'field_inv_status'  => 'Инв. статус',
            'field_com_date'    => 'Дата ввода',
            'field_note'        => 'Заметка',
            'date_pattern'      => $this->date_pattern,
        );
    }


    public function invNumCheck($inv_num)
    {
        $query = ORM::factory('Sysunit')
            ->where('inv_num', '=', $inv_num)
            ->find();
        if($query->loaded())
        {
            return TRUE;

        } else
        {
            return FALSE;
        }
    }



    private function IDCheck($check_IDs)
    {
        $flag = TRUE;
        foreach ($check_IDs as $model => $id)
        {
            $check = ORM::factory($model, $id);
            if (!$check->loaded())
            {
                $flag = FALSE;
            }
        }

        return $flag;
    }






    public function addSysunit($to_add)
    {
        extract($to_add);

        if ($com_date != '')
        {
            $cd = explode('.', $com_date);
            $day       = $cd[0];
            $month     = $cd[1];
            $year      = $cd[2];
            $com_date = mktime(0, 0, 0, $month, $day, $year);

        } elseif ($com_date == '')
        {
            $com_date = NULL;
        }

        $check_IDs = array();
        if ($devtype_id != '')  $check_IDs['Devtype']   = $devtype_id;
        if ($vendor_id != '')   $check_IDs['Vendor']    = $vendor_id;
        if ($location_id != '') $check_IDs['Location']  = $location_id;
        if ($status_id != '')   $check_IDs['Status']    = $status_id;

        if ($this->IDCheck($check_IDs))
        {
            if (isset($model) && $model != '')      $model      = htmlentities($model, ENT_QUOTES, "UTF-8");
            if (isset($fa) && $fa != '')            $fa         = htmlentities($fa, ENT_QUOTES, "UTF-8");
            if (isset($inv_num) && $inv_num != '')  $inv_num    = htmlentities($inv_num, ENT_QUOTES, "UTF-8");
            if (isset($note)    && $note != '')     $note       = htmlentities($note, ENT_QUOTES, "UTF-8");

            $result = array(
                'devtype_id'    =>  $devtype_id,
                'vendor_id'     =>  $vendor_id,
                'model'         =>  $model,
                'location_id'   =>  $location_id,
                'status_id'     =>  $status_id,
                'fa'            =>  $fa,
                'inv_num'       =>  $inv_num,
                'inv_status'    =>  $inv_status,
                'com_date'      =>  date("d.m.Y", $com_date),
                'note'          =>  $note,
            );
            
            if (
                ($fa != ''  &&  $inv_num != ''  &&  $inv_status == 'B') ||
                ($fa == ''  &&  $inv_num == ''  &&  $inv_status == 'G')
                )
            {
                $result['res_status']    = 'fail';
                $result['res_message']   = 'Ошибка! Выбран несоотв-щий Инв.статус!';

            } elseif ($fa != ''  &&  $inv_num == ''  &&  $inv_status == 'G')
            {
                $result['res_status']    = 'fail';
                $result['res_message']   = 'Ошибка! Не введен Инв.номер!';

            } elseif ($fa == ''  &&  $inv_num != ''  &&  $inv_status == 'G')
            {
                $result['res_status']    = 'fail';
                $result['res_message']   = 'Ошибка! Не введено Основное средство!';

            } elseif 
                (
                ($fa != ''  &&  $inv_num != ''  &&  $inv_status == 'G') ||
                ($fa == ''  &&  $inv_num == ''  &&  $inv_status == 'B') ||
                ($fa == ''  &&  $inv_num != ''  &&  $inv_status == 'B') ||
                ($fa != ''  &&  $inv_num == ''  &&  $inv_status == 'B')
                )
            {
                if ($inv_num != ''  &&  $this->invNumCheck($inv_num))
                {
                    $result['res_status']    = 'fail';
                    $result['res_message']   = 'Ошибка! Запись с таким Инв.номером уже существует!';

                } else
                {
                    if ((isset($year)  &&  $year > 1990  &&  $year < 2050)  || $com_date === NULL)
                    {
                        $oper_add = ORM::factory('Sysunit');
                        $oper_add->devtype_id   =   $devtype_id;
                        $oper_add->vendor_id    =   $vendor_id;
                        $oper_add->model        =   $model;
                        $oper_add->location_id  =   $location_id;
                        $oper_add->status_id    =   $status_id;
                        $oper_add->fa           =   $fa;
                        $oper_add->inv_num      =   $inv_num;
                        $oper_add->inv_status   =   $inv_status;
                        $oper_add->com_date     =   $com_date;
                        $oper_add->note         =   $note;
                        $oper_add->create();

                        $result = array(
                            'res_status'    => 'success',
                            'res_message'   => 'Успех! Запись добавлена!',
                        );

                    } else
                    {
                        $result['res_status']    =  'fail';
                        $result['res_message']   =  "Ошибка! Год Даты ввода не входит в диапозон 1995-2040!";
                    }
                }
            }

        } else
        {
            $result['res_status']    =  'fail';
            $result['res_message']   =  "Ошибка! Неверный ID одного из селекторов: ".
                                        "Тип устройства, Вендор, Локация или Статус!";
        }

        return $result;

    } //End addSysunit function





    public function editSysunit($to_edit)
    {
        extract($to_edit);

        if ($com_date != '')
        {
            $cd = explode('.', $com_date);
            $day       = $cd[0];
            $month     = $cd[1];
            $year      = $cd[2];
            $com_date = mktime(0, 0, 0, $month, $day, $year);

        } elseif ($com_date == '')
        {
            $com_date = NULL;
        }

        $check_IDs = array();
        if ($devtype_id != '')  $check_IDs['Devtype']   = $devtype_id;
        if ($vendor_id != '')   $check_IDs['Vendor']    = $vendor_id;
        if ($location_id != '') $check_IDs['Location']  = $location_id;
        if ($status_id != '')   $check_IDs['Status']    = $status_id;

        if ($this->IDCheck($check_IDs))
        {
            if (isset($model) && $model != '')      $model      = htmlentities($model, ENT_QUOTES, "UTF-8");
            if (isset($fa) && $fa != '')            $fa         = htmlentities($fa, ENT_QUOTES, "UTF-8");
            if (isset($inv_num) && $inv_num != '')  $inv_num    = htmlentities($inv_num, ENT_QUOTES, "UTF-8");
            if (isset($note)    && $note != '')     $note       = htmlentities($note, ENT_QUOTES, "UTF-8");

            $result = array(
                'id'            => $id,
                'devtype_id'    => $devtype_id,
                'vendor_id'     => $vendor_id,
                'model'         => $model,
                'location_id'   => $location_id,
                'status_id'     => $status_id,
                'fa'            => $fa,
                'inv_num'       => $inv_num,
                'inv_status'    => $inv_status,
                'com_date'      => $com_date,
                'note'          => $note,
            );
            
            if (
                ($fa != ''  &&  $inv_num != ''  &&  $inv_status == 'B') ||
                ($fa == ''  &&  $inv_num == ''  &&  $inv_status == 'G')
                )
            {
                $result['res_status']    = 'fail';
                $result['res_message']   = 'Ошибка! Выбран несоотв-щий Инв.статус!';

            } elseif ($fa != ''  &&  $inv_num == ''  &&  $inv_status == 'G')
            {
                $result['res_status']    = 'fail';
                $result['res_message']   = 'Ошибка! Не введен Инв.номер!';

            } elseif ($fa == ''  &&  $inv_num != ''  &&  $inv_status == 'G')
            {
                $result['res_status']    = 'fail';
                $result['res_message']   = 'Ошибка! Не введено Основное средство!';

            } elseif 
                (
                ($fa != ''  &&  $inv_num != ''  &&  $inv_status == 'G') ||
                ($fa == ''  &&  $inv_num == ''  &&  $inv_status == 'B') ||
                ($fa == ''  &&  $inv_num != ''  &&  $inv_status == 'B') ||
                ($fa != ''  &&  $inv_num == ''  &&  $inv_status == 'B')
                )
            {    
                if ((isset($year)  &&  $year > 1995  &&  $year < 2040)  || $com_date === NULL)
                {
                    $oper_edit = ORM::factory('Sysunit', $id);
                    $oper_edit->devtype_id  =   $devtype_id;
                    $oper_edit->vendor_id   =   $vendor_id;
                    $oper_edit->model       =   $model;
                    $oper_edit->location_id =   $location_id;
                    $oper_edit->status_id   =   $status_id;
                    $oper_edit->fa          =   $fa;
                    $oper_edit->inv_num     =   $inv_num;
                    $oper_edit->inv_status  =   $inv_status;
                    $oper_edit->com_date    =   $com_date;
                    $oper_edit->note        =   $note;
                    $oper_edit->update();

                    $result = array(
                        'res_status'    => 'success',
                        'res_message'   => 'Успех! Запись добавлена!',
                    );

                } else
                {
                    $result['res_status']    =  'fail';
                    $result['res_message']   =  "Ошибка! Год Даты ввода не входит в диапозон 1995-2040!";
                }
            }

        } else
        {
            $result['res_status']    =  'fail';
            $result['res_message']   =  "Ошибка! Неверный ID одного из селекторов: ".
                                        "Тип устройства, Вендор, Локация или Статус!";
        }

        return $result;

    } //End editSysunit function





    public function operations($oper_arr)
    {
        extract($oper_arr);

        $status_use             = ORM::factory('Status')
            ->where('status_name', '=', 'используется')
            ->find()
            ->status_id;

        $status_keeping         = ORM::factory('Status')
            ->where('status_name', '=', 'хранение')
            ->find()
            ->status_id;
        
        $su_location_id         = ORM::factory('Sysunit', $su_id)->location_id;
        $office7_location_id    = 2;
        if (isset($old_id)) $current_unit = ORM::factory($model, $old_id);
        $new_unit               = ORM::factory($model, $new_id);

        if ($operation == 'install')
        {
            $new_unit->location_id  = $su_location_id;
            $new_unit->status_id    = $status_use;
            $new_unit->su_id        = $su_id;
            $new_unit->update();

        } elseif ($operation == 'replace')
        {
            $current_unit->location_id  = $office7_location_id;
            $current_unit->status_id    = $status_keeping;
            $current_unit->su_id        = NULL;
            $current_unit->update();

            $new_unit->location_id  = $su_location_id;
            $new_unit->status_id    = $status_use;
            $new_unit->su_id        = $su_id;
            $new_unit->update();

        } elseif ($operation == 'deinstall')
        {
            $new_unit->location_id  = $office7_location_id;
            $new_unit->status_id    = $status_keeping;
            $new_unit->su_id        = NULL;
            $new_unit->update();
        }
    
    }//End operation function





    public function deleteSysunit($id)
    {
        $units_title = array('Motherboard', 'Cpu', 'Ram', 'Videocard', 'Storage', 'Pwrsupply');
        $office7_location_id    = 2; // ID локации 7 офиса
        $status_keeping         = ORM::factory('Status')
            ->where('status_name', '=', 'хранение')
            ->find()->status_id;
        
        function checkAndDeinstallAndRelocationUnits($units_title, $id, $office7_location_id, $status_keeping)
        {
            foreach ($units_title as $unit_title)
            {
                $units = ORM::factory($unit_title)->where('su_id', '=', $id)->find_all();
                if ($units->count() > 0)
                {
                    foreach ($units as $unit)
                    {
                        $unit->location_id  = $office7_location_id;
                        $unit->status_id    = $status_keeping;
                        $unit->su_id        = NULL;
                    }
                }
            }
        }
        
        $delete_sysunit = ORM::factory('Sysunit', $id);

        if ($delete_sysunit->loaded())
        {
            checkAndDeinstallAndRelocationUnits($units_title, $id, $office7_location_id, $status_keeping);
            $delete_sysunit->delete();

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





    public function delete_with_all_units($id)
    {
        $units_title = array('Motherboard', 'Cpu', 'Ram', 'Videocard', 'Storage', 'Pwrsupply');
        
        function checkAndDeleteUnits($units_title, $id)
        {
            foreach ($units_title as $unit_title)
            {
                $units = ORM::factory($unit_title)->where('su_id', '=', $id)->find_all();
                if ($units->count() > 0)
                {
                    foreach ($units as $unit)
                    {
                        $unit->delete();
                    }
                }
            }
        }
        
        $delete_sysunit = ORM::factory('Sysunit', $id);

        if ($delete_sysunit->loaded())
        {
            checkAndDeleteUnits($units_title, $id);
            $delete_sysunit->delete();

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

    } //End delete_with_all_units fuction



} // End Sysunit Model