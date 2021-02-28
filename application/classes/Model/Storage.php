<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Storage extends ORM {

    protected $_table_name = 'storages';
    protected $_primary_key = 'storage_id';

    protected $_has_one = array(

        // 'workplace' => array(
        //     'model'         => 'Workplace',
        //     'foreign_key'   => 'wp_id',
        // ),

    );

    protected $_belongs_to = array(

        'devtype' => array(
            'model'         => 'Devtype',
            'foreign_key'   => 'devtype_id',
        ),

        'vendor' => array(
            'model'         => 'Vendor',
            'foreign_key'   => 'vendor_id',
        ),

        'location' => array(
            'model'         => 'Location',
            'foreign_key'   => 'location_id',
        ),

        'status' => array(
            'model'         => 'Status',
            'foreign_key'   => 'status_id',
        ),

        'sysunit'   => array(
            'model'         => 'Sysunit',
            'foreign_key'   => 'su_id',
        ),

    );


    public $table_name          = 'storages';
    public $id_column           = 'storage_id';
    public $select_capacity     = array(
        1, 2, 4, 8, 16,
        20, 32, 40, 64, 72, 80, 120, 128, 160, 250, 320, 500, 750,
        1024, 1228.8, 1536, 1843.2, 2048, 2457.6, 3072, 4096, 6144, 8192,
        11264, 12288, 14336, 16384,
    );
    public $select_interface    = array(
        'SATA', 'USB', 'ATA', 'eSATA', 'SAS', 'SCSI',
    );
    public $select_formfactor   = array(
        2.5, 3.5,
    );



    public function getDefaultVars()
    {
        return array(
            'table_name'        => $this->table_name,
            'id_column'         => $this->id_column,
            'field_devtype'     => 'Тип устройства',
            'field_vendor'      => 'Вендор',
            'field_model'       => 'Модель',
            'field_capacity'    => 'Объем',
            'field_interface'   => 'Интерфейс',
            'field_formfactor'  => 'Форм-фактор',
            'field_location'    => 'Локация',
            'field_status'      => 'Статус',
            'field_sysunit'     => 'Системный блок',
            'field_note'        => 'Заметка',
            'select_capacity'   => $this->select_capacity,
            'select_interface'  => $this->select_interface,
            'select_formfactor' => $this->select_formfactor,
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






    public function addStorage($to_add)
    {
        extract($to_add);

        $check_IDs = array();
        if ($devtype_id     != '') $check_IDs['Devtype']   = $devtype_id;
        if ($vendor_id      != '') $check_IDs['Vendor']    = $vendor_id;
        if ($location_id    != '') $check_IDs['Location']  = $location_id;
        if ($status_id      != '') $check_IDs['Status']    = $status_id;

        $result = array(
            'devtype_id'    =>  $devtype_id,
            'vendor_id'     =>  $vendor_id,
            'model'         =>  $model,
            'capacity'      =>  $capacity,
            'interface'     =>  $interface,
            'formfactor'    =>  $formfactor,
            'location_id'   =>  $location_id,
            'status_id'     =>  $status_id,
            'note'          =>  $note,
        );

        if ($this->IDCheck($check_IDs))
        {
            if (isset($model)       &&  $model != ''            &&
                isset($capacity)    &&  is_numeric($capacity)   &&
                isset($interface)   &&  is_string($interface)   &&
                isset($formfactor)  &&  is_numeric($formfactor))
            {
                $model      = htmlentities($model,      ENT_QUOTES, "UTF-8");
                $interface  = htmlentities($interface,  ENT_QUOTES, "UTF-8");
                if (isset($note) && $note != '') $note = htmlentities($note, ENT_QUOTES, "UTF-8");

                $oper_add = ORM::factory('Storage');
                $oper_add->devtype_id   = $devtype_id;
                $oper_add->vendor_id    = $vendor_id;
                $oper_add->model        = $model;
                $oper_add->capacity     = $capacity;
                $oper_add->interface    = $interface;
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
                                            " в селекторах Объем, Интерфейс, Форм-фактор!";
            }

        } else
        {
            $result['res_status']    =  'fail';
            $result['res_message']   =  "Ошибка! Неверный ID одного из селекторов: ".
                                        "Тип устройства, Вендор, Локация, Статус!";
        }

        return $result;

    } //End addStorage function











    public function editStorage($to_edit)
    {
        extract($to_edit);

        $check_IDs = array();
        if ($devtype_id     != '') $check_IDs['Devtype']    = $devtype_id;
        if ($vendor_id      != '') $check_IDs['Vendor']     = $vendor_id;
        if ($location_id    != '') $check_IDs['Location']   = $location_id;
        if ($status_id      != '') $check_IDs['Status']     = $status_id;

        $result = array(
            'id'            =>  $id,
            'devtype_id'    =>  $devtype_id,
            'vendor_id'     =>  $vendor_id,
            'model'         =>  $model,
            'capacity'      =>  $capacity,
            'interface'     =>  $interface,
            'formfactor'    =>  $formfactor,
            'location_id'   =>  $location_id,
            'status_id'     =>  $status_id,
            'note'          =>  $note,
        );

        if ($this->IDCheck($check_IDs))
        {
            if (isset($model)       &&  $model != ''            &&
                isset($capacity)    &&  is_numeric($capacity)   &&
                isset($interface)   &&  is_string($interface)   &&
                isset($formfactor)  &&  is_numeric($formfactor))
            {
                $model      = htmlentities($model,      ENT_QUOTES, "UTF-8");
                $interface  = htmlentities($interface,  ENT_QUOTES, "UTF-8");
                if (isset($note) && $note != '') $note = htmlentities($note, ENT_QUOTES, "UTF-8");
            
                $oper_edit = ORM::factory('Storage', $id);
                $oper_edit->devtype_id      =   $devtype_id;
                $oper_edit->vendor_id       =   $vendor_id;
                $oper_edit->model           =   $model;
                $oper_edit->capacity        =   $capacity;
                $oper_edit->interface       =   $interface;
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
                                            " в селекторах Объем, Интерфейс, Форм-фактор!";
            }

        } else
        {
            $result['res_status']    =  'fail';
            $result['res_message']   =  "Ошибка! Неверный ID одного из селекторов: ".
                                        "Тип устройства, Вендор, Локация, Статус!";
        }

        return $result;

    } //End editStorage function

} // End Storage Model