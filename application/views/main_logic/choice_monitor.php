<?php extract($def_vars); ?>

<h2><?php echo $title; ?></h2>

<div class="block_table_under_form">
    <table class="table_under_form">
        <tr>
            <th>ID</th>
            <th><?php echo isset($field_devtype)    ? $field_devtype    : ''; ?></th>
            <th><?php echo isset($field_vendor)     ? $field_vendor     : ''; ?></th>
            <th><?php echo isset($field_model)      ? $field_model      : ''; ?></th>
            <th><?php echo isset($field_diagonal)   ? $field_diagonal   : ''; ?></th>
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
        <?php foreach ($monitors as $monitor): ?>
            <tr>
                <?='<td>'.$monitor->mon_id.'</td>'?>
                <?='<td>'.$monitor->devtype->devtype_name.'</td>'?>
                <?='<td>'.$monitor->vendor->vendor_name.'</td>'?>
                <?='<td>'.$monitor->model.'</td>'?>
                <?='<td>'.$monitor->diagonal.'</td>'?>
                <?='<td>'.$monitor->location->location_name.'</td>'?>
                <?='<td>'.$monitor->status->status_name.'</td>'?>
                <?='<td>'.$monitor->workplace->wp_id.'</td>'?>
                <?='<td>'.$monitor->fa.'</td>'?>
                <?='<td>'.$monitor->inv_num.'</td>'?>
                <?php
                    echo $monitor->inv_status == 'G' ?
                    '<td>Числится</td>' :
                    '<td>Не числится</td>';
                ?>
                <?php
                    echo is_null($monitor->com_date) ?
                    '<td></td>' : 
                    '<td>'.date("d.m.Y", $monitor->com_date).'</td>';
                ?>
                <?='<td>'.$monitor->note.'</td>'?>
                <?='<td><a href="/workplaces/operations/'.$wp_id.'/'.$operation.'/'.$monitor->mon_id.'/monitor/'.$old_id.'">Выбрать</a></td>'?>
            </tr>
        <?php endforeach; ?>
    </table>
</div>