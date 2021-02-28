<?php extract($def_vars); ?>
<h1><?= $title ?><?= isset($dept_name) ? ' '.$dept_name : '' ?></h1>
<?php
if ($current_table)
{
    foreach ($current_table as $row)
    {
?>
        <div class="wp_block">
            <div class="block_above_and_under_equipment_table"></div>
            <table class="wp_table">
                <tr>
                    <th>
                        <div class="list_num_background">
                            <div class="list_num"><?= $list_num ?></div>
                        </div>
                    </th>
                    <th><?= $row->wp_name ?></th>
                    <th><?= $row->employee->short ?></th>
                    <th><?= $row->employee->position ?></th>
                    <th><?= $row->department->dept_name ?></th>
                    <th><?= $row->location->location_name ?></th>
                    <th><?= $row->status->status_name ?></th>
                </tr>
                <tr>
                    <th colspan="8" align="left">Оборудование:</th>
                </tr>
            </table>
            <table class="wp_table equipment_table">
                <tr>
                    <th>Тип устройства</th>
                    <th>Вендор</th>
                    <th>Модель</th>
                    <th>Основное средство</th>
                    <th>Инв.номер</th>
                </tr>
                    <?php

                // Sysunits -------------------------------
                    $sysunits = ORM::factory('Sysunit')->where('wp_id', '=', $row->wp_id)->find_all();
                    if ($sysunits->count())
                    {
                        foreach ($sysunits as $sysunit)
                        {
                            echo    
                                '<tr>
                                    <td>' . $sysunit->devtype->devtype_name.'</td>
                                    <td>' . $sysunit->vendor->vendor_name . '</td>
                                    <td>' . $sysunit->model . '</td>
                                    <td>' . $sysunit->fa . '</td>
                                    <td>' . $sysunit->inv_num . '</td>
                                </tr>';
                        }
                    } else
                    {
                        echo
                            '<tr>
                                <td style="color:red;">Системный блок отсутствует!</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>';
                    }
                    // ----------------------------------------


                    // Monitors -------------------------------
                    $monitors = ORM::factory('Monitor')->where('wp_id', '=', $row->wp_id)->find_all();
                    if ($monitors->count())
                    {
                        foreach ($monitors as $monitor)
                        {
                            echo
                                '<tr>
                                    <td>'.$monitor->devtype->devtype_name.'</td>
                                    <td>'.$monitor->vendor->vendor_name.'</td>
                                    <td>'.$monitor->model.'</td>
                                    <td>'.$monitor->fa.'</td>
                                    <td>'.$monitor->inv_num.'</td>
                                </tr>';
                        }
                    } else
                    {
                        echo
                            '<tr>
                                <td style="color:red;">Монитор отсутствует!</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>';
                    }
                    // ---------------------------------------------


                    // Offequipments -------------------------------
                    $offequipments = ORM::factory('Offequipment')->where('wp_id', '=', $row->wp_id)->find_all();
                    if ($offequipments->count())
                    {
                        foreach ($offequipments as $offequipment)
                        {
                            echo
                                '<tr>
                                    <td>'.$offequipment->devtype->devtype_name.'</td>
                                    <td>'.$offequipment->vendor->vendor_name.'</td>
                                    <td>'.$offequipment->model.'</td>
                                    <td>'.$offequipment->fa.'</td>
                                    <td>'.$offequipment->inv_num.'</td>
                                </tr>';
                        }
                    } else
                    {
                        echo
                            '<tr>
                                <td style="color:red;">Оргтехника отсутствует!</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>';
                    }
                    // ----------------------------------------


                    // Upses ----------------------------------
                    $upses = ORM::factory('Ups')->where('wp_id', '=', $row->wp_id)->find_all();
                    if ($upses->count())
                    {
                        foreach ($upses as $ups)
                        {
                            echo
                                '<tr>
                                    <td>'.$ups->devtype->devtype_name.'</td>
                                    <td>'.$ups->vendor->vendor_name.'</td>
                                    <td>'.$ups->model.'</td>
                                    <td>'.$ups->fa.'</td>
                                    <td>'.$ups->inv_num.'</td>
                                </tr>';
                        }
                    } else
                    {
                        echo
                            '<tr>
                                <td style="color:red;">ИБП отсутствует!</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>';
                    }
                    ?>
                </tr>
            </table>
            <div class="block_above_and_under_equipment_table"></div>
            <div class="links_under_workplace">
                <a class="links_under_form"
                    href="/workplaces/full_map/<?= $row->wp_id ?>">Полная карта рабочего места</a>
                <a class="links_under_form"
                    href="/workplaces/wp_of_any_dept/<?= $row->dept_id ?>">Все рабочие места отдела</a>
            </div>
        </div>

    <?php
        $list_num++;
    }
} else {
    ?>
    <p style="color: red; text-align: center;">Нет рабочих мест!</p>
<?php
}
?>