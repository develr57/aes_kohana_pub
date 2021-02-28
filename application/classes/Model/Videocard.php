<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Videocard extends ORM {

    protected $_table_name  = 'videocards';
    protected $_primary_key = 'vc_id';

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

        'sysunit'   => array(
            'model'         => 'Sysunit',
            'foreign_key'   => 'su_id',
        ),

    );

    public $table_name          = 'videocards';
    public $id_column           = 'vc_id';
    public $select_gpu_vendor   = array(
        'N' =>  'NVIDIA',
        'A' =>  'AMD',
    );
    public $select_mem_capacity = array(
        64, 96, 128, 256, 384, 512, 768,
        1024, 1536, 2048, 3072, 4096, 6144, 8192,
        11264, 12288, 16384,
    );




    public function getDefaultVars()
    {
        return array(
            'table_name'            => $this->table_name,
            'id_column'             => $this->id_column,
            'devtype_id'            => ORM::factory('Devtype')
                                        ->where('devtype_name', '=', 'Видеокарта')
                                        ->find(),
            'field_devtype'         => 'Тип устройства',
            'field_vendor'          => 'Вендор',
            'field_gpu_vendor'      => 'Вендор ГПУ',
            'field_model'           => 'Модель',
            'field_mem_capacity'    => 'Объем видеопамяти',
            'field_location'        => 'Локация',
            'field_status'          => 'Статус',
            'field_sysunit'         => 'Системный блок',
            'field_note'            => 'Заметка',
            'select_gpu_vendor'     => $this->select_gpu_vendor,
            'select_mem_capacity'   => $this->select_mem_capacity,
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






    public function addVideocard($to_add)
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
            'gpu_vendor'    =>  $gpu_vendor,
            'model'         =>  $model,
            'mem_capacity'  =>  $mem_capacity,
            'location_id'   =>  $location_id,
            'status_id'     =>  $status_id,
            'note'          =>  $note,
        );

        if ($this->IDCheck($check_IDs))
        {
            if (isset($model)           &&  $model != ''        &&
                isset($mem_capacity)    &&  is_int($mem_capacity))
            {
                $model = htmlentities($model, ENT_QUOTES, "UTF-8");
                if (isset($note) && $note != '') $note = htmlentities($note, ENT_QUOTES, "UTF-8");

                $oper_add = ORM::factory('Videocard');
                $oper_add->devtype_id   = $devtype_id;
                $oper_add->vendor_id    = $vendor_id;
                $oper_add->gpu_vendor   = $gpu_vendor;
                $oper_add->model        = $model;
                $oper_add->mem_capacity = $mem_capacity;
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
                                            " в селекторе Объем видеопамяти!";
            }

        } else
        {
            $result['res_status']    =  'fail';
            $result['res_message']   =  "Ошибка! Неверный ID одного из селекторов: ".
                                        "Тип устройства, Вендор, Локация, Статус!";
        }

        return $result;

    } //End addVideocard function











    public function editVideocard($to_edit)
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
            'gpu_vendor'    =>  $gpu_vendor,
            'model'         =>  $model,
            'mem_capacity'  =>  $mem_capacity,
            'location_id'   =>  $location_id,
            'status_id'     =>  $status_id,
            'note'          =>  $note,
        );

        if ($this->IDCheck($check_IDs))
        {
            if (isset($model)           &&  $model != ''        &&
                isset($mem_capacity)    &&  is_int($mem_capacity))
            {
                $model = htmlentities($model, ENT_QUOTES, "UTF-8");
                if (isset($note) && $note != '') $note = htmlentities($note, ENT_QUOTES, "UTF-8");
            
                $oper_edit = ORM::factory('Videocard', $id);
                $oper_edit->devtype_id      =   $devtype_id;
                $oper_edit->vendor_id       =   $vendor_id;
                $oper_edit->gpu_vendor      =   $gpu_vendor;
                $oper_edit->model           =   $model;
                $oper_edit->mem_capacity    =   $mem_capacity;
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
                                            " в селекторе Объем видеопамяти!";
            }

        } else
        {
            $result['res_status']    =  'fail';
            $result['res_message']   =  "Ошибка! Неверный ID одного из селекторов: ".
                                        "Тип устройства, Вендор, Локация, Статус!";
        }

        return $result;

    } //End editVideocard function

} // End Videocard Model