<?php extract($def_vars); ?>

<h2><?php echo $title; ?></h2>

<div class="block_table_under_form">
    <table class="table_under_form">
        <tr>
            <th>ID</th>
            <th><?php echo isset($field_devtype)    ? $field_devtype    : ''; ?></th>
            <th><?php echo isset($field_vendor)     ? $field_vendor     : ''; ?></th>
            <th><?php echo isset($field_model)      ? $field_model      : ''; ?></th>
            <th><?php echo isset($field_capacity)   ? $field_capacity   : ''; ?></th>
            <th><?php echo isset($field_interface)  ? $field_interface  : ''; ?></th>
            <th><?php echo isset($field_formfactor) ? $field_formfactor : ''; ?></th>
            <th><?php echo isset($field_location)   ? $field_location   : ''; ?></th>
            <th><?php echo isset($field_status)     ? $field_status     : ''; ?></th>
            <th><?php echo isset($field_sysunit)    ? $field_sysunit    : ''; ?></th>
            <th><?php echo isset($field_note)       ? $field_note       : ''; ?></th>
            <th>Действия</th>
        </tr>
        <?php foreach ($storages as $storage): ?>
            <tr>
                <?='<td>'.$storage->$id_column.             '</td>'?>
                <?='<td>'.$storage->devtype->devtype_name.  '</td>'?>
                <?='<td>'.$storage->vendor->vendor_name.    '</td>'?>
                <?='<td>'.$storage->model.                  '</td>'?>
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
                <?='<td>'.$storage->interface.              '</td>'?>
                <td>
                    <?php
                        if ($storage->formfactor != 0) echo $storage->formfactor;
                    ?>
                </td>
                <?='<td>'.$storage->location->location_name.'</td>'?>
                <?='<td>'.$storage->status->status_name.    '</td>'?>
                <?='<td>'.$storage->su_id.                  '</td>'?>
                <?='<td>'.$storage->note.                   '</td>'?>
                <td><a href="/sysunits/operations/<?= $su_id ?>/<?= $operation ?>/<?= $storage->storage_id ?>/storage/<?= $old_id ?>">Выбрать</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>