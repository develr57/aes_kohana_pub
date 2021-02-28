<?php
extract($def_vars);
if (isset($result)) extract($result);
?>

<div class="block_with_links_under_form">
    <a class="links_under_form" href="/">На главную</a>
    <a class="links_under_form"
    href="/workplaces/full_map/<?= $current_sysunit->wp_id ?>">К полной карте рабочего места</a>
    <a class="links_under_form" href="/sysunits">К таблице Сист.блоков</a>
</div>
<hr>

<h2><?= $title ?></h2>
<h3 class="config_h3">Этот системный блок:</h3>
<div class="config_editable-line-table-block">
    <div class="config_properties-block">
        <table class="config_properties-table">
            <tr>
                <th>ID</th>
                <th><?php echo isset($field_devtype)    ? $field_devtype    : ''; ?></th>
                <th><?php echo isset($field_vendor)     ? $field_vendor     : ''; ?></th>
                <th><?php echo isset($field_model)      ? $field_model      : ''; ?></th>
                <th><?php echo isset($field_location)   ? $field_location   : ''; ?></th>
                <th><?php echo isset($field_status)     ? $field_status     : ''; ?></th>
                <th><?php echo isset($field_workplace)  ? $field_workplace  : ''; ?></th>
                <th><?php echo isset($field_fa)         ? $field_fa         : ''; ?></th>
                <th><?php echo isset($field_inv_num)    ? $field_inv_num    : ''; ?></th>
                <th><?php echo isset($field_inv_status) ? $field_inv_status : ''; ?></th>
                <th><?php echo isset($field_com_date)   ? $field_com_date   : ''; ?></th>
                <th><?php echo isset($field_note)       ? $field_note       : ''; ?></th>
            </tr>
            <tr>
                <?= '<td>' . $current_sysunit->$id_column . '</td>' ?>
                <?= '<td>' . $current_sysunit->devtype->devtype_name . '</td>' ?>
                <?= '<td>' . $current_sysunit->vendor->vendor_name . '</td>' ?>
                <?= '<td>' . $current_sysunit->model . '</td>' ?>
                <?= '<td>' . $current_sysunit->location->location_name . '</td>' ?>
                <?= '<td>' . $current_sysunit->status->status_name . '</td>' ?>
                <?= '<td>' . $current_sysunit->workplace->wp_name . '</td>' ?>
                <?= '<td>' . $current_sysunit->fa . '</td>' ?>
                <?= '<td>' . $current_sysunit->inv_num . '</td>' ?>
                <?php
                echo $current_sysunit->inv_status == 'G' ?
                    '<td>Числится</td>' :
                    '<td>Не числится</td>';
                ?>
                <?php
                echo "<td>";
                if (
                    isset($res_status) && $res_status == 'fail' &&
                    isset($com_date) && is_numeric($com_date)
                )
                    echo date("d.m.Y", $com_date);
                echo "</td>";
                ?>
                <?= '<td>' . $current_sysunit->note . '</td>' ?>
            </tr>
        </table>
    </div>
</div>


<h3 class="config_h3">Комплектующие:</h3>


<div class="config_units-block">


    <div class="config_one-unit-block">
        <div class="config_title-block">
            <div class="config_title">Материнская плата</div>
        </div>
        <?php
        if ($motherboards->count() == 0)
        {
            $mb_error   = "Отсутствует!";
        
        } elseif ($motherboards->count() > 1)
        {
            $mb_error   = "Ошибка! Этому сист.блоку принадлежит больше одной мат.платы!";
        } else
        {
            foreach ($motherboards as $row)
            {
                $motherboard = $row;
            }
        }
        ?>
        <div class="config_properties-block">
            <table class="config_title-table">
                <tr>
                    <td>ID: <?= isset($motherboard) ? $motherboard->mb_id : 'n/a' ?></td>
                    <td class="<?= isset($mb_error) ? 'fail' : '' ?>"
                        ><?php
                        if (isset($motherboard))
                        {
                            echo $motherboard->vendor->vendor_name.'  '.$motherboard->model;
                        
                        } elseif (isset($mb_error))
                        {
                            echo $mb_error;
                        }
                        ?>
                    </td>
                    <td>
                        <a class="config_button-under-units
                        <?= isset($motherboard) ? ' config_link-deactivate' : '' ?>"
                        href="/motherboards/choice/<?= $id ?>/install">Установить</a>
                    </td>
                    <td><a class="config_button-under-units
                        <?= !isset($motherboard) ? ' config_link-deactivate' : '' ?>"
                        href="/motherboards/choice/<?= $id ?>/replace/<?= isset($motherboard) ? $motherboard->mb_id : '' ?>/motherboard/">Заменить</a>
                    </td>
                    <td>
                        <a class="config_button-under-units
                        <?= !isset($motherboard) ? ' config_link-deactivate' : '' ?>"
                        href="/sysunits/operations/<?= $id ?>/deinstall/<?= isset($motherboard) ? $motherboard->mb_id : '' ?>/motherboard/">Снять</a>
                    </td>
                </tr>
            </table>
            <table class="config_properties-table">
                <tr>
                    <th>Сокет</th>
                    <th>Кол-во сокетов</th>
                    <th>Тип ОЗУ</th>
                    <th>Кол-во слотов</th>
                    <th>Видеовыход</th>
                    <th>Локация</th>
                    <th>Статус</th>
                    <th>Заметка</th>
                </tr>
                <tr>
                    <td><?= isset($motherboard) ? $motherboard->socket->socket : '' ?></td>
                    <td><?= isset($motherboard) ? $motherboard->soc_count : '' ?></td>
                    <td><?= isset($motherboard) ? $motherboard->ramtype->ramtype_name : '' ?></td>
                    <td><?= isset($motherboard) ? $motherboard->slot_count : '' ?></td>
                    <td><?php
                        if (isset($motherboard)  &&  $motherboard->video_out == 'Y')
                        {
                            echo 'Есть';
                        } elseif (isset($motherboard)  &&  $motherboard->video_out == 'N')
                        {
                            echo 'Нет';
                        }
                        ?></td>
                    <td><?= isset($motherboard) ? $motherboard->location->location_name : '' ?></td>
                    <td><?= isset($motherboard) ? $motherboard->status->status_name : '' ?></td>
                    <td><?= isset($motherboard) ? $motherboard->note : '' ?></td>
                </tr>
            </table>
        </div>
    </div>



    <div class="config_one-unit-block">
        <div class="config_title-block">
            <div class="config_title">Процессоры</div>
        </div>
        <?php
        $num = 0;
        if ($cpus->count() == 0)
        {
            $cpu_error   = "Отсутствует!";
        
        } elseif (isset($motherboard) && $cpus->count() > $motherboard->soc_count)
        {
            $cpu_error   = "Ошибка! Этому сист.блоку принадлежит больше процессоров, чем сокетов на мат.плате!";
        } else
        {
            foreach ($cpus as $cpu)
            {
        ?>
        <div class="config_properties-block">
            <table class="config_title-table">
                <tr>
                    <td><?= $num ?>)</td>
                    <td>ID: <?= $cpu->cpu_id ?></td>
                    <td><?= $cpu->vendor->vendor_name.' '.$cpu->model ?>
                    </td>
                    <td>
                        <a class="config_button-under-units
                        <?= ((isset($cpu) && isset($motherboard)) && $cpus->count() >= $motherboard->soc_count) || isset($mb_error)
                        ? ' config_link-deactivate' : '' ?>"
                        href="/cpus/choice/<?= $id ?>/install">Установить</a>
                    </td>
                    <td><a class="config_button-under-units
                        <?= isset($mb_error) || isset($cpu_error)
                        ? ' config_link-deactivate' : '' ?>"
                        href="/cpus/choice/<?= $id ?>/replace/<?= isset($cpu) ? $cpu->cpu_id : '' ?>/cpu">Заменить</a>
                    </td>
                    <td>
                        <a class="config_button-under-units
                        <?= isset($mb_error) || isset($cpu_error)
                        ? ' config_link-deactivate' : '' ?>"
                        href="/sysunits/operations/<?= $id ?>/deinstall/<?= isset($cpu) ? $cpu->cpu_id : '' ?>/cpu">Снять</a>
                    </td>
                </tr>
            </table>
            <table class="config_properties-table">
                <tr>
                    <th>Частота</th>
                    <th>Ядер/Потоков</th>
                    <th>Сокет</th>
                    <th>Локация</th>
                    <th>Статус</th>
                    <th>Заметка</th>
                </tr>
                <tr>
                    <td><?= $cpu->clock_speed               ?>GHz</td>
                    <td><?= $cpu->cores_threads             ?></td>
                    <td><?= $cpu->socket->socket            ?></td>
                    <td><?= $cpu->location->location_name   ?></td>
                    <td><?= $cpu->status->status_name       ?></td>
                    <td><?= $cpu->note                      ?></td>
                </tr>
            </table>
        </div>
        <?php
                $num++;
            }
        }
        if (isset($cpu_error))
        {
        ?>
        <div class="config_properties-block">
            <table class="config_title-table">
                <tr>
                    <td><?= $num ?>)</td>
                    <td>ID: n/a</td>
                    <td class="fail"><?= $cpu_error ?></td>
                    <td>
                        <a class="config_button-under-units
                        <?= (isset($cpu) && $cpus->count() >= $motherboard->soc_count) || isset($mb_error)
                        ? ' config_link-deactivate' : '' ?>"
                        href="/cpus/choice/<?= $id ?>/install/">Установить</a>
                    </td>
                    <td><a class="config_button-under-units
                        <?= isset($mb_error) || isset($cpu_error)
                        ? ' config_link-deactivate' : '' ?>"
                        href="/cpus/choice/<?= $id ?>/replace/<?= isset($cpu) ? $cpu->cpu_id : '' ?>/cpu">Заменить</a>
                    </td>
                    <td>
                        <a class="config_button-under-units
                        <?= isset($cpu_error)
                        ? ' config_link-deactivate' : '' ?>"
                        href="/sysunits/operations/<?= $id ?>/deinstall/<?= isset($cpu) ? $cpu->cpu_id : '' ?>/cpu">Снять</a>
                    </td>
                </tr>
            </table>
            <table class="config_properties-table">
                <tr>
                    <th>Частота</th>
                    <th>Ядер/Потоков</th>
                    <th>Сокет</th>
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



    <div class="config_one-unit-block">
        <div class="config_title-block">
            <div class="config_title">Оперативная память</div>
        </div>
        <?php
        $num = 0;
        if ($rams->count() == 0)
        {
            $ram_error   = "Отсутствует!";
        
        } elseif (isset($motherboard) && $rams->count() > $motherboard->slot_count)
        {
            $ram_error   = "Ошибка! Этому сист.блоку принадлежит больше модулей ОЗУ, чем слотов на мат.плате!";

        } else
        {
            foreach ($rams as $ram)
            {
        ?>
        <div class="config_properties-block">
            <table class="config_title-table">
                <tr>
                    <td><?= $num ?>)</td>
                    <td>ID: <?= $ram->ram_id ?></td>
                    <td><?= $ram->vendor->vendor_name.' '. $ram->model ?>
                    </td>
                    <td>
                        <a class="config_button-under-units
                        <?= ((isset($ram) && isset($motherboard)) && $rams->count() >= $motherboard->slot_count) || isset($mb_error)
                        ? ' config_link-deactivate' : '' ?>"
                        href="/rams/choice/<?= $id ?>/install">Установить</a>
                    </td>
                    <td><a class="config_button-under-units
                        <?= isset($mb_error) || isset($ram_error)
                        ? ' config_link-deactivate' : '' ?>"
                        href="/rams/choice/<?= $id ?>/replace/<?= isset($ram) ? $ram->ram_id : '' ?>/ram">Заменить</a>
                    </td>
                    <td>
                        <a class="config_button-under-units
                        <?= isset($mb_error) || isset($ram_error)
                        ? ' config_link-deactivate' : '' ?>"
                        href="/sysunits/operations/<?= $id ?>/deinstall/<?= isset($ram) ? $ram->ram_id : '' ?>/ram">Снять</a>
                    </td>
                </tr>
            </table>
            <table class="config_properties-table">
                <tr>
                    <th>Объём</th>
                    <th>Тип</th>
                    <th>Частота</th>
                    <th>Формфактор</th>
                    <th>Локация</th>
                    <th>Статус</th>
                    <th>Заметка</th>
                </tr>
                <tr>
                    <td>
                        <?php
                            if ($ram->size > 0)
                            {
                                if ($ram->size < 1024)
                                {
                                    echo $ram->size.'MB';

                                } else
                                {   
                                    $capacity_tb = $ram->size/1024;
                                    echo $capacity_tb.'GB';
                                }
                            }
                        ?>
                    </td>
                    <td><?= $ram->ramtype->ramtype_name     ?></td>
                    <td><?= $ram->speed                     ?>MHz</td>
                    <td><?= $ram->formfactor                ?></td>
                    <td><?= $ram->location->location_name   ?></td>
                    <td><?= $ram->status->status_name       ?></td>
                    <td><?= $ram->note                      ?></td>
                </tr>
            </table>
        </div>
        <?php
                $num++;
            }
        }
        if (isset($ram_error))
        {
        ?>
        <div class="config_properties-block">
            <table class="config_title-table">
                <tr>
                    <td><?= $num ?>)</td>
                    <td>ID: n/a</td>
                    <td class="fail"><?= $ram_error ?></td>
                    <td>
                        <a class="config_button-under-units
                        <?= ((isset($ram) && isset($motherboard)) && $rams->count() >= $motherboard->slot_count) || isset($mb_error)
                        ? ' config_link-deactivate' : '' ?>"
                        href="/rams/choice/<?= $id ?>/install">Установить</a>
                    </td>
                    <td><a class="config_button-under-units
                        <?= isset($mb_error) || isset($ram_error)
                        ? ' config_link-deactivate' : '' ?>"
                        href="/rams/choice/<?= $id ?>/replace/<?= isset($ram) ? $ram->ram_id : '' ?>/ram">Заменить</a>
                    </td>
                    <td>
                        <a class="config_button-under-units
                        <?= isset($mb_error) || isset($ram_error)
                        ? ' config_link-deactivate' : '' ?>"
                        href="/sysunits/operations/<?= $id ?>/deinstall/<?= isset($ram) ? $ram->ram_id : '' ?>/ram">Снять</a>
                    </td>
                </tr>
            </table>
            <table class="config_properties-table">
                <tr>
                    <th>Объём</th>
                    <th>Тип</th>
                    <th>Частота</th>
                    <th>Формфактор</th>
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



    <div class="config_one-unit-block">
        <div class="config_title-block">
            <div class="config_title">Видеокарты</div>
        </div>
        <?php
        $num = 0;
        if ($videocards->count() == 0)
        {
            $vc_error   = "Отсутствует!";
        
        } //elseif ($videocards->count() > $motherboard->slot_count)
        // {
        //     $vc_error   = "Ошибка! Этому сист.блоку принадлежит больше видеокарт, чем слотов на мат.плате!";
        // }
        else
        {
            foreach ($videocards as $videocard)
            {
        ?>
        <div class="config_properties-block">
            <table class="config_title-table">
                <tr>
                    <td><?= $num ?>)</td>
                    <td>ID: <?= $videocard->vc_id ?></td>
                    <td><?= $videocard->vendor->vendor_name.' ' ?>
                        <?php
                        if ($videocard->gpu_vendor == 'N')
                        {
                            echo "NVIDIA ";

                        } elseif ($videocard->gpu_vendor == "A")
                        {
                            echo "AMD ";
                        }
                        ?>
                        <?= $videocard->model ?></td>
                    <td>
                        <a class="config_button-under-units
                        <?= ((isset($videocards) && isset($motherboard)) &&
                        $videocards->count() >= $motherboard->slot_count) || isset($mb_error)
                        ? ' config_link-deactivate' : '' ?>"
                        href="/videocards/choice/<?= $id ?>/install">Установить</a>
                    </td>
                    <td><a class="config_button-under-units
                        <?= isset($mb_error) || isset($vc_error)
                        ? ' config_link-deactivate' : '' ?>"
                        href="/videocards/choice/<?= $id ?>/replace/<?= isset($videocard) ? $videocard->vc_id : '' ?>/videocard">Заменить</a>
                    </td>
                    <td>
                        <a class="config_button-under-units
                        <?= isset($vc_error) ? ' config_link-deactivate' : '' ?>"
                        href="/sysunits/operations/<?= $id ?>/deinstall/<?= isset($videocard) ? $videocard->vc_id : '' ?>/videocard">Снять</a>
                    </td>
                </tr>
            </table>
            <table class="config_properties-table">
                <tr>
                    <th>Объём видеопамяти</th>
                    <th>Локация</th>
                    <th>Статус</th>
                    <th>Заметка</th>
                </tr>
                <tr>
                    <td>
                        <?php
                            if ($videocard->mem_capacity > 0)
                            {
                                if ($videocard->mem_capacity < 1024)
                                {
                                    echo $videocard->mem_capacity.'MB';

                                } else
                                {   
                                    $capacity_tb = $videocard->mem_capacity/1024;
                                    echo $capacity_tb.'GB';
                                }
                            }
                        ?>
                    </td>
                    <td><?= $videocard->location->location_name ?></td>
                    <td><?= $videocard->status->status_name ?></td>
                    <td><?= $videocard->note ?></td>
                </tr>
            </table>
        </div>
        <?php
                $num++;
            }
        }
        if (isset($vc_error))
        {
        ?>
        <div class="config_properties-block">
            <table class="config_title-table">
                <tr>
                    <td><?= $num ?>)</td>
                    <td>ID: n/a</td>
                    <td class="fail"><?= $vc_error ?></td>
                    <td>
                        <a class="config_button-under-units
                        <?= ((isset($videocards) && isset($motherboard)) &&
                        $videocards->count() >= $motherboard->slot_count) || isset($mb_error)
                        ? ' config_link-deactivate' : '' ?>"
                        href="/videocards/choice/<?= $id ?>/install">Установить</a>
                    </td>
                    <td><a class="config_button-under-units
                        <?= isset($mb_error) || isset($vc_error)
                        ? ' config_link-deactivate' : '' ?>"
                        href="/videocards/choice/<?= $id ?>/replace/<?= isset($videocard) ? $videocard->vc_id : '' ?>/videocard">Заменить</a>
                    </td>
                    <td>
                        <a class="config_button-under-units
                        <?= isset($vc_error) ? ' config_link-deactivate' : '' ?>"
                        href="/sysunits/operations/<?= $id ?>/deinstall/<?= isset($videocard) ? $videocard->vc_id : '' ?>/videocard">Снять</a>
                    </td>
                </tr>
            </table>
            <table class="config_properties-table">
                <tr>
                    <th>Объём видеопамяти</th>
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



    <div class="config_one-unit-block">
        <div class="config_title-block">
            <div class="config_title">Накопители</div>
        </div>
        <?php
        $num = 0;
        if ($storages->count() == 0)
        {
            $storage_error   = "Отсутствует!";
        
        } //elseif ($storages->count() > $motherboard->slot_count)
        //{
            //$storage_error   = "Ошибка! Этому сист.блоку принадлежит больше модулей ОЗУ, чем слотов на мат.плате!";
        //}
        else
        {
            foreach ($storages as $storage)
            {
        ?>
        <div class="config_properties-block">
            <table class="config_title-table">
                <tr>
                    <td><?= $num ?>)</td>
                    <td>ID: <?= $storage->storage_id ?></td>
                    <td><?= $storage->vendor->vendor_name.' '. $storage->model ?></td>
                    <td>
                        <a class="config_button-under-units
                        <?= ((isset($storage) && isset($motherboard)) && $storages->count() >= $motherboard->slot_count) || isset($mb_error)
                        ? ' config_link-deactivate' : '' ?>"
                        href="/storages/choice/<?= $id ?>/install">Установить</a>
                    </td>
                    <td><a class="config_button-under-units
                        <?= isset($mb_error) || isset($storage_error)
                        ? ' config_link-deactivate' : '' ?>"
                        href="/storages/choice/<?= $id ?>/replace/<?= isset($storage) ? $storage->storage_id : '' ?>/storage">Заменить</a>
                    </td>
                    <td>
                        <a class="config_button-under-units
                        <?= isset($mb_error) || isset($storage_error)
                        ? ' config_link-deactivate' : '' ?>"
                        href="/sysunits/operations/<?= $id ?>/deinstall/<?= isset($storage) ? $storage->storage_id : '' ?>/storage">Снять</a>
                    </td>
                </tr>
            </table>
            <table class="config_properties-table">
                <tr>
                    <th>Объём</th>
                    <th>Тип порта</th>
                    <th>Формфактор</th>
                    <th>Локация</th>
                    <th>Статус</th>
                    <th>Заметка</th>
                </tr>
                <tr>
                    <td>
                        <?php
                            if ($storage->capacity > 0)
                            {
                                if ($storage->capacity < 1024)
                                {
                                    echo $storage->capacity.'GB';

                                } else
                                {   
                                    $capacity_tb = $storage->capacity/1024;
                                    echo $capacity_tb.'TB';
                                }
                            }
                        ?>
                    </td>
                    <td><?= isset($storage) ? $storage->interface               : '' ?></td>
                    <td><?= isset($storage) ? $storage->formfactor              : '' ?></td>
                    <td><?= isset($storage) ? $storage->location->location_name : '' ?></td>
                    <td><?= isset($storage) ? $storage->status->status_name     : '' ?></td>
                    <td><?= isset($storage) ? $storage->note                    : '' ?></td>
                </tr>
            </table>
        </div>
        <?php
                $num++;
            }
        }
        if (isset($storage_error))
        {
        ?>
        <div class="config_properties-block">
            <table class="config_title-table">
                <tr>
                    <td><?= $num ?>)</td>
                    <td>ID: 'n/a'</td>
                    <td class="fail"><?= $storage_error ?></td>
                    <td>
                        <a class="config_button-under-units
                        <?= ((isset($storage) && isset($motherboard)) && $storages->count() >= $motherboard->slot_count) || isset($mb_error)
                        ? ' config_link-deactivate' : '' ?>"
                        href="/storages/choice/<?= $id ?>/install">Установить</a>
                    </td>
                    <td><a class="config_button-under-units
                        <?= isset($mb_error) || isset($storage_error)
                        ? ' config_link-deactivate' : '' ?>"
                        href="/storages/choice/<?= $id ?>/replace/<?= isset($storage) ? $storage->storage_id : '' ?>/storage">Заменить</a>
                    </td>
                    <td>
                        <a class="config_button-under-units
                        <?= isset($mb_error) || isset($storage_error)
                        ? ' config_link-deactivate' : '' ?>"
                        href="/sysunits/operations/<?= $id ?>/deinstall/<?= isset($storage) ? $storage->storage_id : '' ?>/storage">Снять</a>
                    </td>
                </tr>
            </table>
            <table class="config_properties-table">
                <tr>
                    <th>Объём, GB</th>
                    <th>Тип порта</th>
                    <th>Формфактор</th>
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



    <div class="config_one-unit-block">
        <div class="config_title-block">
            <div class="config_title">Блок питания</div>
        </div>
        <?php
        if ($pwrsupplies->count() == 0)
        {
            $ps_error   = "Отсутствует!";
        
        } elseif ($pwrsupplies->count() > 1)
        {
            $ps_error   = "Ошибка! Этому сист.блоку принадлежит больше одного блока питания!";
        
        } else
        {
            foreach ($pwrsupplies as $pwrsupply)
            {
        ?>
        <div class="config_properties-block">
            <table class="config_title-table">
                <tr>
                    <td>ID: <?= $pwrsupply->ps_id ?></td>
                    <td><?= $pwrsupply->vendor->vendor_name.'  '.$pwrsupply->model ?></td>
                    <td>
                        <a class="config_button-under-units
                        <?= isset($pwrsupply) ? ' config_link-deactivate' : '' ?>"
                        href="/pwrsupplies/choice/<?= $id ?>/install">Установить</a>
                    </td>
                    <td><a class="config_button-under-units
                        <?= !isset($pwrsupply) ? ' config_link-deactivate' : '' ?>"
                        href="/pwrsupplies/choice/<?= $id ?>/replace/<?= isset($pwrsupply) ? $pwrsupply->ps_id : '' ?>/pwrsupply">Заменить</a>
                    </td>
                    <td>
                        <a class="config_button-under-units
                        <?= !isset($pwrsupply) ? ' config_link-deactivate' : '' ?>"
                        href="/sysunits/operations/<?= $id ?>/deinstall/<?= isset($pwrsupply) ? $pwrsupply->ps_id : '' ?>/pwrsupply">Снять</a>
                    </td>
                </tr>
            </table>
            <table class="config_properties-table">
                <tr>
                    <th>Мощность, Вт</th>
                    <th>Локация</th>
                    <th>Статус</th>
                    <th>Заметка</th>
                </tr>
                <tr>
                    <td><?= isset($pwrsupply) ? $pwrsupply->power : '' ?></td>
                    <td><?= isset($pwrsupply) ? $pwrsupply->location->location_name : '' ?></td>
                    <td><?= isset($pwrsupply) ? $pwrsupply->status->status_name : '' ?></td>
                    <td><?= isset($pwrsupply) ? $pwrsupply->note : '' ?></td>
                </tr>
            </table>
        </div>
        <?php
            }
        }
        if (isset($ps_error))
        {
        ?>
        <div class="config_properties-block">
            <table class="config_title-table">
                <tr>
                    <td>ID: n/a</td>
                    <td class="fail"><?= $ps_error ?></td>
                    <td>
                        <a class="config_button-under-units
                        <?= isset($pwrsupply) ? ' config_link-deactivate' : '' ?>"
                        href="/pwrsupplies/choice/<?= $id ?>/install">Установить</a>
                    </td>
                    <td><a class="config_button-under-units
                        <?= !isset($pwrsupply) ? ' config_link-deactivate' : '' ?>"
                        href="/pwrsupplies/choice/<?= $id ?>/replace/<?= isset($pwrsupply) ? $pwrsupply->ps_id : '' ?>/pwrsupply">Заменить</a>
                    </td>
                    <td>
                        <a class="config_button-under-units
                        <?= !isset($pwrsupply) ? ' config_link-deactivate' : '' ?>"
                        href="/sysunits/operations/<?= $id ?>/deinstall/<?= isset($pwrsupply) ? $pwrsupply->ps_id : '' ?>/pwrsupply">Снять</a>
                    </td>
                </tr>
            </table>
            <table class="config_properties-table">
                <tr>
                    <th>Мощность, Вт</th>
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