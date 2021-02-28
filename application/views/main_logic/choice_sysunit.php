<?php extract($def_vars); ?>

<h2><?php echo $title; ?></h2>

<div class="block_table_under_form">
    <table class="table_under_form">
        <tr>
            <th>ID</th>
            <th><?php echo isset($field_devtype) ? $field_devtype : ''; ?></th>
            <th><?php echo isset($field_vendor) ? $field_vendor : ''; ?></th>
            <th><?php echo isset($field_model) ? $field_model : ''; ?></th>
            <th><?php echo isset($field_location) ? $field_location : ''; ?></th>
            <th><?php echo isset($field_status) ? $field_status : ''; ?></th>
            <th><?php echo isset($field_workplace) ? $field_workplace : ''; ?></th>
            <th><?php echo isset($field_fa) ? $field_fa : ''; ?></th>
            <th><?php echo isset($field_inv_num) ? $field_inv_num : ''; ?></th>
            <th><?php echo isset($field_inv_status) ? $field_inv_status : ''; ?></th>
            <th><?php echo isset($field_com_date) ? $field_com_date : ''; ?></th>
            <th><?php echo isset($field_note) ? $field_note : ''; ?></th>
            <th colspan="3">Действия</th>
        </tr>
        <?php foreach ($sysunits as $sysunit): ?>
            <tr>
                <?='<td>'.$sysunit->$id_column.'</td>'?>
                <?='<td>'.$sysunit->devtype->devtype_name.'</td>'?>
                <?='<td>'.$sysunit->vendor->vendor_name.'</td>'?>
                <?='<td>'.$sysunit->model.'</td>'?>
                <?='<td>'.$sysunit->location->location_name.'</td>'?>
                <?='<td>'.$sysunit->status->status_name.'</td>'?>
                <?='<td>'.$sysunit->workplace->wp_name.'</td>'?>
                <?='<td>'.$sysunit->fa.'</td>'?>
                <?='<td>'.$sysunit->inv_num.'</td>'?>
                <?php
                    echo $sysunit->inv_status == 'G' ?
                    '<td>Числится</td>' :
                    '<td>Не числится</td>';
                ?>
                <?php
                    echo is_null($sysunit->com_date) ?
                    '<td></td>' : 
                    '<td>'.date("d.m.Y", $sysunit->com_date).'</td>';
                ?>
                <?='<td>'.$sysunit->note.'</td>'?>
                <td><a href="/workplaces/operations/<?= $wp_id ?>/<?= $operation ?>/<?= $sysunit->su_id ?>/sysunit/<?= $old_id ?>">Выбрать</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>