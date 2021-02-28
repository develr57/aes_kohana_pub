<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Ram extends ORM {

    protected $_table_name  = 'rams';
    protected $_primary_key = 'ram_id';

    protected $_has_one     = array(
    );

    protected $_belongs_to  = array(

        'devtype'   => array(
            'model'         => 'Devtype',
            'foreign_key'   => 'devtype_id',
        ),

        'vendor'    => array(
            'model'         => 'Vendor',
            'foreign_key'   => 'vendor_id',
        ),

        'location'  => array(
            'model'         => 'Location',
            'foreign_key'   => 'location_id',
        ),

        'status'    => array(
            'model'         => 'Status',
            'foreign_key'   => 'status_id',
        ),

        'ramtype'   => array(
            'model'         => 'Ramtype',
            'foreign_key'   => 'ramtype_id',
        ),

        'sysunit'   => array(
            'model'         => 'Sysunit',
            'foreign_key'   => 'su_id',
        ),

    );

    public $table_name      = 'rams';
    public $id_column       = 'ram_id';
    public $select_size     = array(
        1024, 2048, 4096, 8192, 16384, 32768, 512, 256, 128,
    );
    public $select_speed    = array(
        400, 533, 667, 800, 1066, 1333, 1600, 1800, 2133, 2400, 2666,
    );
    public $select_formfactor      = array(
        'DIMM', 'SO-DIMM', 'SDRAM',
    );




    public function getDefaultVars()
    {
        return array(
            'table_name'            => $this->table_name,
            'id_column'             => $this->id_column,
            'devtype_id'            => ORM::factory('Devtype')
                                        ->where('devtype_name', '=', 'ОЗУ')
                                        ->find(),
            'field_devtype'         => 'Тип устройства',
            'field_vendor'          => 'Вендор',
            'field_model'           => 'Модель',
            'field_size'            => 'Размер ОЗУ',
            'field_ramtype'         => 'Тип ОЗУ',
            'field_speed'           => 'Скорость',
            'field_formfactor'      => 'Форм-фактор',
            'field_location'        => 'Локация',
            'field_status'          => 'Статус',
            'field_sysunit'         => 'Системный блок',
            'field_note'            => 'Заметка',
            'select_size'           => $this->select_size,
            'select_speed'          => $this->select_speed,
            'select_formfactor'     => $this->select_formfactor,
        );
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






    public function addRam($to_add)
    {
        extract($to_add);

        $check_IDs = array();
        if ($devtype_id     != '') $check_IDs['Devtype']   = $devtype_id;
        if ($vendor_id      != '') $check_IDs['Vendor']    = $vendor_id;
        if ($location_id    != '') $check_IDs['Location']  = $location_id;
        if ($status_id      != '') $check_IDs['Status']    = $status_id;
        if ($ramtype_id     != '') $check_IDs['Ramtype']   = $ramtype_id;

        $result = array(
            'devtype_id'    =>  $devtype_id,
            'vendor_id'     =>  $vendor_id,
            'model'         =>  $model,
            'size'          =>  $size,
            'ramtype_id'    =>  $ramtype_id,
            'speed'         =>  $speed,
            'formfactor'    =>  $formfactor,
            'location_id'   =>  $location_id,
            'status_id'     =>  $status_id,
            'note'          =>  $note,
        );

        if ($this->IDCheck($check_IDs))
        {
            if (isset($size)        &&  is_int($size)  &&
                isset($speed)       &&  is_int($speed) &&
                isset($formfactor)  &&  $formfactor != '')
            {
                $model      = htmlentities($model,      ENT_QUOTES, "UTF-8");
                $formfactor = htmlentities($formfactor, ENT_QUOTES, "UTF-8");
                if (isset($note) && $note != '') $note = htmlentities($note, ENT_QUOTES, "UTF-8");

                $oper_add = ORM::factory('Ram');
                $oper_add->devtype_id   = $devtype_id;
                $oper_add->vendor_id    = $vendor_id;
                $oper_add->model        = $model;
                $oper_add->size         = $size;
                $oper_add->ramtype_id   = $ramtype_id;
                $oper_add->speed        = $speed;
                $oper_add->formfactor   = $formfactor;
                $oper_add->location_id  = $location_id;
                $oper_add->status_id    = $status_id;
                $oper_add->note         = $note;
                $oper_add->create();

                $result = array(
                    'res_status'    => 'success',
                    'res_message'   => 'Успех! Запись добавлена!',
                );

            } else
            {
                $result['res_status']    =  'fail';
                $result['res_message']   =  "Ошибка! Не заполнено поле Модель или ошибка".
                                            " в селекторах Размер ОЗУ и Формактор!";
            }

        } else
        {
            $result['res_status']    =  'fail';
            $result['res_message']   =  "Ошибка! Неверный ID одного из селекторов: ".
                                        "Тип устройства, Вендор, Локация, Статус, Тип ОЗУ!";
        }

        return $result;

    } //End addRam function











    public function editRam($to_edit)
    {
        extract($to_edit);

        $check_IDs = array();
        if ($devtype_id     != '') $check_IDs['Devtype']    = $devtype_id;
        if ($vendor_id      != '') $check_IDs['Vendor']     = $vendor_id;
        if ($location_id    != '') $check_IDs['Location']   = $location_id;
        if ($status_id      != '') $check_IDs['Status']     = $status_id;
        if ($ramtype_id     != '') $check_IDs['Ramtype']    = $ramtype_id;

        $result = array(
            'id'            =>  $id,
            'devtype_id'    =>  $devtype_id,
            'vendor_id'     =>  $vendor_id,
            'model'         =>  $model,
            'size'          =>  $size,
            'ramtype_id'    =>  $ramtype_id,
            'speed'         =>  $speed,
            'formfactor'    =>  $formfactor,
            'location_id'   =>  $location_id,
            'status_id'     =>  $status_id,
            'note'          =>  $note,
        );

        if ($this->IDCheck($check_IDs))
        {
            if (isset($model)       &&  $model != ''   &&
                isset($size)        &&  is_int($size)  &&
                isset($speed)       &&  is_int($speed) &&
                isset($formfactor)  &&  $formfactor != '')
            {
                $model      = htmlentities($model,      ENT_QUOTES, "UTF-8");
                $formfactor = htmlentities($formfactor, ENT_QUOTES, "UTF-8");
                if (isset($note) && $note != '') $note = htmlentities($note, ENT_QUOTES, "UTF-8");
            
                $oper_edit = ORM::factory('Ram', $id);
                $oper_edit->devtype_id      =   $devtype_id;
                $oper_edit->vendor_id       =   $vendor_id;
                $oper_edit->model           =   $model;
                $oper_edit->size            =   $size;
                $oper_edit->ramtype_id      =   $ramtype_id;
                $oper_edit->speed           =   $speed;
                $oper_edit->formfactor      =   $formfactor;
                $oper_edit->location_id     =   $location_id;
                $oper_edit->status_id       =   $status_id;
                $oper_edit->note            =   $note;
                $oper_edit->update();

                $result = array(
                    'res_status'    => 'success',
                );

            } else
            {
                $result['res_status']    =  'fail';
                $result['res_message']   =  "Ошибка! Не заполнено поле Модель или ошибка".
                                            " в селекторах Размер ОЗУ и Формактор!";
            }

        } else
        {
            $result['res_status']    =  'fail';
            $result['res_message']   =  "Ошибка! Неверный ID одного из селекторов: ".
                                        "Тип устройства, Вендор, Локация, Статус, Тип ОЗУ!";
        }

        return $result;

    } //End editRam function

} // End Ram Model