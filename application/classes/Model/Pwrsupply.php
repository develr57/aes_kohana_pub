<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Pwrsupply extends ORM {

    protected $_table_name  = 'pwrsupplies';
    protected $_primary_key = 'ps_id';

    protected $_has_one     = array(

        'pwrsupplies'   => array(
            'model'         => 'Pwrsupply',
            'foreign_key'   => 'su_id',
        ),

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

    );


    public $table_name          = 'pwrsupplies';
    public $id_column           = 'ps_id';
    public $select_power        = array(
        300, 350, 380,
        400, 430, 450,
        500, 520, 530, 550, 560, 585,
        600, 620, 635, 650,
        700, 720, 735, 750, 760, 780,
        800, 850, 
        900,
    );



    public function getDefaultVars()
    {
        return array(
            'table_name'        => $this->table_name,
            'id_column'         => $this->id_column,
            'devtype_id'        => ORM::factory('Devtype')
                                    ->where('devtype_name', '=', 'Блок питания')
                                    ->find(),
            'field_devtype'     => 'Тип устройства',
            'field_vendor'      => 'Вендор',
            'field_model'       => 'Модель',
            'field_power'       => 'Мощность',
            'field_location'    => 'Локация',
            'field_status'      => 'Статус',
            'field_sysunit'     => 'Системный блок',
            'field_note'        => 'Заметка',
            'select_power'      => $this->select_power,
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






    public function addPwrsupply($to_add)
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
            'power'         =>  $power,
            'location_id'   =>  $location_id,
            'status_id'     =>  $status_id,
            'note'          =>  $note,
        );

        if ($this->IDCheck($check_IDs))
        {
            if (isset($model)   &&  $model != ''  &&
                isset($power)   &&  is_int($power))
            {
                $model  = htmlentities($model, ENT_QUOTES, "UTF-8");
                if (isset($note) && $note != '') $note = htmlentities($note, ENT_QUOTES, "UTF-8");

                $oper_add = ORM::factory('Pwrsupply');
                $oper_add->devtype_id   = $devtype_id;
                $oper_add->vendor_id    = $vendor_id;
                $oper_add->model        = $model;
                $oper_add->power        = $power;
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
                                            " в селекторе Мощность!";
            }

        } else
        {
            $result['res_status']    =  'fail';
            $result['res_message']   =  "Ошибка! Неверный ID одного из селекторов: ".
                                        "Тип устройства, Вендор, Локация, Статус!";
        }

        return $result;

    } //End addPwrsupply function











    public function editPwrsupply($to_edit)
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
            'power'         =>  $power,
            'location_id'   =>  $location_id,
            'status_id'     =>  $status_id,
            'note'          =>  $note,
        );

        if ($this->IDCheck($check_IDs))
        {
            if (isset($model)   &&  $model != ''    &&
                isset($power)   &&  is_int($power))
            {
                $model = htmlentities($model, ENT_QUOTES, "UTF-8");
                if (isset($note) && $note != '') $note = htmlentities($note, ENT_QUOTES, "UTF-8");
            
                $oper_edit = ORM::factory('Pwrsupply', $id);
                $oper_edit->devtype_id      =   $devtype_id;
                $oper_edit->vendor_id       =   $vendor_id;
                $oper_edit->model           =   $model;
                $oper_edit->power           =   $power;
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
                                            " в селекторе Мощность!";
            }

        } else
        {
            $result['res_status']    =  'fail';
            $result['res_message']   =  "Ошибка! Неверный ID одного из селекторов: ".
                                        "Тип устройства, Вендор, Локация, Статус!";
        }

        return $result;

    } //End editPwrsupply function

} // End Pwrsupply Model