<?php extract($def_vars); ?>

<h2><?php echo $title; ?></h2>

<div class="block_table_under_form">
    <table class="table_under_form">
        <tr>
            <th>ID</th>
            <th><?php echo isset($field_devtype)        ? $field_devtype        : ''; ?></th>
            <th><?php echo isset($field_vendor)         ? $field_vendor         : ''; ?></th>
            <th><?php echo isset($field_model)          ? $field_model          : ''; ?></th>
            <th><?php echo isset($field_clock_speed)    ? $field_clock_speed    : ''; ?></th>
            <th><?php echo isset($field_cores_threads)  ? $field_cores_threads  : ''; ?></th>
            <th><?php echo isset($field_socket)         ? $field_socket         : ''; ?></th>
            <th><?php echo isset($field_location)       ? $field_location       : ''; ?></th>
            <th><?php echo isset($field_status)         ? $field_status         : ''; ?></th>
            <th><?php echo isset($field_sysunit)        ? $field_sysunit        : ''; ?></th>
            <th><?php echo isset($field_note)           ? $field_note           : ''; ?></th>
            <th>Действия</th>
        </tr>
        <?php foreach ($cpus as $cpu): ?>
            <tr>
                <?='<td>'.$cpu->$id_column.                             '</td>'?>
                <?='<td>'.$cpu->devtype->devtype_name.                  '</td>'?>
                <?='<td>'.$cpu->vendor->vendor_name.                    '</td>'?>
                <?='<td>'.$cpu->model.                                  '</td>'?>
                <?='<td>'.number_format($cpu->clock_speed, 2, '.', ''). ' GHz</td>'?>
                <?='<td>'.$cpu->cores_threads.                          '</td>'?>
                <?='<td>'.$cpu->socket->socket.                         '</td>'?>
                <?='<td>'.$cpu->location->location_name.                '</td>'?>
                <?='<td>'.$cpu->status->status_name.                    '</td>'?>
                <?='<td>'.$cpu->su_id.                                  '</td>'?>
                <?='<td>'.$cpu->note.                                   '</td>'?>
                <td><a href="/sysunits/operations/<?= $su_id ?>/<?= $operation ?>/<?= $cpu->cpu_id ?>/cpu/<?= $old_id ?>">Выбрать</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>