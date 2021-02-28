<?php extract($def_vars); ?>

<h2><?php echo $title; ?></h2>

<div class="block_table_under_form">
    <table class="table_under_form">
        <tr>
            <th>ID</th>
            <th><?php echo isset($field_devtype)    ? $field_devtype    : ''; ?></th>
            <th><?php echo isset($field_vendor)     ? $field_vendor     : ''; ?></th>
            <th><?php echo isset($field_model)      ? $field_model      : ''; ?></th>
            <th><?php echo isset($field_format)     ? $field_format     : ''; ?></th>
            <th><?php echo isset($field_print_tech) ? $field_print_tech : ''; ?></th>
            <th><?php echo isset($field_print_color)? $field_print_color: ''; ?></th>
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
        <?php foreach ($offequipments as $offequipment): ?>
            <tr>
                <?='<td>'.$offequipment->$id_column.'</td>'?>
                <?='<td>'.$offequipment->devtype->devtype_name.'</td>'?>
                <?='<td>'.$offequipment->vendor->vendor_name.'</td>'?>
                <?='<td>'.$offequipment->model.'</td>'?>
                <?='<td>'.$offequipment->format.'</td>'?>
                <?php
                echo '<td>';
                foreach ($select_print_tech as $pt_key => $pt_val)
                {
                    if ($offequipment->print_tech == $pt_key) echo $pt_val;
                }
                echo '</td>';
                echo '<td>';
                foreach ($select_print_color as $pc_key => $pc_val)
                {
                    if ($offequipment->print_color == $pc_key) echo $pc_val;
                }
                echo '</td>';
                ?>
                <?='<td>'.$offequipment->location->location_name.'</td>'?>
                <?='<td>'.$offequipment->status->status_name.'</td>'?>
                <?='<td>'.$offequipment->workplace->wp_name.'</td>'?>
                <?='<td>'.$offequipment->fa.'</td>'?>
                <?='<td>'.$offequipment->inv_num.'</td>'?>
                <?php
                    echo $offequipment->inv_status == 'G' ?
                    '<td>Числится</td>' :
                    '<td>Не числится</td>';
                ?>
                <?php
                    echo is_null($offequipment->com_date) ?
                    '<td></td>' : 
                    '<td>'.date("d.m.Y", $offequipment->com_date).'</td>';
                ?>
                <?='<td>'.$offequipment->note.'</td>'?>
                <td><a href="/workplaces/operations/<?= $wp_id ?>/<?= $operation ?>/<?= $offequipment->oe_id ?>/offequipment/<?= $old_id ?>">Выбрать</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>