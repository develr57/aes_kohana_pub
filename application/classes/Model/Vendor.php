<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Vendor extends ORM {

    protected $_table_name = 'vendors';
    protected $_primary_key = 'vendor_id';

    protected $_has_many = array(

        'sysunits'      => array(
            'model'         => 'Sysunit',
            'foreign_key'   => 'vendor_id',
        ),

        'monitors'      => array(
            'model'         => 'Monitor',
            'foreign_key'   => 'vendor_id',
        ),

        'upses'         => array(
            'model'         => 'Ups',
            'foreign_key'   => 'vendor_id',
        ),

        'Offequipments' => array(
            'model'         => 'Offequipment',
            'foreign_key'   => 'vendor_id',
        ),

        'cpus'          => array(
            'model'         => 'Cpu',
            'foreign_key'   => 'vendor_id',
        ),

        'motherboards'  => array(
            'model'         => 'Motherboard',
            'foreign_key'   => 'vendor_id',
        ),

        'rams'          => array(
            'model'         => 'Ram',
            'foreign_key'   => 'vendor_id',
        ),

        'videocards'    => array(
            'model'         => 'Videocard',
            'foreign_key'   => 'vendor_id',
        ),

        'storages'      => array(
            'model'         => 'Storage',
            'foreign_key'   => 'vendor_id',
        ),

        'pwrsupplies'   => array(
            'model'         => 'Pwrsupply',
            'foreign_key'   => 'vendor_id',
        ),

    );


    public $table_name  =   'vendors';
    public $id_column   =   'vendor_id';
    public $text_column =   'vendor_name';
    public $label_field =   'Вендор';

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
        $query = ORM::factory('Vendor')
            ->where('vendor_name', '=', $text_value)
            ->find();
        if($query->loaded())
        {
            return TRUE;

        } else
        {
            return FALSE;
        }
    }




    public function addVendor($text_value)
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
                $oper_add = ORM::factory('Vendor');
                $oper_add->vendor_name = $text_value;
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

    } //End addVendor function




    public function editVendor($to_edit)
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
                $oper_edit = ORM::factory('Vendor', $id);
                $oper_edit->vendor_name = $text_value;
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
    } // End editVendor function

} // End Vendor Model
