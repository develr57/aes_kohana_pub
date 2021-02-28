<?php extract($def_vars); ?>

<h2><?php echo $title; ?></h2>

<div class="block_table_under_form">
    <table class="table_under_form">
        <tr>
            <th>ID</th>
            <th><?php echo isset($field_devtype)    ? $field_devtype    : ''; ?></th>
            <th><?php echo isset($field_vendor)     ? $field_vendor     : ''; ?></th>
            <th><?php echo isset($field_model)      ? $field_model      : ''; ?></th>
            <th><?php echo isset($field_size)       ? $field_size       : ''; ?></th>
            <th><?php echo isset($field_ramtype)    ? $field_ramtype    : ''; ?></th>
            <th><?php echo isset($field_speed)      ? $field_speed      : ''; ?></th>
            <th><?php echo isset($field_formfactor) ? $field_formfactor : ''; ?></th>
            <th><?php echo isset($field_location)   ? $field_location   : ''; ?></th>
            <th><?php echo isset($field_status)     ? $field_status     : ''; ?></th>
            <th><?php echo isset($field_sysunit)    ? $field_sysunit    : ''; ?></th>
            <th><?php echo isset($field_note)       ? $field_note       : ''; ?></th>
            <th>Действия</th>
        </tr>
        <?php foreach ($rams as $ram): ?>
            <tr>
                <?='<td>'.$ram->$id_column.             '</td>'?>
                <?='<td>'.$ram->devtype->devtype_name.  '</td>'?>
                <?='<td>'.$ram->vendor->vendor_name.    '</td>'?>
                <?='<td>'.$ram->model.                  '</td>'?>
                <?php
                    echo '<td>';
                    if ($ram->size < 1024)
                    {
                        echo $ram->size.'MB';

                    } else
                    {   
                        $size_gb = $ram->size/1024;
                        echo $size_gb.'GB';
                    }
                    echo '</td>';                              ?>
                <?='<td>'.$ram->ramtype->ramtype_name.  '</td>'?>
                <?='<td>'.$ram->speed.                  '</td>'?>
                <?='<td>'.$ram->formfactor.             '</td>'?>
                <?='<td>'.$ram->location->location_name.'</td>'?>
                <?='<td>'.$ram->status->status_name.    '</td>'?>
                <?='<td>'.$ram->su_id.                  '</td>'?>
                <?='<td>'.$ram->note.                   '</td>'?>
                <td><a href="/sysunits/operations/<?= $su_id ?>/<?= $operation ?>/<?= $ram->ram_id ?>/ram/<?= $old_id ?>">Выбрать</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>