<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Status extends ORM {

    protected $_table_name  = 'statuses';
    protected $_primary_key = 'status_id';

    protected $_has_many    = array(

        'workplaces'    => array(
            'model'         => 'Workplace',
            'foreign_key'   => 'status_id',
        ),

        'sysunits'      => array(
            'model'         => 'Sysunit',
            'foreign_key'   => 'status_id',
        ),

        'monitors'      => array(
            'model'         => 'Monitor',
            'foreign_key'   => 'status_id',
        ),

        'upses'         => array(
            'model'         => 'Ups',
            'foreign_key'   => 'status_id',
        ),

        'offequipments' => array(
            'model'         => 'Offequipment',
            'foreign_key'   => 'status_id',
        ),

        'cpus'          => array(
            'model'         => 'Cpu',
            'foreign_key'   => 'status_id',
        ),

        'motherboards'  => array(
            'model'         => 'Motherboard',
            'foreign_key'   => 'status_id',
        ),

        'rams'          => array(
            'model'         => 'Ram',
            'foreign_key'   => 'status_id',
        ),

        'videocards'    => array(
            'model'         => 'Videocard',
            'foreign_key'   => 'status_id',
        ),

        'storages'      => array(
            'model'         => 'Storage',
            'foreign_key'   => 'status_id',
        ),

        'pwrsupplies'   => array(
            'model'         => 'Pwrsupply',
            'foreign_key'   => 'status_id',
        ),

    );


    public $table_name  =   'statuses';
    public $id_column   =   'status_id';
    public $text_column =   'status_name';
    public $label_field =   'Статус';

    public function getDefaultVars()
    {
        return array(
            'table_name'        => $this->table_name,
            'id_column'         => $this->id_column,
            'text_column'       => $this->text_column,
            'label_field'       => $this->label_field,
        );
    }


    public function CheckIfExist($text_value)
    {
        $query = ORM::factory('Status')
            ->where('status_name', '=', $text_value)
            ->find();
        if($query->loaded())
        {
            return TRUE;

        } else
        {
            return FALSE;
        }
    }




    public function addStatus($text_value)
    {
        if ($text_value != '')
        {
            $text_value = htmlentities($text_value, ENT_QUOTES, "UTF-8");
            if ($this->CheckIfExist($text_value))
            {
                $result['res_status'] = 'fail';
                $result['res_message'] =
                    "Ошибка! Запись \"".$text_value."\" в таблице \"".$this->table_name."\" уже существует!";
                $result['text_value'] = $text_value;

            } else
            {
                $oper_add = ORM::factory('Status');
                $oper_add->status_name = $text_value;
                $oper_add->create();

                if ($this->CheckIfExist($text_value))
                {
                    $result['res_status'] = 'success';
                    $result['res_message'] =
                        "Успех! Запись \"".$text_value."\" добавлена в таблицу \"".$this->table_name."\"";

                } else
                {
                    $result['res_status'] = 'fail';
                    $result['res_message'] =
                        "Ошибка! Запись не добавлена!";
                }
            }

        } else
        {
            $result['res_status'] = 'fail';
            $result['res_message'] = "Ошибка! Пустая строка!";
        }

        return $result;

    } //End addStatus function




    public function editStatus($to_edit)
    {
        $text_value = $to_edit['text_value'];
        $id = $to_edit['id'];

        if ($text_value != '')
        {
            $text_value = htmlentities($text_value, ENT_QUOTES, "UTF-8");
            if ($this->CheckIfExist($text_value))
            {
                $result['res_status'] = 'fail';
                $result['res_message'] =
                    "Ошибка! Запись \"".$text_value."\" в таблице \"".$this->table_name."\" уже существует!";
                $result['id'] = $id;
                $result['text_value'] = $text_value;

            } else
            {
                $oper_edit = ORM::factory('Status', $id);
                $oper_edit->status_name = $text_value;
                $oper_edit->update();
                $result['res_status'] = 'success';
            }

        } else
        {
            $result['res_status'] = 'fail';
            $result['res_message'] = "Ошибка! Пустая строка!";
            $result['id'] = $id;
            $result['text_value'] = $text_value;
        }

        if (isset($result)) return $result;
    } // End editStatus function

} // End Status Model
