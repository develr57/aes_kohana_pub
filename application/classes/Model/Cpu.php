<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Cpu extends ORM {

    protected $_table_name = 'cpus';
    protected $_primary_key = 'cpu_id';

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

        'socket' => array(
            'model'         => 'Socket',
            'foreign_key'   => 'socket_id',
        ),

        'sysunit' => array(
            'model'         => 'Sysunit',
            'foreign_key'   => 'su_id',
        ),

    );


    public $table_name              = 'cpus';
    public $id_column               = 'cpu_id';

    public $select_clock_speed      = array(
        2.0, 2.1, 2.2, 2.3, 2.4, 2.5, 2.6, 2.7, 2.8, 2.9,
        3.0, 3.1, 3.2, 3.3, 3.4, 3.5, 3.6, 3.7, 3.8, 3.9,
        4.0, 4.1, 4.2, 4.3, 4.4, 4.5, 4.6,
        1.0, 1.1, 1.2, 1.3, 1.4, 1.5, 1.6, 1.7, 1.8, 1.9,
    );

    public $select_cores_threads    = array(
        '1/1', '1/2', '2/2', '2/4', '4/4', '4/8', '6/6', '6/12', '8/8', '8/16',
        '10/10', '10/20', '12/12', '12/24', '14/14', '14/28', '16/16', '16/32',
        '18/18', '18/36', '20/40',
    );




    public function getDefaultVars()
    {
        return array(
            'table_name'            => $this->table_name,
            'id_column'             => $this->id_column,
            'devtype_id'            => ORM::factory('Devtype')
                                        ->where('devtype_name', '=', 'ЦПУ')
                                        ->find(),
            'field_devtype'         => 'Тип устройства',
            'field_vendor'          => 'Вендор',
            'field_model'           => 'Модель',
            'field_clock_speed'     => 'Тактовая частота',
            'field_cores_threads'   => 'Ядер / Потоков',
            'field_socket'          => 'Тип сокета',
            'field_location'        => 'Локация',
            'field_status'          => 'Статус',
            'field_sysunit'         => 'Системный блок',
            'field_note'            => 'Заметка',
            'select_clock_speed'    => $this->select_clock_speed,
            'select_cores_threads'  => $this->select_cores_threads,
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






    public function addCpu($to_add)
    {
        extract($to_add);

        $check_IDs = array();
        if ($devtype_id     != '') $check_IDs['Devtype']   = $devtype_id;
        if ($vendor_id      != '') $check_IDs['Vendor']    = $vendor_id;
        if ($location_id    != '') $check_IDs['Location']  = $location_id;
        if ($status_id      != '') $check_IDs['Status']    = $status_id;
        if ($socket_id      != '') $check_IDs['Socket']    = $socket_id;

        $result = array(
            'devtype_id'    =>  $devtype_id,
            'vendor_id'     =>  $vendor_id,
            'model'         =>  $model,
            'clock_speed'   =>  $clock_speed,
            'cores_threads' =>  $cores_threads,
            'socket_id'     =>  $socket_id,
            'location_id'   =>  $location_id,
            'status_id'     =>  $status_id,
            'note'          =>  $note,
        );

        if ($this->IDCheck($check_IDs))
        {
            if (isset($model)         && $model         != '' &&
                isset($clock_speed)   && $clock_speed   != '' &&
                isset($cores_threads) && $cores_threads != '')
            {
                $model         = htmlentities($model,         ENT_QUOTES, "UTF-8");
                $clock_speed   = htmlentities($clock_speed,   ENT_QUOTES, "UTF-8");
                $cores_threads = htmlentities($cores_threads, ENT_QUOTES, "UTF-8");
                if (isset($note) && $note != '') $note = htmlentities($note, ENT_QUOTES, "UTF-8");

                $oper_add = ORM::factory('Cpu');
                $oper_add->devtype_id       = $devtype_id;
                $oper_add->vendor_id        = $vendor_id;
                $oper_add->model            = $model;
                $oper_add->clock_speed      = $clock_speed;
                $oper_add->cores_threads    = $cores_threads;
                $oper_add->socket_id        = $socket_id;
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
                                            " в селекторах Тактовая частота и Ядер/Потоков!";
            }

        } else
        {
            $result['res_status']    =  'fail';
            $result['res_message']   =  "Ошибка! Неверный ID одного из селекторов: ".
                                        "Тип устройства, Вендор, Локация или Статус!";
        }

        return $result;

    } //End addCpu function











    public function editCpu($to_edit)
    {
        extract($to_edit);

        $check_IDs = array();
        if ($devtype_id     != '') $check_IDs['Devtype']   = $devtype_id;
        if ($vendor_id      != '') $check_IDs['Vendor']    = $vendor_id;
        if ($location_id    != '') $check_IDs['Location']  = $location_id;
        if ($status_id      != '') $check_IDs['Status']    = $status_id;
        if ($socket_id      != '') $check_IDs['Socket']    = $socket_id;

        $result = array(
            'id'            =>  $id,
            'devtype_id'    =>  $devtype_id,
            'vendor_id'     =>  $vendor_id,
            'model'         =>  $model,
            'clock_speed'   =>  $clock_speed,
            'cores_threads' =>  $cores_threads,
            'socket_id'     =>  $socket_id,
            'location_id'   =>  $location_id,
            'status_id'     =>  $status_id,
            'note'          =>  $note,
        );

        if ($this->IDCheck($check_IDs))
        {
            if (isset($model)         &&  $model         != '' &&
                isset($clock_speed)   &&  $clock_speed   != '' &&
                isset($cores_threads) &&  $cores_threads != '')
            {
                $model         = htmlentities($model,         ENT_QUOTES, "UTF-8");
                $clock_speed   = htmlentities($clock_speed,   ENT_QUOTES, "UTF-8");
                $cores_threads = htmlentities($cores_threads, ENT_QUOTES, "UTF-8");
                if (isset($note) && $note != '') $note = htmlentities($note, ENT_QUOTES, "UTF-8");
            
                $oper_edit = ORM::factory('Cpu', $id);
                $oper_edit->devtype_id      =   $devtype_id;
                $oper_edit->vendor_id       =   $vendor_id;
                $oper_edit->model           =   $model;
                $oper_edit->clock_speed     =   $clock_speed;
                $oper_edit->cores_threads   =   $cores_threads;
                $oper_edit->socket_id       =   $socket_id;
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
                                            " в селекторах Тактовая частота и Ядер/Потоков!";
            }

        } else
        {
            $result['res_status']    =  'fail';
            $result['res_message']   =  "Ошибка! Неверный ID одного из селекторов: ".
                                        "Тип устройства, Вендор, Локация или Статус!";
        }

        return $result;

    } //End editCpu function

} // End Cpu Model