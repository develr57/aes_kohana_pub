<?php extract($def_vars); ?>

<h2><?php echo $title; ?></h2>

<div class="block_table_under_form">
    <table class="table_under_form">
        <tr>
            <th>ID</th>
            <th><?php echo isset($field_devtype)    ? $field_devtype    : ''; ?></th>
            <th><?php echo isset($field_vendor)     ? $field_vendor     : ''; ?></th>
            <th><?php echo isset($field_model)      ? $field_model      : ''; ?></th>
            <th><?php echo isset($field_socket)     ? $field_socket     : ''; ?></th>
            <th><?php echo isset($field_soc_count)  ? $field_soc_count  : ''; ?></th>
            <th><?php echo isset($field_ramtype)    ? $field_ramtype    : ''; ?></th>
            <th><?php echo isset($field_slot_count) ? $field_slot_count : ''; ?></th>
            <th><?php echo isset($field_video_out)  ? $field_video_out  : ''; ?></th>
            <th><?php echo isset($field_location)   ? $field_location   : ''; ?></th>
            <th><?php echo isset($field_status)     ? $field_status     : ''; ?></th>
            <th><?php echo isset($field_sysunit)    ? $field_sysunit    : ''; ?></th>
            <th><?php echo isset($field_note)       ? $field_note       : ''; ?></th>
            <th>Действие</th>
        </tr>
        <?php foreach ($motherboards as $motherboard): ?>
            <tr>
                <?='<td>'.$motherboard->$id_column.             '</td>'?>
                <?='<td>'.$motherboard->devtype->devtype_name.  '</td>'?>
                <?='<td>'.$motherboard->vendor->vendor_name.    '</td>'?>
                <?='<td>'.$motherboard->model.                  '</td>'?>
                <?='<td>'.$motherboard->socket->socket.         '</td>'?>
                <?='<td>'.$motherboard->soc_count.              '</td>'?>
                <?='<td>'.$motherboard->ramtype->ramtype_name.  '</td>'?>
                <?='<td>'.$motherboard->slot_count.             '</td>'?>
                <?php
                echo '<td>';
                foreach ($select_video_out as $vo_key => $vo_val)
                {
                    if ($motherboard->video_out == $vo_key) echo $vo_val;
                }
                echo '</td>';
                ?>
                <?='<td>'.$motherboard->location->location_name.'</td>'?>
                <?='<td>'.$motherboard->status->status_name.    '</td>'?>
                <?='<td>'.$motherboard->su_id.                  '</td>'?>
                <?='<td>'.$motherboard->note.                   '</td>'?>
                <td><a href="/sysunits/operations/<?= $su_id ?>/<?= $operation ?>/<?= $motherboard->mb_id ?>/motherboard/<?= $old_id ?>">Выбрать</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>