<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Battery extends ORM {

    protected $_table_name  =   'batteries';
    protected $_primary_key =   'bat_id';

    protected $_has_many = array(

        'upses' => array(
            'model'       => 'Ups',
            'foreign_key' => 'bat_id',
        ),

    );


    public $table_name          =   'batteries';
    public $id_column           =   'bat_id';
    public $field_bat_voltage   =   'Напряжение';
    public $field_bat_capacity  =   'Ёмкость';

    public function getDefaultVars()
    {
        return array(
            'table_name'            =>  $this->table_name,
            'id_column'             =>  $this->id_column,
            'field_bat_voltage'     =>  $this->field_bat_voltage,
            'field_bat_capacity'    =>  $this->field_bat_capacity,
        );
    }


    public function CheckIfExist($checking_arr)
    {
        $bat_voltage    = $checking_arr['bat_voltage'];
        $bat_capacity   = $checking_arr['bat_capacity'];

        $query = ORM::factory('Battery')
            ->where('bat_voltage', '=', $bat_voltage)
            ->and_where('bat_capacity', '=', $bat_capacity)
            ->find();

        if($query->loaded())
        {
            return TRUE;

        } else
        {
            return FALSE;
        }
    }




    public function addBattery($to_add)
    {
        if ($this->CheckIfExist($to_add))
        {
            $result['res_status']   = 'fail';
            $result['res_message']  =
                "Ошибка! Такая запись в таблице \"".$this->table_name."\" уже существует!";

        } else
        {
            $oper_add = ORM::factory('Battery')
                ->values($to_add)
                ->create();

            if ($this->CheckIfExist($to_add))
            {
                $result['res_status']   =   'success';
                $result['res_message']  =   "Успех! Запись добавлена!";

            } else
            {
                $result['res_status']   =   'fail';
                $result['res_message']  =   "Ошибка! Запись не добавлена!";
            }
        }

        return $result;

    } //End addBattery function




    public function editBattery($to_edit)
    {
        $id             = $to_edit['id'];
        $bat_voltage    = $to_edit['bat_voltage'];
        $bat_capacity   = $to_edit['bat_capacity'];

        if ($this->CheckIfExist($to_edit))
        {
            $result['res_status']   = 'fail';
            $result['res_message']  =
                "Ошибка! Такая запись в таблице \"".$this->table_name."\" уже существует!";
            $result['id'] = $id;
            //$result['editable_line'] = ORM::factory('Battery', $id);

        } else
        {
            $oper_edit = ORM::factory('Battery', $id);
            $oper_edit->bat_voltage     = $bat_voltage;
            $oper_edit->bat_capacity    = $bat_capacity;
            $oper_edit->update();

            $result['res_status'] = 'success';
        }

        return $result;

    } // End editBattery function

} // End Location Model
