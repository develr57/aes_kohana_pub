<?php
extract($def_vars);
if (isset($result)) extract($result);
?>

<div class="block_with_links_under_form">
    <a class="links_under_form" href="/">На главную</a>
    <a class="links_under_form" href="/sysunits">К таблице Сист.блоков</a>
</div>
<hr>

<h2><?= $title ?></h2>
<h3 class="config_h3">Это рабочее место:</h3>
<div class="config_editable-line-table-block">
    <div class="config_properties-block">
        <table class="config_properties-table">
            <tr>
                <th>ID</th>
                <th><?php echo isset($field_wp_name)    ? $field_wp_name    : ''; ?></th>
                <th><?php echo isset($field_employee)   ? $field_employee   : ''; ?></th>
                <th><?php echo isset($field_department) ? $field_department : ''; ?></th>
                <th><?php echo isset($field_location)   ? $field_location   : ''; ?></th>
                <th><?php echo isset($field_status)     ? $field_status     : ''; ?></th>
                <th><?php echo isset($field_note)       ? $field_note       : ''; ?></th>
            </tr>
            <tr>
                <?= '<td>' . $workplace->$id_column . '</td>' ?>
                <?= '<td>' . $workplace->wp_name . '</td>' ?>
                <?= '<td>' . $workplace->employee->short . '</td>' ?>
                <?= '<td>' . $workplace->department->dept_name . '</td>' ?>
                <?= '<td>' . $workplace->location->location_name . '</td>' ?>
                <?= '<td>' . $workplace->status->status_name . '</td>' ?>
                <?= '<td>' . $workplace->note . '</td>' ?>
            </tr>
        </table>
    </div>
</div>


<h3 class="config_h3">Оборудование:</h3>


<div class="config_units-block">


    <div class="config_one-unit-block"> <!-- Сист.блоки -->
        <div class="config_title-block">
            <div class="config_title">Системные блоки</div>
        </div>
        <?php
        $num = 0;
        if ($sysunits->count() == 0)
        {
            $su_error   = "Отсутствует!";
        
        } else
        {
            foreach ($sysunits as $sysunit)
            {
        ?>
        <div class="config_properties-block">
            <table class="config_title-table">
                <tr>
                    <td><?= $num ?>)</td>
                    <td>ID: <?= $sysunit->su_id ?></td>
                    <td><?= $sysunit->vendor->vendor_name.' '.$sysunit->model ?></td>
                    <td>
                        <a class="config_button-under-units"
                        href="/sysunits/choice/<?= $wp_id ?>/install">Установить</a>
                    </td>
                    <td>
                        <a class="config_button-under-units"
                        href="/sysunits/choice/<?= $wp_id ?>/replace/<?= $sysunit->su_id ?>/sysunit">Заменить</a>
                    </td>
                    <td>
                        <a class="config_button-under-units"
                        href="/workplaces/operations/<?= $wp_id ?>/deinstall/<?= $sysunit->su_id ?>/sysunit">Снять</a>
                    </td>
                    <td>
                        <a class="config_button-under-units"
                        href="/sysunits/configuration/<?= $sysunit->su_id ?>">Конфигурация</a>
                    </td>
                </tr>
            </table>
            <table class="config_properties-table">
                <tr>
                    <th>Рабочее место</th>
                    <th>Основное средство</th>
                    <th>Инв.номер</th>
                    <th>Инв.статус</th>
                    <th>Дата ввода</th>
                    <th>Локация</th>
                    <th>Статус</th>
                    <th>Заметка</th>
                </tr>
                <tr>
                    <td><?= $sysunit->workplace->wp_name        ?></td>
                    <td><?= $sysunit->fa                        ?></td>
                    <td><?= $sysunit->inv_num                   ?></td>
                    <td><?= $sysunit->inv_status == 'G' ? 'Числится'    : 'Не числится' ?></td>
                    <td><?= is_null($sysunit->com_date) ? ''            : date("d.m.Y", $sysunit->com_date) ?></td>
                    <td><?= $sysunit->location->location_name   ?></td>
                    <td><?= $sysunit->status->status_name       ?></td>
                    <td><?= $sysunit->note                      ?></td>
                </tr>
            </table>
            <div class="config_units-properties-block">
                <div class="config_one-units-pair-block">
                    <div class="config_units-properties-table-block">
                        <table class="config_one-units-table">

                            <!-- Motherboard -->
                            <?php
                            $motherboard = ORM::factory('Motherboard')->where('su_id', '=', $sysunit->su_id)->find();
                            ?>
                            <tr>
                                <td>Мат.плата</td>
                                <td class="<?= $motherboard->loaded() ? '' : 'fail' ?>">
                                    <?= $motherboard->loaded() ? 'ID: '.$motherboard->mb_id.' / '.$motherboard->vendor->vendor_name.' '.
                                    $motherboard->model.' / '.$motherboard->socket->socket : 'Отсутствует!'?>
                                </td>
                            </tr>
                            <!-- -------------------------------------- -->


                            <!-- Cpus -->
                            <?php
                            $cpus = ORM::factory('Cpu')->where('su_id', '=', $sysunit->su_id)->find_all();
                            $cpu_title = 1;
                            if ($cpus->count() > 0)
                            {
                                foreach ($cpus as $cpu)
                                {
                                    echo '<tr>';
                                    if ($cpu_title > 0) echo '<td rowspan="'.$cpus->count().'">ЦПУ</td>';
                                    echo '<td>'.
                                        'ID: '.$cpu->cpu_id.' / '.$cpu->vendor->vendor_name.' '.$cpu->model.' / '.
                                        $cpu->clock_speed.'GHz / '.$cpu->socket->socket.
                                        '</td>
                                        </tr>';
                                    $cpu_title--;
                                }

                            } else
                            {
                            ?>
                            <tr>
                                <td>ЦПУ</td>
                                <td class="fail">Отсутствует!</td>
                            </tr>
                            <!-- -------------------------------------- -->


                            <!-- Rams -->
                            <?php
                            }
                            $rams = ORM::factory('Ram')->where('su_id', '=', $sysunit->su_id)->find_all();
                            $ram_title = 1;
                            if ($rams->count() > 0)
                            {
                                foreach ($rams as $ram)
                                {
                                    echo '<tr>';
                                    if ($ram_title > 0) echo '<td rowspan="'.$rams->count().'">ОЗУ</td>';
                                    echo '<td>ID: '.$ram->ram_id.' / '.$ram->vendor->vendor_name.' '.$ram->model.' / ';
                                    if ($ram->size < 1024)
                                    {
                                        echo $ram->size.'MB / ';
                                    
                                    } elseif ($ram->size >= 1024)
                                    {
                                        $ramGB = $ram->size/1024;
                                        echo $ramGB.'GB / ';
                                    }
                                    echo $ram->ramtype->ramtype_name.' / '.$ram->speed.'MHz / '.$ram->formfactor;
                                    echo '</td>
                                         </tr>';
                                    $ram_title--;
                                }

                            } else
                            {
                            ?>
                            <tr>
                                <td>ОЗУ</td>
                                <td class="fail">Отсутствует!</td>
                            </tr>
                            <?php
                            }
                            ?>
                            <!-- -------------------------------------- -->

                        </table>
                    </div>
                </div>
                <div class="config_one-units-pair-block">
                    <div class="config_units-properties-table-block">
                        <table class="config_one-units-table">

                            <!-- Videocards -->
                            <?php
                            $videocards = ORM::factory('Videocard')->where('su_id', '=', $sysunit->su_id)->find_all();
                            $vc_title = 1;
                            if ($videocards->count() > 0)
                            {
                                foreach ($videocards as $videocard)
                                {
                                    echo "<tr>";
                                    if ($vc_title > 0) echo '<td rowspan=".$videocards->count().">Видеокарты</td>';
                                    echo "<td> ID: ".$videocard->vc_id." / ".$videocard->vendor->vendor_name." ";
                                    if ($videocard->gpu_vendor == "N")
                                    {
                                        echo "NVIDIA ";
                                    
                                    } elseif ($videocard->gpu_vendor == "A")
                                    {
                                        echo "AMD ";
                                    }
                                    echo $videocard->model." / ";
                                    if ($videocard->mem_capacity < 1024)
                                    {
                                        echo $videocard->mem_capacity."MB ";
                                    } elseif ($videocard->mem_capacity >= 1024) {
                                        $vc_capacity = $videocard->mem_capacity/1024;
                                        echo $vc_capacity."GB ";
                                    }
                                    echo "</td>
                                          </tr>";
                                    $vc_title--;
                                }

                            } else
                            {
                            ?>
                            <tr>
                                <td>Видеокарта</td>
                                <td class="fail">Отсутствует!</td>
                            </tr>
                            <?php
                            }
                            ?>
                            <!-- -------------------------------------- -->


                            <!-- Storages -->
                            <?php
                            $storages = ORM::factory('Storage')->where('su_id', '=', $sysunit->su_id)->find_all();
                            $storage_title = 1;
                            if ($storages->count() > 0)
                            {
                                foreach ($storages as $storage)
                                {
                                    echo "<tr>";
                                    if ($storage_title > 0) echo '<td rowspan="'.$storages->count().'">Накопители</td>';
                                    echo "<td>ID: ".$storage->storage_id." / ".$storage->vendor->vendor_name." ".
                                        $storage->model." / ";
                                    if ($storage->capacity < 1024)
                                    {
                                        echo $storage->capacity."GB / ";
                                    
                                    } elseif ($storage->capacity >= 1024)
                                    {
                                        echo $storage->capacity/1024 ."TB / ";
                                    }
                                    echo $storage->interface." / ".$storage->formfactor;
                                    echo "</td>
                                          </tr>";
                                    $storage_title--;
                                }

                            } else {
                            ?>
                            <tr>
                                <td>Накопители</td>
                                <td class="fail">Отсутствует!</td>
                            </tr>
                            <?php
                            }
                            ?>
                            <!-- -------------------------------------- -->


                            <!-- Pwrsupply -->
                            <?php
                            $pwrsupply = ORM::factory('Pwrsupply')->where('su_id', '=', $sysunit->su_id)->find();
                            ?>
                            <tr>
                                <td>Блок питания</td>
                                <td class="<?= $pwrsupply->loaded() ? '' : 'fail' ?>">
                                <?= $pwrsupply->loaded() ? "ID: ".$pwrsupply->ps_id." / ".$pwrsupply->vendor->vendor_name." ".
                                    $pwrsupply->model." / ".$pwrsupply->power."W" : 'Отсутствует!'
                                ?>
                                </td>
                            </tr>
                            <!-- -------------------------------------- -->

                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php
                $num++;
            }
        }
        if (isset($su_error))
        {
        ?>
        <div class="config_properties-block">
            <table class="config_title-table">
                <tr>
                    <td><?= $num ?>)</td>
                    <td>ID: n/a</td>
                    <td class="fail"><?= $su_error ?></td>
                    <td>
                        <a class="config_button-under-units"
                        href="/sysunits/choice/<?= $wp_id ?>/install/">Установить</a>
                    </td>
                    <td>
                        <a class="config_button-under-units
                        <?= isset($su_error) ? ' config_link-deactivate' : '' ?>"
                        href="/sysunits/choice/<?= $wp_id ?>/replace/<?= isset($sysunit) ? $sysunit->su_id : '' ?>/sysunit">Заменить</a>
                    </td>
                    <td>
                        <a class="config_button-under-units
                        <?= isset($su_error) ? ' config_link-deactivate' : '' ?>"
                        href="/workplaces/operations/<?= $wp_id ?>/deinstall/<?= isset($sysunit) ? $sysunit->su_id : '' ?>/sysunit">Снять</a>
                    </td>
                </tr>
            </table>
            <table class="config_properties-table">
                <tr>
                    <th>Рабочее место</th>
                    <th>Основное средство</th>
                    <th>Инв.номер</th>
                    <th>Инв.статус</th>
                    <th>Дата ввода</th>
                    <th>Локация</th>
                    <th>Статус</th>
                    <th>Заметка</th>
                </tr>
            </table>
            <div class="config_units-properties-block">
                <div class="config_one-units-pair-block">
                    <div class="config_units-properties-table-block">
                        <table class="config_one-units-table">
                            <tr>
                                <td>Мат.плата</td>
                                <td class="fail">Отсутствует!</td>
                            </tr>
                                <td>ЦПУ</td>
                                <td class="fail">Отсутствует!</td>
                            </tr>
                                <td>ОЗУ</td>
                                <td class="fail">Отсутствует!</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="config_one-units-pair-block">
                    <div class="config_units-properties-table-block">
                        <table class="config_one-units-table">
                            <tr>
                                <td>Видеокарта</td>
                                <td class="fail">Отсутствует!</td>
                            </tr>
                            <tr>
                                <td>Накопители</td>
                                <td class="fail">Отсутствует!</td>
                            </tr>
                            <tr>
                                <td>Блок питания</td>
                                <td class="fail">Отсутствует!</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
    </div>



    <div class="config_one-unit-block"> <!-- Мониторы -->
        <div class="config_title-block">
            <div class="config_title">Мониторы</div>
        </div>
        <?php
        $num = 0;
        if ($monitors->count() == 0)
        {
            $mon_error   = "Отсутствует!";
        
        } else
        {
            foreach ($monitors as $monitor)
            {
        ?>
        <div class="config_properties-block">
            <table class="config_title-table">
                <tr>
                    <td><?= $num ?>)</td>
                    <td>ID: <?= $monitor->mon_id ?></td>
                    <td><?= $monitor->vendor->vendor_name.' '.$monitor->model ?>
                    </td>
                    <td>
                        <a class="config_button-under-units"
                        href="/monitors/choice/<?= $wp_id ?>/install">Установить</a>
                    </td>
                    <td>
                        <a class="config_button-under-units
                        <?= isset($mon_error) ? ' config_link-deactivate' : '' ?>"
                        href="/monitors/choice/<?= $wp_id ?>/replace/<?= $monitor->mon_id ?>/monitor">Заменить</a>
                    </td>
                    <td>
                        <a class="config_button-under-units
                        <?= isset($mon_error) ? ' config_link-deactivate' : '' ?>"
                        href="/workplaces/operations/<?= $wp_id ?>/deinstall/<?= $monitor->mon_id ?>/monitor">Снять</a>
                    </td>
                </tr>
            </table>
            <table class="config_properties-table">
                <tr>
                    <th>Диагональ</th>
                    <th>Рабочее место</th>
                    <th>Основное средство</th>
                    <th>Инв.номер</th>
                    <th>Инв.статус</th>
                    <th>Дата ввода</th>
                    <th>Локация</th>
                    <th>Статус</th>
                    <th>Заметка</th>
                </tr>
                <tr>
                    <td><?= $monitor->diagonal                  ?></td>
                    <td><?= $monitor->workplace->wp_name        ?></td>
                    <td><?= $monitor->fa                        ?></td>
                    <td><?= $monitor->inv_num                   ?></td>
                    <td><?= $monitor->inv_status == 'G' ? 'Числится'    : 'Не числится' ?></td>
                    <td><?= is_null($monitor->com_date) ? ''            : date("d.m.Y", $monitor->com_date) ?></td>
                    <td><?= $monitor->location->location_name   ?></td>
                    <td><?= $monitor->status->status_name       ?></td>
                    <td><?= $monitor->note                      ?></td>
                </tr>
            </table>
        </div>
        <?php
                $num++;
            }
        }
        if (isset($mon_error))
        {
        ?>
        <div class="config_properties-block">
            <table class="config_title-table">
                <tr>
                    <td><?= $num ?>)</td>
                    <td>ID: n/a</td>
                    <td class="fail"><?= $mon_error ?></td>
                    <td>
                        <a class="config_button-under-units"
                        href="/monitors/choice/<?= $wp_id ?>/install/">Установить</a>
                    </td>
                    <td>
                        <a class="config_button-under-units
                        <?= isset($mon_error) ? ' config_link-deactivate' : '' ?>"
                        href="/monitors/choice/<?= $wp_id ?>/replace/<?= isset($monitor) ? $monitor->mon_id : '' ?>/monitor">Заменить</a>
                    </td>
                    <td>
                        <a class="config_button-under-units
                        <?= isset($mon_error) ? ' config_link-deactivate' : '' ?>"
                        href="/workplaces/operations/<?= $wp_id ?>/deinstall/<?= isset($monitor) ? $monitor->mon_id : '' ?>/monitor">Снять</a>
                    </td>
                </tr>
            </table>
            <table class="config_properties-table">
                <tr>
                    <th>Диагональ</th>
                    <th>Рабочее место</th>
                    <th>Основное средство</th>
                    <th>Инв.номер</th>
                    <th>Инв.статус</th>
                    <th>Дата ввода</th>
                    <th>Локация</th>
                    <th>Статус</th>
                    <th>Заметка</th>
                </tr>
            </table>
        </div>
        <?php
        }
        ?>
    </div>



    <div class="config_one-unit-block"> <!-- ИБП -->
        <div class="config_title-block">
            <div class="config_title">ИБП</div>
        </div>
        <?php
        $num = 0;
        if ($upses->count() == 0)
        {
            $ups_error   = "Отсутствует!";
        
        } else
        {
            foreach ($upses as $ups)
            {
        ?>
        <div class="config_properties-block">
            <table class="config_title-table">
                <tr>
                    <td><?= $num ?>)</td>
                    <td>ID: <?= $ups->ups_id ?></td>
                    <td><?= $ups->vendor->vendor_name.' '.$ups->model ?>
                    </td>
                    <td>
                        <a class="config_button-under-units"
                        href="/upses/choice/<?= $wp_id ?>/install">Установить</a>
                    </td>
                    <td>
                        <a class="config_button-under-units"
                        href="/upses/choice/<?= $wp_id ?>/replace/<?= $ups->ups_id ?>/ups">Заменить</a>
                    </td>
                    <td>
                        <a class="config_button-under-units"
                        href="/workplaces/operations/<?= $wp_id ?>/deinstall/<?= $ups->ups_id ?>/ups">Снять</a>
                    </td>
                </tr>
            </table>
            <table class="config_properties-table">
                <tr>
                    <th>АКБ</th>
                    <th>Кол-во АКБ</th>
                    <th>Рабочее место</th>
                    <th>Основное средство</th>
                    <th>Инв.номер</th>
                    <th>Инв.статус</th>
                    <th>Дата ввода</th>
                    <th>Локация</th>
                    <th>Статус</th>
                    <th>Заметка</th>
                </tr>
                <tr>
                    <td><?= $ups->battery->bat_voltage.'V-'.$ups->battery->bat_capacity.'A/h' ?></td>
                    <td><?= $ups->bat_count                 ?></td>
                    <td><?= $ups->workplace->wp_name        ?></td>
                    <td><?= $ups->fa                        ?></td>
                    <td><?= $ups->inv_num                   ?></td>
                    <td><?= $ups->inv_status == 'G' ? 'Числится'    : 'Не числится' ?></td>
                    <td><?= is_null($ups->com_date) ? ''            : date("d.m.Y", $ups->com_date) ?></td>
                    <td><?= $ups->location->location_name   ?></td>
                    <td><?= $ups->status->status_name       ?></td>
                    <td><?= $ups->note                      ?></td>
                </tr>
            </table>
        </div>
        <?php
                $num++;
            }
        }
        if (isset($ups_error))
        {
        ?>
        <div class="config_properties-block">
            <table class="config_title-table">
                <tr>
                    <td><?= $num ?>)</td>
                    <td>ID: n/a</td>
                    <td class="fail"><?= $ups_error ?></td>
                    <td>
                        <a class="config_button-under-units"
                        href="/upses/choice/<?= $wp_id ?>/install/">Установить</a>
                    </td>
                    <td>
                        <a class="config_button-under-units
                        <?= isset($ups_error) ? ' config_link-deactivate' : '' ?>"
                        href="/upses/choice/<?= $wp_id ?>/replace/<?= isset($ups) ? $ups->ups_id : '' ?>/ups">Заменить</a>
                    </td>
                    <td>
                        <a class="config_button-under-units
                        <?= isset($ups_error) ? ' config_link-deactivate' : '' ?>"
                        href="/workplaces/operations/<?= $wp_id ?>/deinstall/<?= isset($ups) ? $ups->ups_id : '' ?>/ups">Снять</a>
                    </td>
                </tr>
            </table>
            <table class="config_properties-table">
                <tr>
                    <th>АКБ</th>
                    <th>Кол-во АКБ</th>
                    <th>Рабочее место</th>
                    <th>Основное средство</th>
                    <th>Инв.номер</th>
                    <th>Инв.статус</th>
                    <th>Дата ввода</th>
                    <th>Локация</th>
                    <th>Статус</th>
                    <th>Заметка</th>
                </tr>
            </table>
        </div>
        <?php
        }
        ?>
    </div>



    <div class="config_one-unit-block"> <!-- Оргтехника -->
        <div class="config_title-block">
            <div class="config_title">Оргтехника</div>
        </div>
        <?php
        $num = 0;
        if ($offequipments->count() == 0)
        {
            $oe_error   = "Отсутствует!";
        
        } else
        {
            foreach ($offequipments as $offequipment)
            {
        ?>
        <div class="config_properties-block">
            <table class="config_title-table">
                <tr>
                    <td><?= $num ?>)</td>
                    <td>ID: <?= $offequipment->oe_id ?></td>
                    <td><?= $offequipment->vendor->vendor_name.' '.$offequipment->model ?>
                    </td>
                    <td>
                        <a class="config_button-under-units"
                        href="/offequipments/choice/<?= $wp_id ?>/install">Установить</a>
                    </td>
                    <td>
                        <a class="config_button-under-units"
                        href="/offequipments/choice/<?= $wp_id ?>/replace/<?= $offequipment->oe_id ?>/offequipment">Заменить</a>
                    </td>
                    <td>
                        <a class="config_button-under-units"
                        href="/workplaces/operations/<?= $wp_id ?>/deinstall/<?= $offequipment->oe_id ?>/offequipment">Снять</a>
                    </td>
                </tr>
            </table>
            <table class="config_properties-table">
                <tr>
                    <th>Формат</th>
                    <th>Технология печати</th>
                    <th>Цветная печать</th>
                    <th>Рабочее место</th>
                    <th>Основное средство</th>
                    <th>Инв.номер</th>
                    <th>Инв.статус</th>
                    <th>Дата ввода</th>
                    <th>Локация</th>
                    <th>Статус</th>
                    <th>Заметка</th>
                </tr>
                <tr>
                    <td><?= $offequipment->format                    ?></td>
                    <td>
                        <?php
                        switch ($offequipment->print_tech)
                        {
                            case 'I':
                                echo "Чернильная";
                                break;
                            case 'L':
                                echo "Лазерная";
                                break;
                            case 'M':
                                echo "Матричная";
                                break;
                        }
                        ?>
                    </td>
                    <td><?= $offequipment->print_color == 'C' ? 'Есть' : 'Нет' ?></td>
                    <td><?= $offequipment->workplace->wp_name        ?></td>
                    <td><?= $offequipment->fa                        ?></td>
                    <td><?= $offequipment->inv_num                   ?></td>
                    <td><?= $offequipment->inv_status == 'G' ? 'Числится'    : 'Не числится' ?></td>
                    <td><?= is_null($offequipment->com_date) ? ''            : date("d.m.Y", $offequipment->com_date) ?></td>
                    <td><?= $offequipment->location->location_name   ?></td>
                    <td><?= $offequipment->status->status_name       ?></td>
                    <td><?= $offequipment->note                      ?></td>
                </tr>
            </table>
        </div>
        <?php
                $num++;
            }
        }
        if (isset($oe_error))
        {
        ?>
        <div class="config_properties-block">
            <table class="config_title-table">
                <tr>
                    <td><?= $num ?>)</td>
                    <td>ID: n/a</td>
                    <td class="fail"><?= $oe_error ?></td>
                    <td>
                        <a class="config_button-under-units"
                        href="/offequipments/choice/<?= $wp_id ?>/install/">Установить</a>
                    </td>
                    <td>
                        <a class="config_button-under-units
                        <?= isset($oe_error) ? ' config_link-deactivate' : '' ?>"
                        href="/offequipments/choice/<?= $wp_id ?>/replace/<?= isset($offequipment) ? $offequipment->oe_id : '' ?>/offequipment">Заменить</a>
                    </td>
                    <td>
                        <a class="config_button-under-units
                        <?= isset($oe_error) ? ' config_link-deactivate' : '' ?>"
                        href="/workplaces/operations/<?= $wp_id ?>/deinstall/<?= isset($offequipment) ? $offequipment->oe_id : '' ?>/offequipment">Снять</a>
                    </td>
                </tr>
            </table>
            <table class="config_properties-table">
                <tr>
                    <th>Формат</th>
                    <th>Технология печати</th>
                    <th>Цветная печать</th>
                    <th>Основное средство</th>
                    <th>Инв.номер</th>
                    <th>Инв.статус</th>
                    <th>Дата ввода</th>
                    <th>Локация</th>
                    <th>Статус</th>
                    <th>Заметка</th>
                </tr>
            </table>
        </div>
        <?php
        }
        ?>
    </div>



</div>