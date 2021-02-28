<?php extract($def_vars); ?>

<h2><?php echo $title; ?></h2>

<div class="block_table_under_form">
    <table class="table_under_form">
        <tr>
            <th>ID</th>
            <th><?php echo isset($field_devtype)    ? $field_devtype    : ''; ?></th>
            <th><?php echo isset($field_vendor)     ? $field_vendor     : ''; ?></th>
            <th><?php echo isset($field_model)      ? $field_model      : ''; ?></th>
            <th><?php echo isset($field_bat_id)     ? $field_bat_id     : ''; ?></th>
            <th><?php echo isset($field_bat_count)  ? $field_bat_count  : ''; ?></th>
            <th><?php echo isset($field_location)   ? $field_location   : ''; ?></th>
            <th><?php echo isset($field_status)     ? $field_status     : ''; ?></th>
            <th><?php echo isset($field_workplace)  ? $field_workplace  : ''; ?></th>
            <th><?php echo isset($field_fa)         ? $field_fa         : ''; ?></th>
            <th><?php echo isset($field_inv_num)    ? $field_inv_num    : ''; ?></th>
            <th><?php echo isset($field_inv_status) ? $field_inv_status : ''; ?></th>
            <th><?php echo isset($field_com_date)   ? $field_com_date   : ''; ?></th>
            <th><?php echo isset($field_note)       ? $field_note       : ''; ?></th>
            <th colspan="2">Действия</th>
        </tr>
        <?php foreach ($upses as $ups): ?>
            <tr>
                <?='<td>'.$ups->$id_column.'</td>'?>
                <?='<td>'.$ups->devtype->devtype_name.'</td>'?>
                <?='<td>'.$ups->vendor->vendor_name.'</td>'?>
                <?='<td>'.$ups->model.'</td>'?>
                <?php
                echo '<td>';
                if ($ups->battery->bat_voltage && $ups->battery->bat_capacity)
                {
                    echo $ups->battery->bat_voltage.'V - '.$ups->battery->bat_capacity.'A/h';
                }
                echo '</td>';
                ?>
                <?='<td>'.$ups->bat_count.'</td>'?>
                <?='<td>'.$ups->location->location_name.'</td>'?>
                <?='<td>'.$ups->status->status_name.'</td>'?>
                <?='<td>'.$ups->workplace->wp_name.'</td>'?>
                <?='<td>'.$ups->fa.'</td>'?>
                <?='<td>'.$ups->inv_num.'</td>'?>
                <?php
                    echo $ups->inv_status == 'G' ?
                    '<td>Числится</td>' :
                    '<td>Не числится</td>';
                ?>
                <?php
                    echo is_null($ups->com_date) ?
                    '<td></td>' : 
                    '<td>'.date("d.m.Y", $ups->com_date).'</td>';
                ?>
                <?='<td>'.$ups->note.'</td>'?>
                <td><a href="/workplaces/operations/<?= $wp_id ?>/<?= $operation ?>/<?= $ups->ups_id ?>/ups/<?= $old_id ?>">Выбрать</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>