<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Devtype extends ORM {

    protected $_table_name = 'devtypes';
    protected $_primary_key = 'devtype_id';

    protected $_belongs_to = array(
        'devgroup' => array(
            'model'       => 'Devgroup',
            'foreign_key' => 'devgroup_id',
        ),
    );

    protected $_has_many = array(

        'sysunits'      => array(
            'model'         => 'Sysunit',
            'foreign_key'   => 'devtype_id',
        ),
        
        'monitors'      => array(
            'model'         => 'Monitor',
            'foreign_key'   => 'devtype_id',
        ),

        'upses'         => array(
            'model'         => 'Ups',
            'foreign_key'   => 'devtype_id',
        ),

        'Offequipments' => array(
            'model'         => 'Offequipment',
            'foreign_key'   => 'devtype_id',
        ),

        'cpus'          => array(
            'model'         => 'Cpu',
            'foreign_key'   => 'devtype_id',
        ),

        'motherboards'  => array(
            'model'         => 'Motherboard',
            'foreign_key'   => 'devtype_id',
        ),

        'rams'          => array(
            'model'         => 'Ram',
            'foreign_key'   => 'devtype_id',
        ),

        'videocards'    => array(
            'model'         => 'Videocard',
            'foreign_key'   => 'devtype_id',
        ),

        'storages'      => array(
            'model'         => 'Storage',
            'foreign_key'   => 'devtype_id',
        ),

        'pwrsupplies'   => array(
            'model'         => 'Pwrsupply',
            'foreign_key'   => 'devtype_id',
        ),

    );



    public $table_name    = 'devtypes';
    public $id_column     = 'devtype_id';
    public $field_devg    = 'Группа устройств';
    public $field_devt    = 'Тип устройств';

    public function getDefaultVars()
    {
        return array(
            'table_name'        => $this->table_name,
            'id_column'         => $this->id_column,
            'field_devg'        => $this->field_devg,
            'field_devt'        => $this->field_devt,
        );
    }


    public function CheckIfExist($text_value)
    {
        $query = ORM::factory('Devtype')
            ->where('devtype_name', '=', $text_value)
            ->find();
        if($query->loaded())
        {
            return TRUE;

        } else
        {
            return FALSE;
        }
    }





    public function addDevtype($to_add)
    {
        extract($to_add);

        if ($devtype_name != ''  &&  $devgroup_id != '')
        {
            $devtype_name = htmlentities($devtype_name, ENT_QUOTES, "UTF-8");

            $result = array(
                'devgroup_id'  => $devgroup_id,
                'devtype_name' => $devtype_name,
            );
            
            if ($this->CheckIfExist($devtype_name))
            {
                $result['res_status']   = 'fail';
                $result['res_message']  = 'Ошибка! Такая запись уже существует!';

            } else
            {
                $check_devgroup_id = ORM::factory('Devgroup')
                    ->where('devgroup_id', '=', $devgroup_id)
                    ->find();

                if ($check_devgroup_id->loaded())
                {
                    $oper_add = ORM::factory('Devtype');
                    $oper_add->devgroup_id   = $devgroup_id;
                    $oper_add->devtype_name  = $devtype_name;
                    $oper_add->create();

                    if ($this->CheckIfExist($devtype_name))
                    {
                        $result = array(
                            'res_status'   => 'success',
                            'res_message'  => "Успех! Запись добавлена!",
                        );

                    } else
                    {
                        $result['res_status']   = 'fail';
                        $result['res_message']  = "Ошибка! Запись не добавлена!";
                    }

                } else
                {
                    $result['res_status']   = 'fail';
                    $result['res_message']  = "Ошибка! тип устройств не найден!";
                }
            }

        } else
        {
            $result['res_status']   = 'fail';
            $result['res_message']  = "Ошибка! Пустая строка!";
        }

        return $result;

    } //End addDevtype function





    public function editDevtype($to_edit)
    {
        $id             = $to_edit['id'];
        $devgroup_id    = $to_edit['devgroup_id'];
        $devtype_name   = $to_edit['devtype_name'];

        if ($devtype_name != ''  &&  $devgroup_id != '')
        {
            $devtype_name = htmlentities($devtype_name, ENT_QUOTES, "UTF-8");

            $result = array(
                'id'           => $id,
                'devgroup_id'  => $devgroup_id,
                'devtype_name' => $devtype_name,
            );

            if ($this->CheckIfExist($devtype_name))
            {
                $result['res_status']   = 'fail';
                $result['res_message']  = "Ошибка! Такая запись уже существует!";

            } else
            {
                $check_devgroup_id = ORM::factory('Devgroup')
                    ->where('devgroup_id', '=', $devgroup_id)
                    ->find();

                if ($check_devgroup_id->loaded())
                {
                    $oper_edit = ORM::factory('Devtype', $id);
                    $oper_edit->devgroup_id  = $devgroup_id;
                    $oper_edit->devtype_name = $devtype_name;
                    $oper_edit->update();
                    $result['res_status']    = 'success';

                } else
                {
                    $result['res_status']  = 'fail';
                    $result['res_message'] = "Ошибка! Группа устройств не найдена!";
                }
            }

        } else
        {
            $result['res_status']   = 'fail';
            $result['res_message']  = "Ошибка! Пустая строка!";
        }

        if (isset($result)) return $result;
    } // End editDevtype function

} // End Devtype Model