<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Motherboard extends ORM {

    protected $_table_name = 'motherboards';
    protected $_primary_key = 'mb_id';

    protected $_has_one     = array(

        // 'sysunit' => array(
        //     'model'         => 'Sysunit',
        //     'foreign_key'   => 'su_id',
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

        'sysunit' => array(
            'model'         => 'Sysunit',
            'foreign_key'   => 'su_id',
        ),

        'socket' => array(
            'model'         => 'Socket',
            'foreign_key'   => 'socket_id',
        ),

        'ramtype' => array(
            'model'         => 'Ramtype',
            'foreign_key'   => 'ramtype_id',
        ),

    );

    public $table_name              = 'motherboards';
    public $id_column               = 'mb_id';
    public $select_soc_count        = array(
        1, 2, 3, 4, 5, 6, 7, 8, 9, 10,
    );
    public $select_slot_count       = array(
        2, 3, 4, 5, 6, 8, 10,
    );
    public $select_video_out        = array(
        'Y'     =>  'Есть',
        'N'     =>  'Нет',
    );




    public function getDefaultVars()
    {
        return array(
            'table_name'            => $this->table_name,
            'id_column'             => $this->id_column,
            'devtype_id'            => ORM::factory('Devtype')
                                        ->where('devtype_name', '=', 'Мат.плата')
                                        ->find(),
            'field_devtype'         => 'Тип устройства',
            'field_vendor'          => 'Вендор',
            'field_model'           => 'Модель',
            'field_socket'          => 'Тип сокета',
            'field_soc_count'       => 'Кол-во сокетов',
            'field_ramtype'         => 'Тип ОЗУ',
            'field_slot_count'      => 'Слотов под ОЗУ',
            'field_video_out'       => 'Видеовыход',
            'field_location'        => 'Локация',
            'field_status'          => 'Статус',
            'field_sysunit'         => 'Системный блок',
            'field_note'            => 'Заметка',
            'select_soc_count'      => $this->select_soc_count,
            'select_slot_count'     => $this->select_slot_count,
            'select_video_out'      => $this->select_video_out,
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






    public function addMotherboard($to_add)
    {
        extract($to_add);

        $check_IDs = array();
        if ($devtype_id     != '') $check_IDs['Devtype']   = $devtype_id;
        if ($vendor_id      != '') $check_IDs['Vendor']    = $vendor_id;
        if ($location_id    != '') $check_IDs['Location']  = $location_id;
        if ($status_id      != '') $check_IDs['Status']    = $status_id;
        if ($socket_id      != '') $check_IDs['Socket']    = $socket_id;
        if ($ramtype_id     != '') $check_IDs['Ramtype']   = $ramtype_id;

        $result = array(
            'devtype_id'    =>  $devtype_id,
            'vendor_id'     =>  $vendor_id,
            'model'         =>  $model,
            'socket_id'     =>  $socket_id,
            'soc_count'     =>  $soc_count,
            'ramtype_id'    =>  $ramtype_id,
            'slot_count'    =>  $slot_count,
            'video_out'     =>  $video_out,
            'location_id'   =>  $location_id,
            'status_id'     =>  $status_id,
            'note'          =>  $note,
        );

        if ($this->IDCheck($check_IDs))
        {
            if (isset($model)       && $model != ''         &&
                isset($soc_count)   && is_int($soc_count)   &&
                isset($slot_count)  && is_int($slot_count))
            {
                $model = htmlentities($model, ENT_QUOTES, "UTF-8");
                if (isset($note) && $note != '') $note = htmlentities($note, ENT_QUOTES, "UTF-8");

                $oper_add = ORM::factory('Motherboard');
                $oper_add->devtype_id       = $devtype_id;
                $oper_add->vendor_id        = $vendor_id;
                $oper_add->model            = $model;
                $oper_add->socket_id        = $socket_id;
                $oper_add->soc_count        = $soc_count;
                $oper_add->ramtype_id       = $ramtype_id;
                $oper_add->slot_count       = $slot_count;
                $oper_add->video_out        = $video_out;
                $oper_add->location_id      = $location_id;
                $oper_add->status_id        = $status_id;
                $oper_add->note             = $note;
                $oper_add->create();

                $result = array(
                    'res_status'    => 'success',
                    'res_message'   => 'Успех! Запись добавлена!',
                );

            } else
            {
                $result['res_status']    =  'fail';
                $result['res_message']   =  "Ошибка! Не заполнено поле Модель или ошибка".
                                            " в селекторах Кол-во сокетов и Слотов под ОЗУ!";
            }

        } else
        {
            $result['res_status']    =  'fail';
            $result['res_message']   =  "Ошибка! Неверный ID одного из селекторов: ".
                                        "Тип устройства, Вендор, Локация, Статус, Сокет, Тип ОЗУ!";
        }

        return $result;

    } //End addMotherboard function











    public function editMotherboard($to_edit)
    {
        extract($to_edit);

        $check_IDs = array();
        if ($devtype_id     != '') $check_IDs['Devtype']    = $devtype_id;
        if ($vendor_id      != '') $check_IDs['Vendor']     = $vendor_id;
        if ($location_id    != '') $check_IDs['Location']   = $location_id;
        if ($status_id      != '') $check_IDs['Status']     = $status_id;
        if ($socket_id      != '') $check_IDs['Socket']     = $socket_id;
        if ($ramtype_id     != '') $check_IDs['Ramtype']    = $ramtype_id;

        $result = array(
            'id'            =>  $id,
            'devtype_id'    =>  $devtype_id,
            'vendor_id'     =>  $vendor_id,
            'model'         =>  $model,
            'socket_id'     =>  $socket_id,
            'soc_count'     =>  $soc_count,
            'ramtype_id'    =>  $ramtype_id,
            'slot_count'    =>  $slot_count,
            'video_out'     =>  $video_out,
            'location_id'   =>  $location_id,
            'status_id'     =>  $status_id,
            'note'          =>  $note,
        );

        if ($this->IDCheck($check_IDs))
        {
            if (isset($model)       && $model != ''         &&
                isset($soc_count)   && is_int($soc_count)   &&
                isset($slot_count)  && is_int($slot_count))
            {
                $model = htmlentities($model, ENT_QUOTES, "UTF-8");
                if (isset($note) && $note != '') $note = htmlentities($note, ENT_QUOTES, "UTF-8");
            
                $oper_edit = ORM::factory('Motherboard', $id);
                $oper_edit->devtype_id      =   $devtype_id;
                $oper_edit->vendor_id       =   $vendor_id;
                $oper_edit->model           =   $model;
                $oper_edit->socket_id       =   $socket_id;
                $oper_edit->soc_count       =   $soc_count;
                $oper_edit->ramtype_id      =   $ramtype_id;
                $oper_edit->slot_count      =   $slot_count;
                $oper_edit->video_out       =   $video_out;
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
                                            " в селекторах Кол-во сокетов и Слотов под ОЗУ!";
            }

        } else
        {
            $result['res_status']    =  'fail';
            $result['res_message']   =  "Ошибка! Неверный ID одного из селекторов: ".
                                        "Тип устройства, Вендор, Локация, Статус, Сокет, Тип ОЗУ!";
        }

        return $result;

    } //End editMotherboard function

} // End Motherboard Model