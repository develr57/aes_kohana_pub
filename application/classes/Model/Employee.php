<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Employee extends ORM {

    protected $_table_name  = 'employees';
    protected $_primary_key = 'emp_id';

    protected $_has_one     = array(

        'workplace'     => array(
            'model'         => 'Workplace',
            'foreign_key'   => 'emp_id',
        ),

    );

    protected $_belongs_to  = array(

        'department'    => array(
            'model'         => 'Department',
            'foreign_key'   => 'dept_id',
        ),

    );


    public $table_name          = 'employees';
    public $id_column           = 'emp_id';
    public $field_surname       = 'Фамилия';
    public $field_name          = 'Имя';
    public $field_patronymic    = 'Отчество';
    public $field_short         = 'Кратко';
    public $field_position      = 'Должность';
    public $field_department    = 'Отдел';


    public function getDefaultVars()
    {
        return array(
            'table_name'            => $this->table_name,
            'id_column'             => $this->id_column,
            'field_surname'         => $this->field_surname,
            'field_name'            => $this->field_name,
            'field_patronymic'      => $this->field_patronymic,
            'field_short'           => $this->field_short,
            'field_position'        => $this->field_position,
            'field_department'      => $this->field_department,
        );
    }


    public function CheckIfExist($check_arr)
    {
        extract($check_arr);

        if (isset($id))
        {
            $query = ORM::factory('Employee')
                ->where('surname',     '=',  $surname)
                ->where('name',        '=',  $name)
                ->where('patronymic',  '=',  $patronymic)
                ->where('emp_id',      '!=', $id)
                ->find();
        } else
        {
            $query = ORM::factory('Employee')
                ->where('surname',     '=', $surname)
                ->where('name',        '=', $name)
                ->where('patronymic',  '=', $patronymic)
                ->find();
        }
        if($query->loaded())
        {
            return TRUE;

        } else
        {
            return FALSE;
        }
    }





    public function addEmployee($to_add)
    {
        extract($to_add);
        extract($this->getDefaultVars());

        if ($surname        != ''  &&
            $name           != ''  &&
            $patronymic     != ''  &&
            $position       != ''  &&
            $dept_id    != '')
        {
            $surname    = htmlentities($surname,    ENT_QUOTES, "UTF-8");
            $name       = htmlentities($name,       ENT_QUOTES, "UTF-8");
            $patronymic = htmlentities($patronymic, ENT_QUOTES, "UTF-8");
            $position   = htmlentities($position,   ENT_QUOTES, "UTF-8");
            $short = $surname." ".
                mb_strtoupper(mb_substr($name, 0, 1)).".".
                mb_strtoupper(mb_substr($patronymic, 0, 1)).".";

            $result = array(
                'surname'       => $surname,
                'name'          => $name,
                'patronymic'    => $patronymic,
                'position'      => $position,
                'dept_id'       => $dept_id,
            );

            $check_arr = array(
                'surname'       => $surname,
                'name'          => $name,
                'patronymic'    => $patronymic,
            );
            
            if ($this->CheckIfExist($check_arr))
            {
                $result['res_status']    = 'fail';
                $result['res_message']   = "Ошибка! Такая запись уже существует!";

            } else
            {
                $check_dept_id = ORM::factory('Department')
                    ->where('dept_id', '=', $dept_id)
                    ->find();

                if ($check_dept_id->loaded())
                {
                    $oper_add = ORM::factory('Employee');
                    $oper_add->surname     = $surname;
                    $oper_add->name        = $name;
                    $oper_add->patronymic  = $patronymic;
                    $oper_add->short       = $short;
                    $oper_add->position    = $position;
                    $oper_add->dept_id     = $dept_id;
                    $oper_add->create();

                    if ($this->CheckIfExist($check_arr))
                    {
                        $result['res_status']   = 'success';
                        $result['res_message']  = "Успех! Запись добавлена!";

                    } else
                    {
                        $result['res_status']   = 'fail';
                        $result['res_message']  = "Ошибка! Запись не добавлена!";
                    }

                } else
                {
                    $result['res_status']    = 'fail';
                    $result['res_message']   = "Ошибка! Отдел не найден!";
                }
            }

        } else
        {
            $result['res_status']    = 'fail';
            $result['res_message']   = "Ошибка! Одно из полей пустое!";
        }

        return $result;

    } //End addEmployee function





    public function editEmployee($to_edit)
    {
        extract($to_edit);
        extract($this->getDefaultVars());

        if ($surname    != ''  &&
            $name       != ''  &&
            $patronymic != ''  &&
            $position   != ''  &&
            $dept_id    != '')
        {
            $surname    = htmlentities($surname,    ENT_QUOTES, "UTF-8");
            $name       = htmlentities($name,       ENT_QUOTES, "UTF-8");
            $patronymic = htmlentities($patronymic, ENT_QUOTES, "UTF-8");
            $position   = htmlentities($position,   ENT_QUOTES, "UTF-8");
            $short = $surname." ".
                mb_strtoupper(mb_substr($name, 0, 1)).".".
                mb_strtoupper(mb_substr($patronymic, 0, 1)).".";

            $result = array(
                'id'            => $id,
                'surname'       => $surname,
                'name'          => $name,
                'patronymic'    => $patronymic,
                'position'      => $position,
                'dept_id'       => $dept_id,
            );

            $check_arr = array(
                'id'            => $id,
                'surname'       => $surname,
                'name'          => $name,
                'patronymic'    => $patronymic,
            );

            if ($this->CheckIfExist($check_arr))
            {
                $result['res_status']    = 'fail';
                $result['res_message']   = "Ошибка! Такая запись уже существует!";

            } else
            {
                $check_dept_id = ORM::factory('Department')
                    ->where('dept_id', '=', $dept_id)
                    ->find();

                if ($check_dept_id->loaded())
                {
                    $oper_edit = ORM::factory('Employee', $id);
                    $oper_edit->surname     = $surname;
                    $oper_edit->name        = $name;
                    $oper_edit->patronymic  = $patronymic;
                    $oper_edit->short       = $short;
                    $oper_edit->position    = $position;
                    $oper_edit->dept_id     = $dept_id;
                    $oper_edit->update();
                    $result['res_status']    = 'success';

                } else
                {
                    $result['res_status']  = 'fail';
                    $result['res_message'] = "Ошибка! Отдел не найден!";
                }
            }

        } else
        {
            $result['res_status']    = 'fail';
            $result['res_message']   = "Ошибка! Пустая строка!";
        }

        if (isset($result)) return $result;
    } // End editEmployee function

} // End Employee Model