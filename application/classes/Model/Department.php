<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Department extends ORM {

    protected $_table_name  = 'departments';
    protected $_primary_key = 'dept_id';

    protected $_has_many    = array(

        'employees'     => array(
            'model'         => 'Employee',
            'foreign_key'   => 'dept_id',
        ),

        'workplaces'    => array(
            'model'         => 'Workplace',
            'foreign_key'   => 'dept_id',
        ),

    );


    public $table_name  =   'departments';
    public $id_column   =   'dept_id';
    public $text_column =   'dept_name';
    public $label_field =   'Отдел';

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
        $query = ORM::factory('Department')
            ->where('dept_name', '=', $text_value)
            ->find();
        if($query->loaded())
        {
            return TRUE;

        } else
        {
            return FALSE;
        }
    }




    public function addDept($text_value)
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
                $oper_add = ORM::factory('Department');
                $oper_add->dept_name = $text_value;
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

    } //End addDept function




    public function editDept($to_edit)
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
                $oper_edit = ORM::factory('Department', $id);
                $oper_edit->dept_name = $text_value;
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
    } // End editDept function

} // End Department Model
